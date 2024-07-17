<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\Atk;
use App\Models\Instansi;
use App\Models\Jurnal;
use App\Models\KartuStok;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KartuStokController extends Controller
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
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $filterAtk = $req->atk;
        $filterAtk2 = $req->atk2;
        $filterTahun = $req->tahun;
        $filterBulan = $req->bulan;
        $filterTahun2 = $req->tahun2;
        $filterBulan2 = $req->bulan2;

        $dataInstansi = KartuStok::whereHas('atk', function($q) use($data_instansi){
            $q->where('instansi_id', $data_instansi->id);
        })->orderByDesc('tanggal')->whereHas('pembelian_atk')->get();

        $tahun = $dataInstansi->map(function ($jurnal) {
            return Carbon::parse($jurnal->tanggal)->year;
        })->unique()->values();

        $dataPembelian = KartuStok::with('komponen_beliatk')->whereHas('atk', function($q) use($data_instansi, $filterTahun, $filterBulan, $filterAtk){
            if ($filterAtk) {
                $q->where('atk_id', $filterAtk);
            }
            if ($filterTahun) {
                $q->whereYear('tanggal', $filterTahun);
            }
            if ($filterBulan) {
                $q->whereMonth('tanggal', $filterBulan);
            }
            $q->where('instansi_id', $data_instansi->id);
        })->orderByDesc('tanggal')->whereHas('pembelian_atk')->get();
        $dataTanpaPembelian = KartuStok::whereHas('atk', function($q) use($data_instansi, $filterTahun, $filterBulan, $filterAtk){
            if ($filterAtk) {
                $q->where('atk_id', $filterAtk);
            }
            if ($filterTahun) {
                $q->whereYear('tanggal', $filterTahun);
            }
            if ($filterBulan) {
                $q->whereMonth('tanggal', $filterBulan);
            }
            $q->where('instansi_id', $data_instansi->id);
        })
        ->where('pembelian_atk_id', 0)
        ->where('komponen_beliatk_id', 0)
        ->orderByDesc('tanggal')
        ->get();
        $data = $dataPembelian->concat($dataTanpaPembelian);
        $data = $data->sortByDesc(function ($item) {
            return [$item->tanggal, $item->id];
        });

        $atks = Atk::where('instansi_id', $data_instansi->id)->get();
        $akuns = Akun::where('instansi_id', $data_instansi->id)->get();
        $totalPerBulan = 0;
        return view('kartu_stok.index', compact('data', 'atks', 'data_instansi', 'bulan', 'tahun', 'akuns', 'totalPerBulan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $atks = Atk::where('instansi_id', $data_instansi->id)->get();
        return view('kartu_stok.create', compact('atks', 'data_instansi'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req, $instansi)
    {
        // validation
        $validator = Validator::make($req->all(), [
            'atk_id' => 'required',
            'tanggal' => 'required|date',
            'pengambil' => 'required',
            'jenis' => 'required|in:masuk,keluar',
            'masuk' => 'nullable|integer|min:0',
            'keluar' => 'nullable|integer|min:0',
        ]);
        $error = $validator->errors()->all();
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        if (!$req->masuk && !$req->keluar) return redirect()->back()->withInput()->with('fail', 'Jumlah tidak boleh kosong');

        DB::beginTransaction();
        try {
            $previousEntry = KartuStok::where('atk_id', $req->atk_id)->orderByDesc('tanggal')->orderByDesc('id')->first();
            $sisaOld = $previousEntry->sisa ?? 0;
            $totalHargaStokOld = $previousEntry->total_harga_stok ?? 0;
            $hargaRataRataOld = $previousEntry->harga_rata_rata ?? 0;

            if ($req->jenis == 'keluar' && $sisaOld < $req->keluar) {
                return redirect()->back()->withInput()->with('fail', 'Stok tidak mencukupi untuk pengeluaran');
            }

            $sisaNew = $req->jenis == 'masuk' ? ($sisaOld + $req->masuk) : ($sisaOld - $req->keluar);
            if($sisaNew < 5) {
                return redirect()->back()->withInput()->with('fail', 'Sisa stok terlalu sedikit ' . $sisaNew);
            }
            if($sisaNew <= 10) {
                Notification::create([
                    'instansi_id' => $data_instansi->id,
                    'header' => 'Stok ATK',  
                    'body' => 'Stok ' .$previousEntry->atk->nama_atk. ' tersisa '.$sisaNew,  
                ]);
            }


            if ($req->jenis == 'masuk') {
                $hargaUnitMasuk = $req->masuk > 0 ? ($totalHargaStokOld + $hargaRataRataOld * $sisaOld) / $req->masuk : 0;
                $totalHargaMasuk = $req->masuk * $hargaUnitMasuk;
                $totalHargaStokNew = $totalHargaStokOld + $totalHargaMasuk;
                $hargaRataRataNew = $sisaNew > 0 ? $totalHargaStokNew / $sisaNew : 0;
            } else {
                $hargaUnitKeluar = $hargaRataRataOld;
                $totalHargaKeluar = $req->keluar * $hargaUnitKeluar;
                $totalHargaStokNew = $totalHargaStokOld - $totalHargaKeluar;
                $hargaRataRataNew = $sisaNew > 0 ? $totalHargaStokNew / $sisaNew : 0;
            }

            // save data
            $data = $req->except(['_method', '_token']);
            $data['masuk'] = $req->masuk ?? 0;
            $data['keluar'] = $req->keluar ?? 0;
            $data['sisa'] = $sisaNew;
            $data['pembelian_atk_id'] = $req->pembelian_atk_id ?? 0;
            $data['komponen_beliatk_id'] = $req->komponen_beliatk_id ?? 0;
            $data['harga_unit_masuk'] = $req->jenis == 'masuk' ? $hargaUnitMasuk : 0;
            $data['total_harga_masuk'] = $req->jenis == 'masuk' ? $totalHargaMasuk : 0;
            $data['harga_unit_keluar'] = $req->jenis == 'keluar' ? $hargaUnitKeluar : 0;
            $data['total_harga_keluar'] = $req->jenis == 'keluar' ? $totalHargaKeluar : 0;
            $data['stok'] = $sisaNew;
            $data['harga_rata_rata'] = $hargaRataRataNew;
            $data['total_harga_stok'] = $totalHargaStokNew;

            $check = KartuStok::create($data);
            if(!$check) redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
            DB::commit();
            return redirect()->route('kartu-stok.index', ['instansi' => $instansi])->with('success', 'Data berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('fail', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KartuStok  $kartuStok
     * @return \Illuminate\Http\Response
     */
    public function show(KartuStok $kartuStok)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KartuStok  $kartuStok
     * @return \Illuminate\Http\Response
     */
    public function edit($kartuStok, $instansi)
    {
        // $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        // $atks = Atk::where('');
        // $data = KartuStok::find($kartuStok);
        // return view('kartu_stok.edit', compact('data', 'data_instansi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KartuStok  $kartuStok
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, KartuStok $kartuStok)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KartuStok  $kartuStok
     * @return \Illuminate\Http\Response
     */
    public function destroy($instansi, $id)
    {
        DB::beginTransaction();
        try {
            $kartuStok = KartuStok::findOrFail($id);

            $sisaOld = $kartuStok->sisa;
            $hargaRataRataOld = $kartuStok->harga_rata_rata;
            $totalHargaStokOld = $kartuStok->total_harga_stok;

            $kartuStok->delete();

            $nextKartuStok = KartuStok::where('atk_id', $kartuStok->atk_id)
                ->where('tanggal', '>', $kartuStok->tanggal)
                ->orderBy('tanggal')
                ->first();

            if ($nextKartuStok) {
                $nextKartuStok->update([
                    'sisa' => $nextKartuStok->sisa - $kartuStok->masuk + $kartuStok->keluar,
                    'harga_rata_rata' => $nextKartuStok->sisa != 0 ? ($nextKartuStok->total_harga_stok - $totalHargaStokOld) / $nextKartuStok->sisa : 0,
                    'total_harga_stok' => $nextKartuStok->sisa * $nextKartuStok->harga_rata_rata,
                ]);
            }

            DB::commit();

            return redirect()->back()->with('success', 'Data Kartu Stok berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('fail', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function jurnal(Request $req, $instansi)
    {
        // Validation
        $validator = Validator::make($req->all(), [
            'tahun2' => 'required',
            'bulan2' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        $date = Carbon::create($req->tahun, $req->bulan, 1);
        $lastDayOfMonth = $date->endOfMonth()->toDateString();

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

        $data_instansi = Instansi::where('nama_instansi', $instansi)->firstOrFail();

        $akun_debit = Akun::where('instansi_id', $data_instansi->id)
                        ->where('tipe', 'beban')
                        ->where('nama', 'LIKE', '%Persediaan ATK%')
                        ->first();
        $akun_kredit = Akun::where('instansi_id', $data_instansi->id)
                        ->where('tipe', 'persediaan')
                        ->where('nama', 'LIKE', '%Persediaan ATK%')
                        ->first();

        $query = KartuStok::whereHas('atk', function($q) use($data_instansi, $req) {
            if ($req->tahun2) {
                $q->whereYear('tanggal', $req->tahun2);
            }
            if ($req->bulan2) {
                $q->whereMonth('tanggal', $req->bulan2);
            }
            $q->where('instansi_id', $data_instansi->id);
        });

        $dataPembelian2 = $query->whereHas('pembelian_atk')->get();
        $dataTanpaPembelian2 = KartuStok::whereHas('atk', function($q) use($data_instansi, $req){
            if ($req->tahun2) {
                $q->whereYear('tanggal', $req->tahun2);
            }
            if ($req->bulan2) {
                $q->whereMonth('tanggal', $req->bulan2);
            }
            $q->where('instansi_id', $data_instansi->id);
        })
        ->where('pembelian_atk_id', 0)
        ->where('komponen_beliatk_id', 0)
        ->orderByDesc('tanggal')
        ->get();
        $data2 = $dataPembelian2->concat($dataTanpaPembelian2);

        $result = $data2->groupBy('atk_id')->map(function($group) {
            $totalMasuk = $group->sum('masuk');
            $totalKeluar = $group->sum('keluar');
            $totalHarga = $group->sum('komponen_beliatk.harga_total');

            $hargaPerUnit = $totalMasuk > 0 ? $totalHarga / $totalMasuk : 0;
            $hargaPenggunaan = $totalKeluar > 0 ? $hargaPerUnit * $totalKeluar : 0;

            return [
                'atk' => $group->first()->atk->nama_atk,
                'total_masuk' => $totalMasuk,
                'total_keluar' => $totalKeluar,
                'total_harga' => $totalHarga,
                'harga_per_unit' => $hargaPerUnit,
                'harga_per_penggunaan' => $hargaPenggunaan,
            ];
        });

        $totalHargaPenggunaan = intval(round($result->sum('harga_per_penggunaan')));

        $jurnal = Jurnal::firstOrCreate(
            [
                'instansi_id' => $data_instansi->id,
                'tanggal' => $lastDayOfMonth,
                'journable_type' => KartuStok::class,
            ],
            [
                'journable_id' => 0,
                'keterangan' => 'Penggunaan ATK periode: ' . $bulan[sprintf('%02d', $req->bulan2)] . ' ' . $req->tahun2,
                'akun_debit' => $akun_debit->id ?? null,
                'akun_kredit' => $akun_kredit->id ?? null,
                'nominal' => $totalHargaPenggunaan,
            ]
        );

        if(!$jurnal) return response()->json('Gagal membuat jurnal', 500);
        return response()->json('Jurnal berhasil dibuat');
    }

    public function updateKartuStok($atk_id)
    {
        $data = KartuStok::where('atk_id', $atk_id)->whereHas('pembelian_atk')->orderBy('tanggal')->get();
        $sisaSebelumnya = 0;

        foreach ($data as $item) {
            $item->sisa = ($sisaSebelumnya + ($item->masuk ?? 0)) - ($item->keluar ?? 0);
            $item->save();
            $sisaSebelumnya = $item->sisa;
        }
    }

    public function getNominal(Request $req, $instansi){
        $validator = Validator::make($req->all(), [
            'bulan' => 'required',
            'tahun' => 'required',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return response()->json($error, 400);
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
        $data = KartuStok::whereHas('atk', function($q) use($data_instansi){
            $q->where('instansi_id', $data_instansi->id);
        })->whereYear('tanggal', $req->tahun)->whereMonth('tanggal', $req->bulan)->get()->sum('total_harga_keluar') ?? 0;
        return response()->json($data);
    }
}
