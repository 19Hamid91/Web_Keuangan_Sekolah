<?php

namespace App\Http\Controllers;

use App\Exports\NeracaExport;
use App\Models\Akun;
use App\Models\BukuBesar;
use App\Models\Instansi;
use App\Models\Jurnal;
use App\Models\KartuStok;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class NeracaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req, $instansi)
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
        $tahun = Jurnal::all()->map(function ($jurnal) {
            return Carbon::parse($jurnal->tanggal)->year;
        })->unique()->values();
        $data_isntansi = Instansi::where('nama_instansi', $instansi)->first();

        $query = Jurnal::where('instansi_id', $data_isntansi->id);

        if($req->tahun){
            $query->whereYear('tanggal', $req->tahun);
        }

        if($req->bulan){
            $query->whereMonth('tanggal', $req->bulan);
        }

        // Ambil data debit per akun
        $dataDebit = $query->whereNotNull('akun_debit')
            ->with('debit')
            ->get()
            ->groupBy('akun_debit')
            ->map(function ($group) {
                $totalNominal = $group->sum('nominal');
                $namaAkun = $group->first()->debit->nama;
                return [
                    'akun_id' => $group->first()->akun_debit,
                    'posisi' => $group->first()->debit->posisi,
                    'nama_akun' => $namaAkun,
                    'total_debit' => $totalNominal,
                    'total_kredit' => 0 // Inisialisasi kredit dengan 0
                ];
            });

        // Ambil data kredit per akun
        $dataKredit = $query->whereNotNull('akun_kredit')
            ->with('kredit')
            ->get()
            ->groupBy('akun_kredit')
            ->map(function ($group) {
                $totalNominal = $group->sum('nominal');
                $namaAkun = $group->first()->kredit->nama;
                return [
                    'akun_id' => $group->first()->akun_kredit,
                    'posisi' => $group->first()->kredit->posisi,
                    'nama_akun' => $namaAkun,
                    'total_debit' => 0, // Inisialisasi debit dengan 0
                    'total_kredit' => $totalNominal
                ];
            });

        // Gabungkan data debit dan kredit
        $dataAkun = $dataDebit->merge($dataKredit)->mapToGroups(function ($akun) {
            return [$akun['akun_id'] => $akun];
        });

        // Hitung saldo bersih (debit - kredit) untuk setiap akun
        $saldoAkun = $dataAkun->map(function ($groups, $akun_id) {
            $namaAkun = $groups->first()['nama_akun'];
            $totalDebit = $groups->sum('total_debit');
            $totalKredit = $groups->sum('total_kredit');
            if($groups->first()['posisi'] == 'DEBIT') {
                $saldoBersih = $totalDebit - $totalKredit;
            } else {
                $saldoBersih = $totalKredit - $totalDebit;
            }
            return [
                'akun_id' => $akun_id,
                'posisi' => $groups->first()['posisi'],
                'nama_akun' => $namaAkun,
                'total_debit' => $totalDebit,
                'total_kredit' => $totalKredit,
                'saldo_bersih' => $saldoBersih,
            ];
        });




        $saldoAkun = collect();

        if (isset($req->tahun) && isset($req->bulan)) {
            // Dapatkan semua akun
            $allAkun = Akun::where('instansi_id', $data_isntansi->id)->get();

            foreach ($allAkun as $akun) {
                $akunData = Jurnal::orderBy('tanggal')
                    ->where(function($query) use ($akun) {
                        $query->where('akun_debit', $akun->id)
                            ->orWhere('akun_kredit', $akun->id);
                    })
                    ->whereYear('tanggal', $req->tahun)
                    ->whereMonth('tanggal', $req->bulan)
                    ->get();

                if ($akun) {
                    $tanggal = Carbon::createFromFormat('Y-m', $req->tahun . '-' . $req->bulan)->startOfMonth();
                    $tanggalSebelumnya = $tanggal->copy()->subMonth();
                    $tahunSebelumnya = $tanggalSebelumnya->year;
                    $bulanSebelumnya = $tanggalSebelumnya->format('m');

                    $bukubesar = BukuBesar::where('akun_id', $akun->id)
                        ->whereYear('tanggal', $tahunSebelumnya)
                        ->whereMonth('tanggal', $bulanSebelumnya)
                        ->first();
                        
                    $saldo_awal = $bukubesar ? $bukubesar->saldo_akhir : $akun->saldo_awal;

                    $temp_saldo = $saldo_awal;
                    $totalDebit = 0;
                    $totalKredit = 0;

                    foreach ($akunData as $item) {
                        if ($akun->posisi == 'DEBIT') {
                            if ($item->akun_kredit == $akun->id) {
                                $temp_saldo -= $item->nominal;
                                $totalKredit += $item->nominal;
                            } else if ($item->akun_debit == $akun->id) {
                                $temp_saldo += $item->nominal;
                                $totalDebit += $item->nominal;
                            }
                        } else {
                            if ($item->akun_kredit == $akun->id) {
                                $temp_saldo += $item->nominal;
                                $totalKredit += $item->nominal;
                            } else if ($item->akun_debit == $akun->id) {
                                $temp_saldo -= $item->nominal;
                                $totalDebit += $item->nominal;
                            }
                        }
                    }

                    $saldo_akhir = $temp_saldo;
                    $saldoBersih = $saldo_akhir;
                    
                    // Tentukan di mana saldo bersih ditempatkan berdasarkan posisi akun
                    $totalDebit = $akun->posisi == 'DEBIT' ? $saldoBersih : 0;
                    $totalKredit = $akun->posisi == 'KREDIT' ? $saldoBersih : 0;

                    // Tambahkan data ke koleksi
                    $saldoAkun->push([
                        'akun_id' => $akun->id,
                        'posisi' => $akun->posisi,
                        'nama_akun' => $akun->nama,
                        'total_debit' => $totalDebit,
                        'total_kredit' => $totalKredit,
                        'saldo_bersih' => $saldoBersih,
                    ]);
                }
            }
        }

        return view('neraca.index', compact('bulan', 'tahun', 'saldoAkun'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function excel(Request $req, $instansi)
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

        $data_isntansi = Instansi::where('nama_instansi', $instansi)->first();

        $query = Jurnal::where('instansi_id', $data_isntansi->id);

        if($req->tahun){
            $query->whereYear('tanggal', $req->tahun);
        }

        if($req->bulan){
            $query->whereMonth('tanggal', $req->bulan);
        }

        // Ambil data debit per akun
        $dataDebit = $query->whereNotNull('akun_debit')
            ->with('debit')
            ->get()
            ->groupBy('akun_debit')
            ->map(function ($group) {
                $totalNominal = $group->sum('nominal');
                $namaAkun = $group->first()->debit->nama;
                return [
                    'akun_id' => $group->first()->akun_debit,
                    'posisi' => $group->first()->debit->posisi,
                    'nama_akun' => $namaAkun,
                    'total_debit' => $totalNominal,
                    'total_kredit' => 0 // Inisialisasi kredit dengan 0
                ];
            });

        // Ambil data kredit per akun
        $dataKredit = $query->whereNotNull('akun_kredit')
            ->with('kredit')
            ->get()
            ->groupBy('akun_kredit')
            ->map(function ($group) {
                $totalNominal = $group->sum('nominal');
                $namaAkun = $group->first()->kredit->nama;
                return [
                    'akun_id' => $group->first()->akun_kredit,
                    'posisi' => $group->first()->kredit->posisi,
                    'nama_akun' => $namaAkun,
                    'total_debit' => 0, // Inisialisasi debit dengan 0
                    'total_kredit' => $totalNominal
                ];
            });

        // Gabungkan data debit dan kredit
        $dataAkun = $dataDebit->merge($dataKredit)->mapToGroups(function ($akun) {
            return [$akun['akun_id'] => $akun];
        });

        // Hitung saldo bersih (debit - kredit) untuk setiap akun
        $saldoAkun = $dataAkun->map(function ($groups, $akun_id) {
            $namaAkun = $groups->first()['nama_akun'];
            $totalDebit = $groups->sum('total_debit');
            $totalKredit = $groups->sum('total_kredit');
            if($groups->first()['posisi'] == 'DEBIT') {
                $saldoBersih = $totalDebit - $totalKredit;
            } else {
                $saldoBersih = $totalKredit - $totalDebit;
            }
            return [
                'akun_id' => $akun_id,
                'posisi' => $groups->first()['posisi'],
                'nama_akun' => $namaAkun,
                'total_debit' => $totalDebit,
                'total_kredit' => $totalKredit,
                'saldo_bersih' => $saldoBersih,
            ];
        });

        $dataBulan = $bulan[$req->bulan];
        $dataTahun = $req->tahun;

        return Excel::download(new NeracaExport($saldoAkun, $dataBulan, $dataTahun), 'Neraca.xlsx');
    }

    public function pdf(Request $req, $instansi)
    {
        $dataBulan = [
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

        $data_isntansi = Instansi::where('nama_instansi', $instansi)->first();

        $query = Jurnal::where('instansi_id', $data_isntansi->id);

        if($req->tahun){
            $query->whereYear('tanggal', $req->tahun);
        }

        if($req->bulan){
            $query->whereMonth('tanggal', $req->bulan);
        }

        // Ambil data debit per akun
        $dataDebit = $query->whereNotNull('akun_debit')
            ->with('debit')
            ->get()
            ->groupBy('akun_debit')
            ->map(function ($group) {
                $totalNominal = $group->sum('nominal');
                $namaAkun = $group->first()->debit->nama;
                return [
                    'akun_id' => $group->first()->akun_debit,
                    'posisi' => $group->first()->debit->posisi,
                    'nama_akun' => $namaAkun,
                    'total_debit' => $totalNominal,
                    'total_kredit' => 0 // Inisialisasi kredit dengan 0
                ];
            });

        // Ambil data kredit per akun
        $dataKredit = $query->whereNotNull('akun_kredit')
            ->with('kredit')
            ->get()
            ->groupBy('akun_kredit')
            ->map(function ($group) {
                $totalNominal = $group->sum('nominal');
                $namaAkun = $group->first()->kredit->nama;
                return [
                    'akun_id' => $group->first()->akun_kredit,
                    'posisi' => $group->first()->kredit->posisi,
                    'nama_akun' => $namaAkun,
                    'total_debit' => 0, // Inisialisasi debit dengan 0
                    'total_kredit' => $totalNominal
                ];
            });

        // Gabungkan data debit dan kredit
        $dataAkun = $dataDebit->merge($dataKredit)->mapToGroups(function ($akun) {
            return [$akun['akun_id'] => $akun];
        });

        // Hitung saldo bersih (debit - kredit) untuk setiap akun
        $saldoAkun = $dataAkun->map(function ($groups, $akun_id) {
            $namaAkun = $groups->first()['nama_akun'];
            $totalDebit = $groups->sum('total_debit');
            $totalKredit = $groups->sum('total_kredit');
            if($groups->first()['posisi'] == 'DEBIT') {
                $saldoBersih = $totalDebit - $totalKredit;
            } else {
                $saldoBersih = $totalKredit - $totalDebit;
            }
            return [
                'akun_id' => $akun_id,
                'posisi' => $groups->first()['posisi'],
                'nama_akun' => $namaAkun,
                'total_debit' => $totalDebit,
                'total_kredit' => $totalKredit,
                'saldo_bersih' => $saldoBersih,
            ];
        });

        $bulan = $dataBulan[$req->bulan];
        $tahun = $req->tahun;
        $data = $saldoAkun->toArray();
        $pdf = Pdf::loadView('neraca.pdf', compact('data', 'bulan', 'tahun'));
        return $pdf->stream('Neraca.pdf');
    }
}
