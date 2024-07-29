<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\Instansi;
use App\Models\Jurnal;
use App\Models\Kelas;
use App\Models\PembayaranSiswa;
use App\Models\Siswa;
use App\Models\TagihanSiswa;
use Barryvdh\DomPDF\Facade\Pdf;
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
                $query->doesntHave('kelulusan')->where('status', 'AKTIF');
            }])
            ->where('instansi_id', $data_instansi->id)
            ->whereIn('tingkat', $tingkats)
            ->get();

        $siswaCount = [];
        foreach ($dataKelas as $kelas) {
            if (isset($siswaCount[$kelas->tingkat])) {
                $siswaCount[$kelas->tingkat] += $kelas->siswa_count;
            } else {
                $siswaCount[$kelas->tingkat] = $kelas->siswa_count;
            }
        }
        return view('pembayaran_siswa.daftar', compact('siswaCount'));
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req, $instansi, $kelas)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
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
        $tahun = PembayaranSiswa::whereHas('tagihan_siswa', function($q) use($data_instansi){
            $q->where('instansi_id', $data_instansi->id);
        })->get()->map(function ($item) {
            return Carbon::parse($item->tanggal)->year;
        })->unique()->values();
        $filterBulan = $req->input('bulan');
        $filterTahun = $req->input('tahun');

        $data = PembayaranSiswa::whereHas('siswa', function($q) use ($kelas) {
            $q->where('status', 'AKTIF')->whereHas('kelas', function($p) use ($kelas) {
                $p->where('tingkat', $kelas);
            });
        });

        if ($filterBulan && $filterTahun) {
            $data->whereMonth('tanggal', $filterBulan)
                ->whereYear('tanggal', $filterTahun);
        }

        $data = $data->orderByDesc('id')    
            ->get()
            ->groupBy('invoice');
        $totalPerBulan = PembayaranSiswa::whereHas('siswa', function($q) use ($data_instansi, $kelas) {
        $q->where('instansi_id', $data_instansi->id)->whereHas('kelas', function($p) use($kelas){
            $p->where('tingkat', $kelas);
        });
        });
    
        if ($filterBulan && $filterTahun) {
            $totalPerBulan->whereMonth('tanggal', $filterBulan)
                        ->whereYear('tanggal', $filterTahun);
        }
        
        $totalPerBulan = $totalPerBulan->sum('total');
        $akuns = Akun::where('instansi_id', $data_instansi->id)->get();
        return view('pembayaran_siswa.index', compact('kelas', 'data', 'data_instansi', 'totalPerBulan', 'bulan', 'tahun', 'akuns'));
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
        })->where('status', 'AKTIF')->get();
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
            'tipe_pembayaran' => 'required|in:Cash,Transfer',
            'mulai_bayar.*' => 'required|date',
            'tagihan_id.*' => 'required',
            'akhir_bayar.*' => 'required|date',
            'total' => 'required|numeric',
            'akun.*' => 'required',
            'tanggal' => 'required'
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return redirect()->back()->withInput()->with('fail', $error);
        }

        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $data = $req->except(['_method', '_token']);
        // $tagihans = $this->getOutstandingFeesForPeriod($data['siswa_id'], $data['mulai_bayar'][0], $data['akhir_bayar'][0]);
        $tagihans = TagihanSiswa::whereIn('id', $req->tagihan_id)->orderByRaw("FIELD(jenis_tagihan, 'spp', 'registrasi', 'overtime', 'outbond', 'jpi')")->get();
        $remainingPayment = $data['total'];

        DB::beginTransaction();

        try {
            $invoice = 'INV'.date('Ymdhis');
            foreach ($tagihans as $tagihan) {
                if(in_array($tagihan->id, $data['tagihan_id'])){
                    if ($remainingPayment <= 0) {
                        break;
                    }
    
                    $amountToPay = min($tagihan->nominal, $remainingPayment);
                    $this->recordPayment($data['siswa_id'], $tagihan, $amountToPay, $data['tipe_pembayaran'], $invoice, $data['tanggal']);
    
                    // Update remaining payment amount
                    $remainingPayment -= $amountToPay;
                    
                    // if ($amountToPay < $tagihan->nominal && $tagihan->jenis_tagihan == 'JPI') {
                    //     $totalJPI = PembayaranSiswa::where('tagihan_siswa_id', $tagihan->id)->sum('total');
                    //     $mulaiBayar = Carbon::parse($tagihan->mulai_bayar);
                    //     $month = $mulaiBayar->month;
                    //     $year = $mulaiBayar->year;
                    //     $remainingJPIAmount = $tagihan->nominal - $amountToPay;
                    //     if(intval($totalJPI) < $tagihan->nominal){
                    //         $this->createNewJPIInvoice($tagihan, $remainingJPIAmount, $month, $year, $instansi);
                    //     }
                    // }
                }
            }

            // create akun
            // for ($i = 0; $i < count($data['akun']); $i++) {
            //     $this->createJurnal('Pembayaran siswa', $data['akun'][$i], $data['debit'][$i], $data['kredit'][$i], $data_instansi->id , now());
            // }

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
        $tagihan_siswa = TagihanSiswa::where('tingkat', $kelas)->get();
        $siswa = Siswa::where('kelas_id', $kelas)->get();
        $akun = Akun::where('instansi_id', $data_instansi->id)->whereIn('jenis', ['KAS', 'BANK', 'LIABILITAS JANGKA PENDEK', 'LIABILITAS JANGKA PANJANG'])->get();
        $data = PembayaranSiswa::where('invoice', $id)->get();
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
        })->where('status', 'AKTIF')->get();
        $akun = Akun::where('instansi_id', $data_instansi->id)->whereIn('jenis', ['KAS', 'BANK', 'LIABILITAS JANGKA PENDEK', 'LIABILITAS JANGKA PANJANG'])->get();
        $data = PembayaranSiswa::where('invoice', $id)->get();
        return view('pembayaran_siswa.edit', compact('tagihan_siswa', 'siswa', 'kelas', 'akun', 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PambayaranSiswa  $pambayaranSiswa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $instansi, $kelas, $id)
    {
        // validation
        $validator = Validator::make($req->all(), [
            'siswa_id' => 'required|exists:t_siswa,id',
            'tanggal' => 'required|date',
            'tagihan_siswa_id.*' => 'required|exists:t_tagihan_siswa,id',
            'total.*' => 'required|numeric',
            'sisa.*' => 'required|numeric',
            'tipe_pembayaran.*' => 'required|in:Cash,Transfer',
            'tanggal' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $siswa = Siswa::find($req->siswa_id);
        DB::beginTransaction();
        try {
            foreach ($req->tagihan_siswa_id as $index => $tagihan_id) {
                $pembayaran = PembayaranSiswa::where('invoice', $id)
                    ->where('tagihan_siswa_id', $tagihan_id)
                    ->first();
                
                // if (!$pembayaran) {
                //     $pembayaran = new PembayaranSiswa();
                //     $pembayaran->invoice = $id; // Make sure invoice is set for new records
                // }

                $pembayaran->siswa_id = $req->siswa_id;
                $pembayaran->tanggal = $req->tanggal;
                $pembayaran->tagihan_siswa_id = $tagihan_id;
                $pembayaran->total = $req->total[$index];
                $pembayaran->sisa = $pembayaran->tagihan_siswa->nominal == $req->total[$index] ? 0 : $req->total[$index] - $pembayaran->tagihan_siswa->nominal;
                $pembayaran->status = $pembayaran->tagihan_siswa->nominal == $req->total[$index] ? 'LUNAS' : 'SEBAGIAN';
                $pembayaran->tipe_pembayaran = $req->tipe_pembayaran[$index];
                $pembayaran->save();
            }

            // Handle file upload
            if ($req->hasFile('file')) {
                $file = $req->file('file');
                $path = $file->store('bukti_pembayaran', 'public');
                $pembayaran->file = $path;
                $pembayaran->save();
            }

            DB::commit();
            return redirect()->route('pembayaran_siswa.index', ['instansi' => $instansi, 'kelas' => $siswa->kelas->tingkat])->with('success', 'Pembayaran berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('fail', 'Pembaruan pembayaran gagal: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PambayaranSiswa  $pambayaranSiswa
     * @return \Illuminate\Http\Response
     */
    public function destroy($instansi, $id)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        if (!$data_instansi) {
            return response()->json(['msg' => 'Instansi tidak ditemukan'], 404);
        }

        $data = PembayaranSiswa::where('invoice', $id)->whereHas('siswa', function($q) use($data_instansi){
            $q->where('instansi_id', $data_instansi->id);
        })->get();

        if ($data->isEmpty()) {
            return response()->json(['msg' => 'Data tidak ditemukan'], 404);
        }

        DB::beginTransaction();
        try {
            foreach ($data as $payment) {
                $payment->delete();
            }
            DB::commit();
            return response()->json(['msg' => 'Data berhasil dihapus']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['msg' => 'Gagal menghapus data', 'error' => $e->getMessage()], 400);
        }
    }

    public function cetak($instansi, $invoice)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $data = PembayaranSiswa::with('tagihan_siswa', 'siswa')->where('invoice', $invoice)->get();
        $keteranganArray = $data->pluck('tagihan_siswa.jenis_tagihan')->toArray();
        $keteranganString = implode(', ', $keteranganArray);
        $data = array(
            'instansi_id' => $data_instansi->id,
            'keterangan' => 'Pembayaran '.$keteranganString,
            'total' => $data->sum('total'),
            'tanggal' => $data->first()->tanggal,
            'siswa' => $data->first()->siswa->nama_siswa,
        );
        $data['instansi_id'] = $data_instansi->id;
        $pdf = Pdf::loadView('pembayaran_siswa.cetak', $data)->setPaper('a4', 'landscape');
        return $pdf->stream('kwitansi-pembayaran_siswa.pdf');
    }

    public function getTagihanSiswa(Request $req, $instansi)
    {
        // validation
        $validator = Validator::make($req->all(), [
            'siswa_id' => 'required|exists:t_siswa,id',
            'bulan' => 'required',
            'tahun' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), 400);
        }

        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $siswa = Siswa::find($req->siswa_id);

        $pembayaranBulanIni = PembayaranSiswa::where('siswa_id', $req->siswa_id)
            ->whereMonth('tanggal', $req->bulan)
            ->whereYear('tanggal', $req->tahun)
            ->exists();

        if ($pembayaranBulanIni) {
            return response()->json(['message' => 'Tagihan bulan ini sudah dibayar'], 404);
        }

        $belumLunas = PembayaranSiswa::with('tagihan_siswa')
            ->where('siswa_id', $req->siswa_id)
            ->where('status', '!=', 'LUNAS')
            ->get();

        $jpiPaid = PembayaranSiswa::where('siswa_id', $req->siswa_id)->whereHas('tagihan_siswa', function($q){
            $q->where('jenis_tagihan', 'JPI');
        })->where('status', 'LUNAS')->exists();

        $tagihanBulanIni = TagihanSiswa::where('instansi_id', $data_instansi->id)
            ->where('tingkat', $siswa->kelas->tingkat)
            ->whereMonth('mulai_bayar', $req->bulan)
            ->whereYear('mulai_bayar', $req->tahun)
            ->get();

        $tagihanIds = $belumLunas->pluck('tagihan_siswa_id')->toArray();
        $tagihanBelumLunas = TagihanSiswa::whereIn('id', $tagihanIds)->get();

        $tagihanBelumLunas->each(function ($tagihan) use ($belumLunas) {
            $matchingPembayaran = $belumLunas->where('tagihan_siswa_id', $tagihan->id)->first();
            if ($matchingPembayaran) {
                $tagihan->nominal -= $matchingPembayaran->total;
            }
        });

        $allTagihan = $tagihanBulanIni;
        if(!$jpiPaid){
            $allTagihan = $allTagihan->merge($tagihanBelumLunas);
        }

        if ($allTagihan->isEmpty()) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json($allTagihan);
    }
    
    public function getOutstandingFeesForPeriod($siswa_id, $mulai_bayar, $akhir_bayar) {
        $siswa = Siswa::find($siswa_id);
        $mulaiBulan = date('m', strtotime($mulai_bayar));
        $mulaiTahun = date('Y', strtotime($mulai_bayar));
        return TagihanSiswa::where('tingkat', $siswa->kelas->tingkat)
                           ->whereMonth('mulai_bayar', $mulaiBulan)
                           ->whereYear('mulai_bayar', $mulaiTahun)
                           ->orderByRaw("FIELD(jenis_tagihan, 'spp', 'registrasi', 'overtime', 'outbond', 'jpi')")
                           ->get();
    }

    private function recordPayment($studentId, $tagihan, $amountPaid, $tipePembayaran, $invoice, $tanggal) {
        $totalTagihan = PembayaranSiswa::where('tagihan_siswa_id', $tagihan->id)->where('siswa_id', $studentId)->sum('total');
        PembayaranSiswa::create([
            'tagihan_siswa_id' => $tagihan->id,
            'invoice' => $invoice,
            'siswa_id' => $studentId,
            'tanggal' => $tanggal,
            'total' => $amountPaid,
            'sisa' => $tagihan->nominal - $totalTagihan - $amountPaid,
            'tipe_pembayaran' => $tipePembayaran,
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

    private function createJurnal($keterangan, $akun, $debit, $kredit, $instansi_id, $tanggal)
    {
        Jurnal::create([
            'instansi_id' => $instansi_id,
            'journable_type' => PembayaranSiswa::class,
            'journable_id' => null,
            'keterangan' => $keterangan,
            'akun_debit' => $debit ? $akun : null,
            'akun_kredit' => $kredit ? $akun : null,
            'nominal' => $debit ?? $kredit,
            'tanggal' => $tanggal,
        ]);
    }

    public function index_kartu_piutang($instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $data = Siswa::with('pembayaran.tagihan_siswa')->where('instansi_id', $data_instansi->id)->whereHas('pembayaran', function($q){
            $q->where('status', '!=', 'LUNAS')->whereHas('tagihan_siswa', function($p) {
                $p->where('jenis_tagihan', 'JPI');
            });
        })->get();
        $akuns = Akun::where('instansi_id', $data_instansi->id)->get();
        return view('piutang.kartu', compact('data', 'akuns', 'data_instansi'));
    }

    public function index_laporan_piutang($instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $bulan = date('m'); 
        $tahun = date('Y'); 
        $tagihanTerlewat = TagihanSiswa::where('instansi_id', $data_instansi->id)->whereDate('akhir_bayar', '<', now())->where('jenis_tagihan', '!=', 'JPI')->get();
        $tagihan_siswa_ids = $tagihanTerlewat->pluck('id');
        $siswas = Siswa::with('pembayaran')->where('instansi_id', $data_instansi->id)->where('status', 'AKTIF')->get();
        $data = [];
        foreach ($siswas as $siswa) {
            $tagihanData = [];
            $totalPiutang = 0;
            
            foreach ($tagihanTerlewat as $tagihan) {
                if($siswa->kelas->tingkat == $tagihan->tingkat){
                    $pembayaran = $siswa->pembayaran()->where('tagihan_siswa_id', $tagihan->id)->first();
                    
                    if (!$pembayaran && $tagihan->jenis_tagihan != 'JPI') {
                        $piutang = $tagihan->nominal;
                        $totalPiutang += $piutang;
                        $tagihanData[] = [
                            'id' => $tagihan->id,
                            'jenis' => $tagihan->jenis_tagihan,
                            'piutang' => $piutang,
                            'jatuh_tempo' => $tagihan->akhir_bayar
                        ];
                    }
                }
            }
            
            if (!empty($tagihanData)) {
                $data[] = [
                    'siswa' => $siswa->nama_siswa,
                    'tagihan' => $tagihanData,
                    'total_piutang' => $totalPiutang
                ];
            }
        }
        $akuns = Akun::where('instansi_id', $data_instansi->id)->get();
        return view('piutang.laporan', compact('data', 'akuns', 'data_instansi'));
    }

    public function getNominal(Request $req, $instansi){
        $validator = Validator::make($req->all(), [
            'tanggal' => 'required',
            'tingkat' => 'required',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return response()->json($error, 400);
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $all = PembayaranSiswa::with('tagihan_siswa')->whereHas('tagihan_siswa', function($q) use($data_instansi, $req){
            $q->where('tingkat', $req->tingkat)->where('instansi_id', $data_instansi->id);
        })->whereDate('tanggal', $req->tanggal)->get();
        $jpi = $all->sum(function($pembayaran) {
            if($pembayaran->tagihan_siswa->jenis_tagihan == 'JPI'){
                return $pembayaran->total;
            }
        }) ?? 0;
        $registrasi = $all->sum(function($pembayaran) {
            if($pembayaran->tagihan_siswa->jenis_tagihan == 'Registrasi'){
                return $pembayaran->total;
            }
        }) ?? 0;
        $outbond = $all->sum(function($pembayaran) {
            if($pembayaran->tagihan_siswa->jenis_tagihan == 'Outbond'){
                return $pembayaran->total;
            }
        }) ?? 0;
        $spp = $all->sum(function($pembayaran) {
            if($pembayaran->tagihan_siswa->jenis_tagihan == 'SPP'){
                return $pembayaran->total;
            }
        }) ?? 0;
        $total = $jpi + $registrasi + $outbond + $spp;
        if($instansi == 'tk-kb-tpa') $total = $jpi + $registrasi + $outbond + $spp;
        if($instansi == 'smp') $total = $jpi + $registrasi + $spp;
        $data = [
            'total' => $total,
            'jpi' => $jpi,
            'registrasi' => $registrasi,
            'outbond' => $outbond,
            'spp' => $spp,
        ];
        return response()->json($data);
    }
}
