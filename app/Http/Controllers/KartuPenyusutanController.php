<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\Aset;
use App\Models\Instansi;
use App\Models\Jurnal;
use App\Models\KartuPenyusutan;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KartuPenyusutanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $asets = KartuPenyusutan::wwhereHas('pembelian_aset')->hereHas('aset', function($q) use($data_instansi){
            $q->where('instansi_id', $data_instansi->id);
        })->orderByDesc('id')->with('aset', 'pembelian_aset', 'komponen')->get();
        $akun = Akun::where('instansi_id', $data_instansi->id)->get();
        $allaset = Aset::where('instansi_id', $data_instansi->id)->get();
        return view('kartu_penyusutan.index', compact('asets', 'data_instansi', 'akun', 'allaset'));
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
    public function store(Request $req, $instansi)
    {
         // validation
         $validator = Validator::make($req->all(), [
            'aset_id' => 'required|exists:t_aset,id',
            'nama_barang' => 'required',
            'tanggal_operasi' => 'required|date',
            'masa_penggunaan' => 'required|numeric',
            'residu' => 'required|numeric',
            'harga_beli' => 'required|numeric',
            'metode' => 'required',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);

        // save data
        $data = $req->except(['_method', '_token']);
        $check = KartuPenyusutan::create($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Gagal menambahkan data');
        return redirect()->back()->with('success', 'Berhasil menambahkan data');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KartuPenyusutan  $kartuPenyusutan
     * @return \Illuminate\Http\Response
     */
    public function show($instansi, $id)
    {
        $data = KartuPenyusutan::with('aset', 'pembelian_aset', 'komponen')->find($id);
        if(!$data) return response()->json('Data not found', 404);
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KartuPenyusutan  $kartuPenyusutan
     * @return \Illuminate\Http\Response
     */
    public function edit(KartuPenyusutan $kartuPenyusutan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KartuPenyusutan  $kartuPenyusutan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, KartuPenyusutan $kartuPenyusutan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KartuPenyusutan  $kartuPenyusutan
     * @return \Illuminate\Http\Response
     */
    public function destroy(KartuPenyusutan $kartuPenyusutan)
    {
        //
    }

    public function save(Request $req)
    {
        // validation
        $validator = Validator::make($req->all(), [
            'id' => 'required|exists:t_kartupenyusutan',
            'aset_id' => 'required|exists:t_aset,id',
            'nama_barang' => 'required',
            'tanggal_operasi' => 'required|date',
            'masa_penggunaan' => 'required|numeric',
            'residu' => 'required|numeric',
            'metode' => 'required',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return response()->json(['msg' => $error], 400);

        // save data
        $data = $req->except(['_method', '_token', 'id']);
        $check = KartuPenyusutan::find($req->id)->update($data);
        if(!$check) return response()->json(['msg' => 'Gagal menyimpan data'], 400);
        return response()->json(['msg' => 'Berhasil menyimpan data'], 201);
    }

    public function jurnal(Request $req, $instansi)
    {
        // validation
        $validator = Validator::make($req->all(), [
            'id' => 'required',
            'akun_debit' => 'required',
            'akun_kredit' => 'required',
            'nominal' => 'required|numeric',
            'tanggal' => 'required|date',
        ]);

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

        $newPenyusutan = KartuPenyusutan::with('pembelian_aset', 'aset')->find($req->id);
        $penyusutan = $this->calculateDepreciation(($newPenyusutan->pembelian_aset->total ?? $newPenyusutan->harga_beli), $newPenyusutan->masa_penggunaan, $newPenyusutan->residu, $newPenyusutan->tanggal_operasi);

        list($year, $month, $day) = explode('-', $req->tanggal);
        try {
            DB::transaction(function () use ($req, $data_instansi, $newPenyusutan, $bulan, $month, $day) {
                Jurnal::where('instansi_id', $data_instansi->id)
                    ->where('journable_type', KartuPenyusutan::class)
                    ->where('journable_id', $req->id)
                    ->get()
                    ->each(function ($item) {
                        $item->forceDelete();
                    });
    
                for ($i = 0; $i < count($req->tahun); $i++) {
                    $dateString = sprintf('%04d-%02d-%02d', $req->tahun[$i], $month, $day);
                    $date = Carbon::createFromFormat('Y-m-d', $dateString);
    
                    $dataToSave = [
                        'instansi_id' => $data_instansi->id,
                        'tanggal' => $date,
                        'journable_type' => KartuPenyusutan::class,
                        'journable_id' => $req->id,
                        'keterangan' => 'Penyusutan ' . $newPenyusutan->aset->nama_aset . ' periode: ' . $bulan[sprintf('%02d', $month)] . ' ' . $req->tahun[$i],
                        'akun_debit' => $req->akun_debit ?? null,
                        'akun_kredit' => null,
                        'nominal' => $req->beban[$i],
                    ];
    
                    $dataToSave2 = [
                        'instansi_id' => $data_instansi->id,
                        'tanggal' => $date,
                        'journable_type' => KartuPenyusutan::class,
                        'journable_id' => $req->id,
                        'keterangan' => 'Penyusutan ' . $newPenyusutan->aset->nama_aset . ' periode: ' . $bulan[sprintf('%02d', $month)] . ' ' . $req->tahun[$i],
                        'akun_debit' => null,
                        'akun_kredit' => $req->akun_kredit ?? null,
                        'nominal' => $req->beban[$i],
                    ];
    
                    Jurnal::create($dataToSave);
                    Jurnal::create($dataToSave2);
                }
            });
    
            return redirect()->back()->with('success', 'Jurnal berhasil disimpan');
        } catch (\Exception $e) {
            return redirect()->back()->with('fail', 'Terjadi kesalahan saat menyimpan jurnal: ' . $e->getMessage())->withInput();
        }
    }

    public function calculateDepreciation($harga_beli, $masa, $residu, $tanggal)
    {
        $nilai_susut = ($harga_beli - $residu) / ($masa == 0 ? 1 : $masa);
        $bulan = (new DateTime($tanggal))->format('m') + 1;
        $tahun = (new DateTime($tanggal))->format('Y');
        $total_bulan = $masa * 12;
        $akumulasi_susut = 0;
        $nilai_buku = $harga_beli;

        $result = [];

        for ($i = 0; $i <= $masa; $i++) {
            if ($i == 0) {
                $penyusutan_berjalan = (12 - $bulan) / 12 * $nilai_susut;
                $total_bulan -= (12 - $bulan);
                $akumulasi_susut += $penyusutan_berjalan;
                $nilai_buku -= $penyusutan_berjalan;

                $result[$tahun][] = [
                    'tahun' => $tahun,
                    'penyusutan_berjalan' => round($penyusutan_berjalan),
                    'akumulasi_susut' => round($akumulasi_susut),
                    'nilai_buku' => round($nilai_buku)
                ];
            } else {
                if ($total_bulan > 12) {
                    $penyusutan_berjalan = $nilai_susut;
                    $total_bulan -= 12;
                } else {
                    $penyusutan_berjalan = $total_bulan / 12 * $nilai_susut;
                    $total_bulan -= $total_bulan;
                }
                $tahun++;
                $akumulasi_susut += $penyusutan_berjalan;
                $nilai_buku -= $penyusutan_berjalan;

                $result[$tahun][] = [
                    'tahun' => $tahun,
                    'penyusutan_berjalan' => round($penyusutan_berjalan),
                    'akumulasi_susut' => round($akumulasi_susut),
                    'nilai_buku' => round($nilai_buku)
                ];
            }
        }

        return $result;
    }

    public function cetak(Request $req, $instansi)
    {
        $data = KartuPenyusutan::find($req->id);
        dd($data);
    }
}
