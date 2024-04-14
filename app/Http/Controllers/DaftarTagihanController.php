<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\DaftarTagihan;
use App\Models\Kelas;
use App\Models\Sekolah;
use App\Models\Transaksi;
use App\Models\Yayasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DaftarTagihanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $daftarTagihan = DaftarTagihan::all();
        return view('daftar_tagihan.index', compact('daftarTagihan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sekolah = Sekolah::all();
        $kelas = Kelas::all();
        $akun = Akun::all();
        $transaksi = Transaksi::all();
        $yayasan = Yayasan::all();
        return view('daftar_tagihan.create', compact(['sekolah', 'kelas', 'akun', 'transaksi', 'yayasan']));
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
            'kode_sekolah' => 'required',
            'kode_kelas' => 'required',
            'kode_transaksi' => 'required',
            'nominal' => 'required',
            'kode_yayasan' => 'required',
            'persen_yayasan' => 'required',
            'awal_pembayaran' => 'required|date',
            'akhir_pembayaran' => 'required|date',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);

        // save data
        $data = $req->except(['_method', '_token']);
        $check = DaftarTagihan::create($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        return redirect()->route('daftar_tagihan.index')->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DaftarTagihan  $daftarTagihan
     * @return \Illuminate\Http\Response
     */
    public function show($daftarTagihan)
    {
        $sekolah = Sekolah::all();
        $kelas = Kelas::all();
        $akun = Akun::all();
        $transaksi = Transaksi::all();
        $yayasan = Yayasan::all();
        $data = DaftarTagihan::find($daftarTagihan);
        return view('daftar_tagihan.show', compact(['sekolah', 'kelas', 'akun', 'transaksi', 'yayasan', 'data']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DaftarTagihan  $daftarTagihan
     * @return \Illuminate\Http\Response
     */
    public function edit($daftarTagihan)
    {
        $sekolah = Sekolah::all();
        $kelas = Kelas::all();
        $akun = Akun::all();
        $transaksi = Transaksi::all();
        $yayasan = Yayasan::all();
        $data = DaftarTagihan::find($daftarTagihan);
        return view('daftar_tagihan.edit', compact(['sekolah', 'kelas', 'akun', 'transaksi', 'yayasan', 'data']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DaftarTagihan  $daftarTagihan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $daftarTagihan)
    {
        // validation
        $validator = Validator::make($req->all(), [
            'kode_sekolah' => 'required',
            'kode_kelas' => 'required',
            'kode_transaksi' => 'required',
            'nominal' => 'required',
            'kode_yayasan' => 'required',
            'persen_yayasan' => 'required',
            'awal_pembayaran' => 'required|date',
            'akhir_pembayaran' => 'required|date',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);

        // save data
        $data = $req->except(['_method', '_token']);
        $check = DaftarTagihan::find($daftarTagihan)->update($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal diupdate');
        return redirect()->route('daftar_tagihan.index')->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DaftarTagihan  $daftarTagihan
     * @return \Illuminate\Http\Response
     */
    public function destroy($daftarTagihan)
    {
        $data = DaftarTagihan::find($daftarTagihan);
        if(!$data) return response()->json(['msg' => 'Data tidak ditemukan'], 404);
        $check = $data->delete();
        if(!$check) return response()->json(['msg' => 'Gagal menghapus data'], 400);
        return response()->json(['msg' => 'Data berhasil dihapus']);
    }
}
