<?php

namespace App\Http\Controllers;

use App\Models\Atk;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AtkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($sekolah)
    {
        $data_sekolah = Sekolah::where('nama', $sekolah)->first();
        $atk = Atk::where('sekolah_id', $data_sekolah->id)->get();
        return view('master.atk.index', compact('atk', 'data_sekolah'));
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
            'sekolah_id' => 'required'
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);

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
    public function update(Request $req, $sekolah, $id)
    {
        // validation
        $validator = Validator::make($req->all(), [
            'nama' => 'required',
            'sekolah_id' => 'required'
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        $checkNama = Atk::where('nama', $req->nama)->where('id', '!=', $id)->first();
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
    public function destroy($sekolah, $id)
    {
        $data = Atk::find($id);
        if(!$data) return response()->json(['msg' => 'Data tidak ditemukan'], 404);
        $check = $data->delete();
        if(!$check) return response()->json(['msg' => 'Gagal menghapus data'], 400);
        return response()->json(['msg' => 'Data berhasil dihapus']);
    }
}
