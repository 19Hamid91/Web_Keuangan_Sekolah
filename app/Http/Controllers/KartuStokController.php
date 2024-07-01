<?php

namespace App\Http\Controllers;

use App\Models\Atk;
use App\Models\Instansi;
use App\Models\KartuStok;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
        $filterTahun = $req->tahun;
        $filterBulan = $req->bulan;

        $dataPembelian = KartuStok::whereHas('atk', function($q) use($data_instansi){
            $q->where('instansi_id', $data_instansi->id);
        })->orderByDesc('tanggal')->whereHas('pembelian_atk')->get();
        $dataTanpaPembelian = KartuStok::whereHas('atk', function($q) use ($data_instansi) {
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

        $tahun = $data->map(function ($jurnal) {
            return Carbon::parse($jurnal->tanggal)->year;
        })->unique()->values();

        $dataPembelian2 = KartuStok::whereHas('atk', function($q) use($data_instansi, $filterBulan, $filterTahun){
            if ($filterTahun) {
                $q->whereYear('tanggal', $filterTahun);
            }
            if ($filterBulan) {
                $q->whereMonth('tanggal', $filterBulan);
            }
            $q->where('instansi_id', $data_instansi->id);
        })->orderByDesc('tanggal')->whereHas('pembelian_atk')->get();
        $dataTanpaPembelian2 = KartuStok::whereHas('atk', function($q) use($data_instansi, $filterBulan, $filterTahun){
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
        $atks = Atk::where('instansi_id', $data_instansi->id)->get();
        return view('kartu_stok.index', compact('data', 'atks', 'data_instansi', 'result', 'bulan', 'tahun'));
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
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        if (!$req->masuk && !$req->keluar) return redirect()->back()->withInput()->with('fail', 'Jumlah tidak boleh kosong');

        // get sisa
        $sisaOld = KartuStok::where('atk_id', $req->atk_id)->orderByDesc('tanggal')->first()->sisa ?? 0;
        $sisaNew = ($sisaOld - $req->keluar) + $req->masuk;
        if($sisaNew < 5) return redirect()->back()->withInput()->with('fail', 'Sisa stok terlalu sedikit' . $sisaNew);
        
        // save data
        $data = $req->except(['_method', '_token']);
        $data['masuk'] = $req->masuk;
        $data['keluar'] = $req->keluar;
        $data['sisa'] = $sisaNew;
        $data['pembelian_atk_id'] = 0;
        $data['komponen_beliatk_id'] = 0;
        $check = KartuStok::create($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        return redirect()->route('kartu-stok.index', ['instansi' => $instansi])->with('success', 'Data berhasil ditambahkan');
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
    public function destroy(KartuStok $kartuStok)
    {
        //
    }
}
