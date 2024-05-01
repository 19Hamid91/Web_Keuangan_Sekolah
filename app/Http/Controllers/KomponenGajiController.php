<?php

namespace App\Http\Controllers;

use App\Models\KomponenGaji;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KomponenGajiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $komponenGaji = KomponenGaji::all();
        return view('komponen_gaji.index', compact('komponenGaji'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $transaksi = Transaksi::where('jenis_transaksi', 'PENGELUARAN')->get();
        $latestKompGaji = KomponenGaji::withTrashed()->orderByDesc('id')->get();
        if(count($latestKompGaji) < 1){
            $getKode = 'KMG' . date('YmdHis') . '00001';
        } else {
            $lastPembayaran = $latestKompGaji->first();
            $kode = substr($lastPembayaran->kode, -5);
            $getKode = 'KMG' . date('YmdHis') . str_pad((int)$kode + 1, 5, '0', STR_PAD_LEFT);
        }
        return view('komponen_gaji.create', compact('transaksi', 'getKode'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        // validation
        $validator = Validator::make($req->all(), [
            'kode' => 'required',
            'kode_transaksi' => 'required',
            'nominal' => 'required',
            'tanggal' => 'required',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        $checkKode = KomponenGaji::where('kode', $req->kode)->first();
        if($checkKode) return redirect()->back()->withInput()->with('fail', 'Kode sudah digunakan');

        // save data
        $data = $req->except(['_method', '_token']);
        $check = KomponenGaji::create($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        return redirect()->route('komponen_gaji.index')->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KomponenGaji  $komponenGaji
     * @return \Illuminate\Http\Response
     */
    public function show($komponenGaji)
    {
        $data = KomponenGaji::find($komponenGaji);
        $transaksi = Transaksi::where('jenis_transaksi', 'PENGELUARAN')->get();
        return view('komponen_gaji.show', compact('data', 'transaksi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KomponenGaji  $komponenGaji
     * @return \Illuminate\Http\Response
     */
    public function edit($komponenGaji)
    {
        $data = KomponenGaji::find($komponenGaji);
        $transaksi = Transaksi::where('jenis_transaksi', 'PENGELUARAN')->get();
        return view('komponen_gaji.edit', compact('data', 'transaksi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KomponenGaji  $komponenGaji
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $komponenGaji)
    {
        // validation
        $validator = Validator::make($req->all(), [
            'kode' => 'required',
            'kode_transaksi' => 'required',
            'nominal' => 'required',
            'tanggal' => 'required',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        $checkKode = KomponenGaji::where('kode', $req->kode)->where('id', '!=', $komponenGaji)->first();
        if($checkKode) return redirect()->back()->withInput()->with('fail', 'Kode sudah digunakan');

        // save data
        $data = $req->except(['_method', '_token']);
        $check = KomponenGaji::find($komponenGaji)->update($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal diupdate');
        return redirect()->route('komponen_gaji.index')->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KomponenGaji  $komponenGaji
     * @return \Illuminate\Http\Response
     */
    public function destroy($komponenGaji)
    {
        $data = KomponenGaji::find($komponenGaji);
        if(!$data) return response()->json(['msg' => 'Data tidak ditemukan'], 404);
        $check = $data->delete();
        if(!$check) return response()->json(['msg' => 'Gagal menghapus data'], 400);
        return response()->json(['msg' => 'Data berhasil dihapus']);
    }
}
