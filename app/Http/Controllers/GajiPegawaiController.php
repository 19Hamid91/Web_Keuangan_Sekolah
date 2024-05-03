<?php

namespace App\Http\Controllers;

use App\Models\GajiPegawai;
use App\Models\KomponenGaji;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GajiPegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pegawai = Pegawai::with('gaji_pegawai')->whereHas('gaji_pegawai')->get();
        return view('gaji_pegawai.index', compact('pegawai'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pegawai = Pegawai::all();
        $komponenGaji = KomponenGaji::all();
        return view('gaji_pegawai.create', compact('pegawai', 'komponenGaji'));
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
            'nip' => 'required',
            'kode_komponen_gaji' => 'required',
            'jumlah' => 'required',
            'nominal' => 'required',
            'tanggal' => 'required',
            'status' => 'required',
            'total_gaji' => 'required'
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        
        // save data
        $data = $req->except(['_method', '_token', 'jumlah', 'nominal', 'kode_komponen_gaji', 'sum', 'jenis']);
        $data['kode'] = 'GJP' . date('Ymd') . $data['nip'];
        
        for ($i=0; $i < count($req->kode_komponen_gaji); $i++) { 
            $data['kode_komponen_gaji'] = $req->kode_komponen_gaji[$i];
            $data['jumlah'] = $req->jumlah[$i];
            $data['nominal'] = $req->nominal[$i];
            $check = GajiPegawai::create($data);
            if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        }
        return redirect()->route('gaji_pegawai.index')->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GajiPegawai  $gajiPegawai
     * @return \Illuminate\Http\Response
     */
    public function show($gajiPegawai)
    {
        $data = GajiPegawai::where('nip', $gajiPegawai)->get();
        $pegawai = Pegawai::all();
        $komponenGaji = KomponenGaji::all();
        return view('gaji_pegawai.show', compact('pegawai', 'komponenGaji', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GajiPegawai  $gajiPegawai
     * @return \Illuminate\Http\Response
     */
    public function edit($gajiPegawai)
    {
        $data = GajiPegawai::where('nip', $gajiPegawai)->get();
        $pegawai = Pegawai::all();
        $komponenGaji = KomponenGaji::all();
        return view('gaji_pegawai.edit', compact('pegawai', 'komponenGaji', 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GajiPegawai  $gajiPegawai
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $gajiPegawai)
    {
        // validation
        $validator = Validator::make($req->all(), [
            'nip' => 'required',
            'kode_komponen_gaji' => 'required',
            'jumlah' => 'required',
            'nominal' => 'required',
            'tanggal' => 'required',
            'status' => 'required',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);

        // save data
        $data = $req->except(['_method', '_token']);
        $check = GajiPegawai::find($gajiPegawai)->update($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal diupdate');
        return redirect()->route('gaji_pegawai.index')->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GajiPegawai  $gajiPegawai
     * @return \Illuminate\Http\Response
     */
    public function destroy($gajiPegawai)
    {
        $data = GajiPegawai::where('nip', $gajiPegawai)->get();
        if($data->isEmpty()) return response()->json(['msg' => 'Data tidak ditemukan'], 404);
        $check = $data->each->delete();
        if(!$check) return response()->json(['msg' => 'Gagal menghapus data'], 400);
        return response()->json(['msg' => 'Data berhasil dihapus']);
    }
}
