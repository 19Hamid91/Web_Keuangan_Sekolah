<?php

namespace App\Http\Controllers;

use App\Models\Biro;
use App\Models\Instansi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BiroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $biro = Biro::orderByDesc('id')->get();
        return view('master.biro.index', compact('biro', 'data_instansi'));
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
            'nama' => 'required',
            'alamat' => 'required',
            'telpon' => 'required|numeric|digits_between:11,13'
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $checkTelpon = Biro::where('telpon', $req->telpon)->first();
        if($checkTelpon) return redirect()->back()->withInput()->with('fail', 'Nomor Telpon sudah digunakan');

        // save data
        $data = $req->except(['_method', '_token']);
        $check = Biro::create($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Biro  $biro
     * @return \Illuminate\Http\Response
     */
    public function show(Biro $biro)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Biro  $biro
     * @return \Illuminate\Http\Response
     */
    public function edit(Biro $biro)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Biro  $biro
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $instansi, $id)
    {
        // validation
        $validator = Validator::make($req->all(), [
            'nama' => 'required',
            'alamat' => 'required',
            'telpon' => 'required|numeric|digits_between:11,13'
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $checkTelpon = Biro::where('telpon', $req->telpon)->where('id', '!=', $id)->first();
        if($checkTelpon) return redirect()->back()->withInput()->with('fail', 'Nomor Telpon sudah digunakan');

        // save data
        $data = $req->except(['_method', '_token']);
        $check = Biro::find($id)->update($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal diupdate');
        return redirect()->back()->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Biro  $biro
     * @return \Illuminate\Http\Response
     */
    public function destroy($instansi, $id)
    {
        $data = Biro::find($id);
        if(!$data) return response()->json(['msg' => 'Data tidak ditemukan'], 404);
        $check = $data->delete();
        if(!$check) return response()->json(['msg' => 'Gagal menghapus data'], 400);
        return response()->json(['msg' => 'Data berhasil dihapus']);
    }
}
