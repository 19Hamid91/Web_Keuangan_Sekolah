<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transaksi = Transaksi::with('akun')->get();
        $akun = Akun::all();
        return view('master.transaksi.index', compact(['transaksi', 'akun']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $akun = Akun::all();
        return view('master.transaksi.create', compact('akun'));
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
            'kode_akun' => 'required',
            'kode' => 'required',
            'nama_transaksi' => 'required',
            'jenis_transaksi' => 'required',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        $checkKode = Transaksi::where('kode', $req->kode)->first();
        if($checkKode) return redirect()->back()->withInput()->with('fail', 'Kode sudah digunakan');

        // save data
        $data = $req->except(['_method', '_token']);
        $check = Transaksi::create($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        return redirect()->route('transaksi.index')->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function show($transaksi)
    {
        $transaksi = Transaksi::find($transaksi);
        $akun = Akun::all();
        return view('master.transaksi.show', compact(['transaksi', 'akun']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function edit($transaksi)
    {
        $transaksi = Transaksi::find($transaksi);
        $akun = Akun::all();
        return view('master.transaksi.show', compact(['transaksi', 'akun']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $transaksi)
    {
        // validation
        $validator = Validator::make($req->all(), [
            'kode_akun' => 'required',
            'kode' => 'required',
            'nama_transaksi' => 'required',
            'jenis_transaksi' => 'required',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        $checkKode = Transaksi::where('kode', $req->kode)->where('id', '!=', $transaksi)->first();
        if($checkKode) return redirect()->back()->withInput()->with('fail', 'Kode sudah digunakan');

        // save data
        $data = $req->except(['_method', '_token']);
        $check = Transaksi::find($transaksi)->update($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal diupdate');
        return redirect()->route('transaksi.index')->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function destroy($transaksi)
    {
        $data = Transaksi::find($transaksi);
        if(!$data) return response()->json(['msg' => 'Data tidak ditemukan'], 404);
        $check = $data->delete();
        if(!$check) return response()->json(['msg' => 'Gagal menghapus data'], 400);
        return response()->json(['msg' => 'Data berhasil dihapus']);
    }
}
