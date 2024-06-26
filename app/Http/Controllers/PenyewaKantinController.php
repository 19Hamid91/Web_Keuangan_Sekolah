<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use App\Models\PenyewaKantin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PenyewaKantinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $penyewa_kantin = PenyewaKantin::orderByDesc('id')->where('instansi_id', $data_instansi->id)->get();
        return view('master.penyewa_kantin.index', compact('penyewa_kantin', 'data_instansi'));
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
            'nama' => 'required',
            'alamat' => 'required',
            'telpon' => 'required',
            'instansi_id' => 'required',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);

        // save data
        $data = $req->except(['_method', '_token']);
        $check = PenyewaKantin::create($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PenyewaKantin  $penyewaKantin
     * @return \Illuminate\Http\Response
     */
    public function show(PenyewaKantin $penyewaKantin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PenyewaKantin  $penyewaKantin
     * @return \Illuminate\Http\Response
     */
    public function edit(PenyewaKantin $penyewaKantin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PenyewaKantin  $penyewaKantin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $instansi, $id)
    {
        // validation
        $validator = Validator::make($req->all(), [
            'nama' => 'required',
            'alamat' => 'required',
            'telpon' => 'required',
            'instansi_id' => 'required',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);

        // save data
        $data = $req->except(['_method', '_token']);
        $check = PenyewaKantin::find($id)->update($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal diupdate');
        return redirect()->back()->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PenyewaKantin  $penyewaKantin
     * @return \Illuminate\Http\Response
     */
    public function destroy($instansi, $id)
    {
        $data = PenyewaKantin::find($id);
        if(!$data) return response()->json(['msg' => 'Data tidak ditemukan'], 404);
        $check = $data->delete();
        if(!$check) return response()->json(['msg' => 'Gagal menghapus data'], 400);
    }
}
