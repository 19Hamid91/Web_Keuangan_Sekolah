<?php

namespace App\Http\Controllers;

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
        $dataKelas = Kelas::withCount(['siswa' => function ($query) {
            $query->doesntHave('kelulusan');
        }])->where('instansi_id', $data_instansi->id)->get();
        return view('pembayaran_siswa.daftar', compact('dataKelas'));
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($instansi, $kelas)
    {
        $data = PembayaranSiswa::whereHas('siswa', function($q) use($kelas){
            $q->where('kelas_id', $kelas);
        })->get();
        return view('pembayaran_siswa.index', compact('kelas', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($instansi, $kelas)
    {
        $tagihan_siswa = TagihanSiswa::where('kelas_id', $kelas)->get();
        $siswa = Siswa::where('kelas_id', $kelas)->get();
        // dd($tagihan_siswa, $siswa, $kelas);
        return view('pembayaran_siswa.create', compact('tagihan_siswa', 'siswa', 'kelas'));
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
            'sisa' => 'required|numeric',
            'tipe_pembayaran' => 'required',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $isPaid = PembayaranSiswa::where('tagihan_siswa_id', $req->tagihan_siswa_id)->where('siswa_id', $req->siswa_id)->first();
        if($isPaid) return redirect()->back()->withInput()->with('fail', 'Siswa Sudah membayar');

        // save data
        $data = $req->except(['_method', '_token']);
        $data['status'] = $data['sisa'] == 0 ? 'LUNAS' :'PENDING';
        $check = PembayaranSiswa::create($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        // jurnal
        if($check->tagihan_siswa->jenis_tagihan == 'SPP'){
            $jurnalSPP = new Jurnal([
                'instansi_id' => 1,
                'keterangan' => 'Pembayaran: ' . $check->tagihan_siswa->jenis_tagihan,
                'nominal' => $check->total * 0.25,
                'akun_debit' => null,
                'akun_kredit' => null,
                'tanggal' => $check->tanggal,
                
            ]);
            $check->journals()->save($jurnalSPP);

            $jurnal = new Jurnal([
                'instansi_id' => $check->siswa->instansi_id,
                'keterangan' => 'Pembayaran: ' . $check->tagihan_siswa->jenis_tagihan,
                'nominal' => $check->total * 0.75,
                'akun_debit' => null,
                'akun_kredit' => null,
                'tanggal' => $check->tanggal,
                
            ]);
            $check->journals()->save($jurnal);
        } elseif($check->tagihan_siswa->jenis_tagihan == 'JPI'){
            $jurnalJPI = new Jurnal([
                'instansi_id' => 1,
                'keterangan' => 'Pembayaran: ' . $check->tagihan_siswa->jenis_tagihan,
                'nominal' => $check->total,
                'akun_debit' => null,
                'akun_kredit' => null,
                'tanggal' => $check->tanggal,
                
            ]);
            $check->journals()->save($jurnalJPI);
        } else {
            $jurnal = new Jurnal([
                'instansi_id' => $check->siswa->instansi_id,
                'keterangan' => 'Pembayaran: ' . $check->tagihan_siswa->jenis_tagihan,
                'nominal' => $check->total * 0.75,
                'akun_debit' => null,
                'akun_kredit' => null,
                'tanggal' => $check->tanggal,
                
            ]);
            $check->journals()->save($jurnal);
        }
        return redirect()->route('pembayaran_siswa.index', ['instansi' => $instansi, 'kelas' => $kelas])->with('success', 'Data berhasil ditambahkan');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PambayaranSiswa  $pambayaranSiswa
     * @return \Illuminate\Http\Response
     */
    public function show(PembayaranSiswa $pembayaranSiswa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PambayaranSiswa  $pambayaranSiswa
     * @return \Illuminate\Http\Response
     */
    public function edit(PembayaranSiswa $pembayaranSiswa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PambayaranSiswa  $pambayaranSiswa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PembayaranSiswa $pembayaranSiswa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PambayaranSiswa  $pambayaranSiswa
     * @return \Illuminate\Http\Response
     */
    public function destroy(PembayaranSiswa $pembayaranSiswa)
    {
        //
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
