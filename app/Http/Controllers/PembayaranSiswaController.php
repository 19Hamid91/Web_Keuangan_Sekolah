<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\Instansi;
use App\Models\Jurnal;
use App\Models\Kelas;
use App\Models\PembayaranSiswa;
use App\Models\Siswa;
use App\Models\TagihanSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PembayaranSiswaController extends Controller
{
    public function daftar($instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $tingkats = Kelas::where('instansi_id', $data_instansi->id)
            ->groupBy('tingkat')
            ->pluck('tingkat');

        $dataKelas = Kelas::withCount(['siswa' => function ($query) {
                $query->doesntHave('kelulusan');
            }])
            ->where('instansi_id', $data_instansi->id)
            ->whereIn('tingkat', $tingkats)
            ->get();

        $siswaCount = [];
        foreach ($dataKelas as $kelas) {
            $siswaCount[$kelas->tingkat] = $kelas->siswa_count;
        }
        return view('pembayaran_siswa.daftar', compact('siswaCount'));
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($instansi, $kelas)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $data = PembayaranSiswa::whereHas('siswa', function($q) use($kelas){
            $q->whereHas('kelas', function($p) use($kelas){
                $p->where('tingkat', $kelas);
            });
        })->orderByDesc('id')->get();
        return view('pembayaran_siswa.index', compact('kelas', 'data', 'data_instansi'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($instansi, $kelas)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $tagihan_siswa = TagihanSiswa::where('tingkat', $kelas)->get();
        $siswa = Siswa::whereHas('kelas', function($q) use($kelas){
            $q->where('tingkat', $kelas);
        })->get();
        $akun = Akun::where('instansi_id', $data_instansi->id)->whereIn('jenis', ['KAS', 'BANK', 'LIABILITAS JANGKA PENDEK', 'LIABILITAS JANGKA PANJANG'])->get();
        return view('pembayaran_siswa.create', compact('tagihan_siswa', 'siswa', 'kelas', 'akun'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req, $instansi, $kelas)
    {
        // validation
        $validator = Validator::make($req->all(), [
            'tagihan_siswa_id' => 'required|exists:t_tagihan_siswa,id',
            'siswa_id' => 'required|exists:t_siswa,id',
            'tanggal' => 'required|date',
            'total' => 'required|numeric',
            'sisa' => 'required',
            'tipe_pembayaran' => 'required',
            'akun_id' => 'required',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $isPaid = PembayaranSiswa::where('tagihan_siswa_id', $req->tagihan_siswa_id)->where('siswa_id', $req->siswa_id)->first();
        if($isPaid) return redirect()->back()->withInput()->with('fail', 'Siswa Sudah membayar');

        // save data
        $data = $req->except(['_method', '_token']);

        // file
        if ($req->hasFile('file')) {
            $file = $req->file('file');
            $tagihan = TagihanSiswa::find($req->tagihan_siswa_id);
            $jenis = str_replace(' ', '-', $tagihan->jenis_tagihan);
            $fileName = $jenis . '_' . date('YmdHis') . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('Bukti_Pengeluaran', $fileName, 'public');
            $data['file'] = $filePath;
        }

        $data['status'] = $data['sisa'] == 0 ? 'LUNAS' :'BELUM LUNAS';
        $check = PembayaranSiswa::create($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        // jurnal
        if($check->tagihan_siswa->jenis_tagihan == 'SPP'){
            $akunsppyayasan = Akun::where('instansi_id', 1)->where('jenis', 'PENDAPATAN')->where('nama', 'LIKE', '%SPP%')->first();
            $jurnalSPP = new Jurnal([
                'instansi_id' => 1,
                'keterangan' => 'Pembayaran: ' . $check->tagihan_siswa->jenis_tagihan,
                'nominal' => $check->total * 0.25,
                'akun_debit' => $data['akun_id'],
                'akun_kredit' => $akunsppyayasan->id,
                'tanggal' => $check->tanggal,
                
            ]);
            $check->journals()->save($jurnalSPP);

            $akunspp = Akun::where('instansi_id', $data_instansi->id)->where('jenis', 'PENDAPATAN')->where('nama', 'LIKE', '%SPP%')->first();
            $jurnal = new Jurnal([
                'instansi_id' => $check->siswa->instansi_id,
                'keterangan' => 'Pembayaran: ' . $check->tagihan_siswa->jenis_tagihan,
                'nominal' => $check->total * 0.75,
                'akun_debit' => $data['akun_id'],
                'akun_kredit' => $akunspp->id,
                'tanggal' => $check->tanggal,
                
            ]);
            $check->journals()->save($jurnal);
        } elseif($check->tagihan_siswa->jenis_tagihan == 'JPI'){
            $akunjpiyayasan = Akun::where('instansi_id', 1)->where('jenis', 'PENDAPATAN')->where('nama', 'LIKE', '%JPI%')->first();
            $jurnalJPI = new Jurnal([
                'instansi_id' => 1,
                'keterangan' => 'Pembayaran: ' . $check->tagihan_siswa->jenis_tagihan,
                'nominal' => $check->total,
                'akun_debit' => $data['akun_id'],
                'akun_kredit' => $akunjpiyayasan->id,
                'tanggal' => $check->tanggal,
                
            ]);
            $check->journals()->save($jurnalJPI);
        } elseif($check->tagihan_siswa->jenis_tagihan == 'Registrasi') {
            $akunreg = Akun::where('instansi_id', $data_instansi->id)->where('jenis', 'PENDAPATAN')->where('nama', 'LIKE', '%Registrasi%')->first();
            $jurnal = new Jurnal([
                'instansi_id' => $check->siswa->instansi_id,
                'keterangan' => 'Pembayaran: ' . $check->tagihan_siswa->jenis_tagihan,
                'nominal' => $check->total,
                'akun_debit' => $data['akun_id'],
                'akun_kredit' => $akunreg->id,
                'tanggal' => $check->tanggal,
                
            ]);
            $check->journals()->save($jurnal);
        } 
        // elseif($check->tagihan_siswa->jenis_tagihan == 'Outbond') {
        //     $akunreg = Akun::where('instansi_id', $data_instansi->id)->where('jenis', 'PENDAPATAN')->where('nama', 'LIKE', '%Outbond%')->first();
        //     $jurnal = new Jurnal([
        //         'instansi_id' => $check->siswa->instansi_id,
        //         'keterangan' => 'Pembayaran: ' . $check->tagihan_siswa->jenis_tagihan,
        //         'nominal' => $check->total,
        //         'akun_debit' => $data['akun_id'],
        //         'akun_kredit' => $akunreg->id,
        //         'tanggal' => $check->tanggal,
                
        //     ]);
        //     $check->journals()->save($jurnal);
        // } elseif($check->tagihan_siswa->jenis_tagihan == 'Overtime') {
        //     $akunreg = Akun::where('instansi_id', $data_instansi->id)->where('jenis', 'PENDAPATAN')->where('nama', 'LIKE', '%Overtime%')->first();
        //     $jurnal = new Jurnal([
        //         'instansi_id' => $check->siswa->instansi_id,
        //         'keterangan' => 'Pembayaran: ' . $check->tagihan_siswa->jenis_tagihan,
        //         'nominal' => $check->total,
        //         'akun_debit' => $data['akun_id'],
        //         'akun_kredit' => $akunreg->id,
        //         'tanggal' => $check->tanggal,
                
        //     ]);
        //     $check->journals()->save($jurnal);
        // }
        return redirect()->route('pembayaran_siswa.index', ['instansi' => $instansi, 'kelas' => $kelas])->with('success', 'Data berhasil ditambahkan');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PambayaranSiswa  $pambayaranSiswa
     * @return \Illuminate\Http\Response
     */
    public function show($instansi, $id, $kelas)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $tagihan_siswa = TagihanSiswa::where('kelas_id', $kelas)->get();
        $siswa = Siswa::where('kelas_id', $kelas)->get();
        $akun = Akun::where('instansi_id', $data_instansi->id)->whereIn('jenis', ['KAS', 'BANK', 'LIABILITAS JANGKA PENDEK', 'LIABILITAS JANGKA PANJANG'])->get();
        $data = PembayaranSiswa::find($id);
        return view('pembayaran_siswa.show', compact('tagihan_siswa', 'siswa', 'kelas', 'akun', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PambayaranSiswa  $pambayaranSiswa
     * @return \Illuminate\Http\Response
     */
    public function edit($instansi, $id, $kelas)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $tagihan_siswa = TagihanSiswa::where('kelas_id', $kelas)->get();
        $siswa = Siswa::where('kelas_id', $kelas)->get();
        $akun = Akun::where('instansi_id', $data_instansi->id)->whereIn('jenis', ['KAS', 'BANK', 'LIABILITAS JANGKA PENDEK', 'LIABILITAS JANGKA PANJANG'])->get();
        $data = PembayaranSiswa::find($id);
        return view('pembayaran_siswa.edit', compact('tagihan_siswa', 'siswa', 'kelas', 'akun', 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PambayaranSiswa  $pambayaranSiswa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $instansi, $id, $kelas)
    {
        // validation
        $validator = Validator::make($req->all(), [
            'tagihan_siswa_id' => 'required|exists:t_tagihan_siswa,id',
            'siswa_id' => 'required|exists:t_siswa,id',
            'tanggal' => 'required|date',
            'total' => 'required|numeric',
            'sisa' => 'required',
            'tipe_pembayaran' => 'required',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $isPaid = PembayaranSiswa::where('tagihan_siswa_id', $req->tagihan_siswa_id)->where('siswa_id', $req->siswa_id)->where('id', '!=', $id)->first();
        if($isPaid) return redirect()->back()->withInput()->with('fail', 'Siswa Sudah membayar');

        // save data
        $data = $req->except(['_method', '_token']);
        
        // file
        if ($req->hasFile('file')) {
            $file = $req->file('file');
            $tagihan = TagihanSiswa::find($req->tagihan_siswa_id);
            $jenis = str_replace(' ', '-', $tagihan->jenis_tagihan);
            $fileName = $jenis . '_' . date('YmdHis') . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('Bukti_Pengeluaran', $fileName, 'public');
            $data['file'] = $filePath;
        }

        $data['status'] = $data['sisa'] == 0 ? 'LUNAS' :'BELUM LUNAS';
        $check = PembayaranSiswa::find($id)->update($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal diupdate');
        // jurnal
        $updatedData = PembayaranSiswa::find($id);
        if($updatedData->tagihan_siswa->jenis_tagihan == 'SPP'){
            $dataJournal = [
                'keterangan' => 'Pembayaran: ' . $updatedData->tagihan_siswa->jenis_tagihan,
                'nominal' => $updatedData->total * 0.25,
                'tanggal' =>  $updatedData->tanggal,
            ];
            $journal = PembayaranSiswa::find($id)->journals()->first();
            $journal->update($dataJournal);

            $dataJournal2 = [
                'keterangan' => 'Pembayaran: ' . $updatedData->tagihan_siswa->jenis_tagihan,
                'nominal' => $updatedData->total * 0.75,
                'tanggal' =>  $updatedData->tanggal,
            ];
            $journal2 = PembayaranSiswa::find($id)->journals()->first();
            $journal2->update($dataJournal2);
        } elseif($updatedData->tagihan_siswa->jenis_tagihan == 'JPI'){
            $dataJournal = [
                'keterangan' => 'Pembayaran: ' . $updatedData->tagihan_siswa->jenis_tagihan,
                'nominal' => $updatedData->total,
                'tanggal' =>  $updatedData->tanggal,
            ];
            $journal = PembayaranSiswa::find($id)->journals()->first();
            $journal->update($dataJournal);
        } elseif($updatedData->tagihan_siswa->jenis_tagihan == 'Registrasi') {
            $dataJournal = [
                'keterangan' => 'Pembayaran: ' . $updatedData->tagihan_siswa->jenis_tagihan,
                'nominal' => $updatedData->total,
                'tanggal' =>  $updatedData->tanggal,
            ];
            $journal = PembayaranSiswa::find($id)->journals()->first();
            $journal->update($dataJournal);
        } 
        // elseif($updatedData->tagihan_siswa->jenis_tagihan == 'Outbond') {
        //     $dataJournal = [
        //         'keterangan' => 'Pembayaran: ' . $updatedData->tagihan_siswa->jenis_tagihan,
        //         'nominal' => $updatedData->total,
        //         'tanggal' =>  $updatedData->tanggal,
        //     ];
        //     $journal = PembayaranSiswa::find($id)->journals()->first();
        //     $journal->update($dataJournal);
        // } elseif($updatedData->tagihan_siswa->jenis_tagihan == 'Overtime') {
        //     $dataJournal = [
        //         'keterangan' => 'Pembayaran: ' . $updatedData->tagihan_siswa->jenis_tagihan,
        //         'nominal' => $updatedData->total,
        //         'tanggal' =>  $updatedData->tanggal,
        //     ];
        //     $journal = PembayaranSiswa::find($id)->journals()->first();
        //     $journal->update($dataJournal);
        // }
        return redirect()->route('pembayaran_siswa.index', ['instansi' => $instansi, 'kelas' => $kelas])->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PambayaranSiswa  $pambayaranSiswa
     * @return \Illuminate\Http\Response
     */
    public function destroy($instansi, $id)
    {
        $data = PembayaranSiswa::find($id);
        if(!$data) return response()->json(['msg' => 'Data tidak ditemukan'], 404);
        $check = $data->delete();
        if(!$check) return response()->json(['msg' => 'Gagal menghapus data'], 400);
        return response()->json(['msg' => 'Data berhasil dihapus']);
    }

    public function index_yayasan(Request $req)
    {
        $query = PembayaranSiswa::with(['journals', 'tagihan_siswa']);

        if ($req->has('jenis')) {
            $jenisTagihan = $req->jenis;
            $query->whereHas('tagihan_siswa', function ($q) use ($jenisTagihan) {
                $q->where('jenis_tagihan', $jenisTagihan);
            });
        } else {
            $query->whereHas('tagihan_siswa', function ($q) {
                $q->whereIn('jenis_tagihan', ['SPP', 'JPI']);
            });
        }

        if ($req->has('tipe')) {
            $query->where('tipe_pembayaran', $req->input('tipe'));
        }

        if ($req->has('instansi')) {
            $query->whereHas('siswa.instansi', function ($q) use ($req) {
                $q->where('nama_instansi', $req->input('instansi'));
            });
        }

        $data = $query->get();
        $data_instansi = Instansi::pluck('nama_instansi');
        return view('pemasukan_yayasan.index', compact('data', 'data_instansi'));
    }
}
