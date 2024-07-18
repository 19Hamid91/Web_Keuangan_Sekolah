<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\Instansi;
use App\Models\PemasukanYayasan;
use Barryvdh\DomPDF\Facade\Pdf;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PemasukanYayasanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req, $instansi)
    {
        $query = PemasukanYayasan::with(['journals']);

        if ($req->tahun) {
            $query->whereYear('tanggal', $req->tahun);
        }
        if ($req->bulan) {
            $query->whereMonth('tanggal', $req->bulan);
        }

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

        $akuns = Akun::where('instansi_id', 1)->get();
        $data = $query->get();
        $tanggal = PemasukanYayasan::pluck('tanggal');
        $tahunAll = $tanggal->map(function ($date) {
            return (new DateTime($date))->format('Y');
        });
        $tahun = $tahunAll->unique()->values();
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        return view('pemasukan_yayasan.index', compact('data', 'akuns', 'bulan', 'tahun', 'data_instansi'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pemasukan_yayasan.create');
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
            'tanggal' => 'required|date',
            'keterangan' => 'required',
            'total' => 'required|numeric',
            'jenis' => 'required|in:SPP,JPI',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();

        // save data
        $data = $req->except(['_method', '_token']);
        $check = PemasukanYayasan::create($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        return redirect()->route('pemasukan_yayasan.index', ['instansi' => $instansi])->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PemasukanYayasan  $pemasukanYayasan
     * @return \Illuminate\Http\Response
     */
    public function show(PemasukanYayasan $pemasukanYayasan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PemasukanYayasan  $pemasukanYayasan
     * @return \Illuminate\Http\Response
     */
    public function edit($instansi, $pemasukanYayasan)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $data = PemasukanYayasan::find($pemasukanYayasan);
        return view('pemasukan_yayasan.edit', compact('data', 'data_instansi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PemasukanYayasan  $pemasukanYayasan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $instansi, $pemasukanYayasan)
    {
          // validation
          $validator = Validator::make($req->all(), [
            'tanggal' => 'required|date',
            'keterangan' => 'required',
            'total' => 'required|numeric',
            'jenis' => 'required|in:SPP,JPI',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();

        // save data
        $data = $req->except(['_method', '_token']);
        $check = PemasukanYayasan::find($pemasukanYayasan)->update($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        return redirect()->route('pemasukan_yayasan.index', ['instansi' => $instansi])->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PemasukanYayasan  $pemasukanYayasan
     * @return \Illuminate\Http\Response
     */
    public function destroy($instansi, $pemasukanYayasan)
    {
        $data = PemasukanYayasan::find($pemasukanYayasan);
        if(!$data) return response()->json(['msg' => 'Data tidak ditemukan'], 404);
        $check = $data->delete();
        if(!$check) return response()->json(['msg' => 'Gagal menghapus data'], 400);
        return response()->json(['msg' => 'Data berhasil dihapus']);
    }

    public function cetak($instansi, $pemasukanYayasan)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $data = PemasukanYayasan::find($pemasukanYayasan)->toArray();
        $data['instansi_id'] = $data_instansi->id;
        $pdf = Pdf::loadView('pemasukan_yayasan.cetak', $data)->setPaper('a4', 'landscape');
        return $pdf->stream('kwitansi-pemasukan-yayasan.pdf');
    }
}
