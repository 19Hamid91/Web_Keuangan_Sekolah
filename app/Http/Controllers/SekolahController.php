<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SekolahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sekolah = Sekolah::all();
        return view('master.sekolah.index', compact('sekolah'));
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
    public function store(Request $req)
    {
        // validation
        $validator = Validator::make($req->all(), [
            'kode' => 'required',
            'nama_sekolah' => 'required'
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        $checkKode = Sekolah::where('kode', $req->kode)->first();
        if($checkKode) return redirect()->back()->withInput()->with('fail', 'Kode sudah digunakan');

        // save data
        $data = $req->except(['_method', '_token']);
        $check = Sekolah::create($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        return redirect()->back()->withInput()->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sekolah  $sekolah
     * @return \Illuminate\Http\Response
     */
    public function show(Sekolah $sekolah)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sekolah  $sekolah
     * @return \Illuminate\Http\Response
     */
    public function edit(Sekolah $sekolah)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sekolah  $sekolah
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $sekolah)
    {
        // validation
        $validator = Validator::make($req->all(), [
            'kode' => 'required',
            'nama_sekolah' => 'required'
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        $checkKode = Sekolah::where('kode', $req->kode)->where('id', '!=', $sekolah)->first();
        if($checkKode) return redirect()->back()->withInput()->with('fail', 'Kode sudah digunakan');

        // save data
        $data = $req->except(['_method', '_token']);
        $check = Sekolah::find($sekolah)->update($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal diperbarui');
        return redirect()->back()->withInput()->with('success', 'Data berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sekolah  $sekolah
     * @return \Illuminate\Http\Response
     */
    public function destroy($sekolah)
    {
        $data = Sekolah::find($sekolah);
        if(!$data) return response()->json(['msg' => 'Data tidak ditemukan'], 404);
        $check = $data->delete();
        if(!$check) return response()->json(['msg' => 'Gagal menghapus data'], 400);
        return response()->json(['msg' => 'Data berhasil dihapus']);
    }
}
