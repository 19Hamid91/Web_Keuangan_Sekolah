<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\Instansi;
use App\Models\Jurnal;
use App\Models\Kelas;
use App\Models\PembayaranSiswa;
use App\Models\Siswa;
use App\Models\TagihanSiswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $bulan = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $akuns = Akun::where('instansi_id', $data_instansi->id)->get();
        $tagihan_siswa = TagihanSiswa::where('tingkat', $kelas)->get();
        $tahun = $tagihan_siswa->map(function ($jurnal) {
            return Carbon::parse($jurnal->mulai_bayar)->year;
        })->unique()->values();
        $siswa = Siswa::whereHas('kelas', function($q) use($kelas){
            $q->where('tingkat', $kelas);
        })->get();
        $akun = Akun::where('instansi_id', $data_instansi->id)->whereIn('jenis', ['KAS', 'BANK', 'LIABILITAS JANGKA PENDEK', 'LIABILITAS JANGKA PANJANG'])->get();
        return view('pembayaran_siswa.create', compact('tagihan_siswa', 'siswa', 'kelas', 'akun', 'bulan', 'tahun', 'akuns'));
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
            'siswa_id' => 'required|exists:t_siswa,id',
            'mulai_bayar.*' => 'required|date',
            'akhir_bayar.*' => 'required|date',
            'total' => 'required|numeric',
            'akun.*' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return redirect()->back()->withInput()->with('fail', $error);
        }

        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $data = $req->except(['_method', '_token']);
        $tagihans = $this->getOutstandingFeesForPeriod($data['siswa_id'], $data['mulai_bayar'], $data['akhir_bayar']);
        $remainingPayment = $data['total'];

        DB::beginTransaction();

        try {
            foreach ($tagihans as $tagihan) {
                if(in_array($tagihan->id, $data['tagihan_id'])){
                    if ($remainingPayment <= 0) {
                        break;
                    }
    
                    $amountToPay = min($tagihan->nominal, $remainingPayment);
                    $this->recordPayment($data['siswa_id'], $tagihan, $amountToPay);
    
                    // Update remaining payment amount
                    $remainingPayment -= $amountToPay;
                    
                    if ($amountToPay < $tagihan->nominal && $tagihan->jenis_tagihan == 'JPI') {
                        $totalJPI = PembayaranSiswa::where('tagihan_siswa_id', $tagihan->id)->sum('total');
                        $mulaiBayar = Carbon::parse($tagihan->mulai_bayar);
                        $month = $mulaiBayar->month;
                        $year = $mulaiBayar->year;
                        $remainingJPIAmount = $tagihan->nominal - $amountToPay;
                        if(intval($totalJPI) < $tagihan->nominal){
                            $this->createNewJPIInvoice($tagihan, $remainingJPIAmount, $month, $year, $instansi);
                        }
                    }
                }
            }

            DB::commit();
            return redirect()->route('pembayaran_siswa.index', ['instansi' => $instansi, 'kelas' => $kelas])->with('success', 'Pembayaran berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('fail', 'Pembayaran gagal: ' . $e->getMessage());
        }
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
        $tagihan_siswa = TagihanSiswa::where('tingkat', $kelas)->get();
        $siswa = Siswa::where('instansi_id', $data_instansi->id)->whereHas('kelas', function($q) use($kelas){
            $q->where('tingkat', $kelas);
        })->get();
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

    public function getTagihanSiswa(Request $req, $instansi)
    {
        // validation
        $validator = Validator::make($req->all(), [
            'siswa_id' => 'required|exists:t_siswa,id',
            'bulan' => 'required',
            'tahun' => 'required',
        ]);

        $error = $validator->errors()->all();
        if ($validator->fails()) return response()->json($error, 400);
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $siswa = Siswa::find($req->siswa_id);

        $belumLunas = PembayaranSiswa::where('siswa_id', $req->siswa_id)
        ->whereMonth('tanggal', $req->bulan)
        ->whereYear('tanggal', $req->tahun)
        ->where('status', '!=', 'LUNAS')
        ->get();

        if ($belumLunas->isEmpty()) {
            $data = TagihanSiswa::where('instansi_id', $data_instansi->id)
                ->where('tingkat', $siswa->kelas->tingkat)
                ->whereMonth('mulai_bayar', $req->bulan)
                ->whereYear('mulai_bayar', $req->tahun)
                ->get();
        } else {
            $tagihanIds = $belumLunas->pluck('tagihan_siswa_id')->toArray();

            $data = TagihanSiswa::where('instansi_id', $data_instansi->id)
                ->where('tingkat', $siswa->kelas->tingkat)
                ->whereMonth('mulai_bayar', $req->bulan)
                ->whereYear('mulai_bayar', $req->tahun)
                ->whereIn('id', $tagihanIds)
                ->get();

            $data->each(function ($tagihan) use ($belumLunas) {
                $matchingPembayaran = $belumLunas->where('tagihan_siswa_id', $tagihan->id)->first();
                if ($matchingPembayaran) {
                    $tagihan->nominal -= $matchingPembayaran->total;
                }
            });
        }

        if ($data->isEmpty()) {
            return response()->json('Data tidak ditemukan', 404);
        }

        return response()->json($data);
    }
    
    public function getOutstandingFeesForPeriod($siswa_id, $mulai_bayar, $akhir_bayar) {
        $siswa = Siswa::find($siswa_id);
        return TagihanSiswa::where('tingkat', $siswa->kelas->tingkat)
                           ->where('mulai_bayar', $mulai_bayar)
                           ->where('akhir_bayar', $akhir_bayar)
                           ->orderByRaw("FIELD(jenis_tagihan, 'spp', 'registrasi', 'overtime', 'outbond', 'jpi')")
                           ->get();
    }

    private function recordPayment($studentId, $tagihan, $amountPaid) {
        $totalTagihan = PembayaranSiswa::where('tagihan_siswa_id', $tagihan->id)->where('siswa_id', $studentId)->sum('total');
        PembayaranSiswa::create([
            'tagihan_siswa_id' => $tagihan->id,
            'siswa_id' => $studentId,
            'tanggal' => now(),
            'total' => $amountPaid,
            'sisa' => $tagihan->nominal - $totalTagihan - $amountPaid,
            'tipe_pembayaran' => 'Cash',
            'status' => ($amountPaid + $totalTagihan) >= $tagihan->nominal ? 'LUNAS' : 'SEBAGIAN',
        ]);
    }

    private function createNewJPIInvoice($fee, $remainingAmount, $currentMonth, $currentYear, $instansi) {
        $nextMonth = Carbon::createFromDate($currentYear, $currentMonth, 1)->addMonth();
        $waktu = $instansi == 'smp' ? 12 : 5;
        $akhirBayar = $nextMonth->copy()->addMonths($waktu);
        $periode = $nextMonth->format('Y-m');
        
        // Create the new JPI invoice
        TagihanSiswa::create([
            'siswa_id' => $fee->siswa_id,
            'tahun_ajaran_id' => $fee->tahun_ajaran_id,
            'instansi_id' => $fee->instansi_id,
            'tingkat' => $fee->tingkat,
            'mulai_bayar' => $nextMonth,
            'akhir_bayar' => $akhirBayar,
            'jumlah_pembayaran' => 'Sekali',
            'jenis_tagihan' => 'JPI',
            'nominal' => $remainingAmount,
            'periode' => $periode,
        ]);
    }
}
