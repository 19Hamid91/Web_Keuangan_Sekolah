<?php

namespace App\Http\Controllers;

use App\Models\Atk;
use App\Models\Instansi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AtkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $atk = Atk::orderByDesc('id')->where('instansi_id', $data_instansi->id)->get();
        return view('master.atk.index', compact('atk', 'data_instansi'));
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
            'nama_atk' => 'required',
            'instansi_id' => 'required'
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $checkNama = Atk::where('instansi_id', $data_instansi->id)->where('nama_atk', $req->nama_atk)->first();
        if($checkNama) return redirect()->back()->withInput()->with('fail', 'Nama sudah digunakan');

        // save data
        $data = $req->except(['_method', '_token']);
        $check = Atk::create($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Atk  $atk
     * @return \Illuminate\Http\Response
     */
    public function show(Atk $atk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Atk  $atk
     * @return \Illuminate\Http\Response
     */
    public function edit(Atk $atk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Atk  $atk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $instansi, $id)
    {
        // validation
        $validator = Validator::make($req->all(), [
            'nama_atk' => 'required',
            'instansi_id' => 'required'
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $checkNama = Atk::where('instansi_id', $data_instansi->id)->where('nama_atk', $req->nama_atk)->first();
        if($checkNama) return redirect()->back()->withInput()->with('fail', 'Nama sudah digunakan');

        // save data
        $data = $req->except(['_method', '_token']);
        $check = Atk::find($id)->update($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal diupdate');
        return redirect()->back()->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Atk  $atk
     * @return \Illuminate\Http\Response
     */
    public function destroy($instansi, $id)
    {
        $data = Atk::find($id);
        if(!$data) return response()->json(['msg' => 'Data tidak ditemukan'], 404);
        $check = $data->delete();
        if(!$check) return response()->json(['msg' => 'Gagal menghapus data'], 400);
        return response()->json(['msg' => 'Data berhasil dihapus']);
    }
}
