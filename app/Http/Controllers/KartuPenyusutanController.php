<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use App\Models\KartuPenyusutan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KartuPenyusutanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $asets = KartuPenyusutan::whereHas('aset', function($q) use($data_instansi){
            $q->where('instansi_id', $data_instansi->id);
        })->orderByDesc('id')->with('aset', 'pembelian_aset')->get();
        return view('kartu_penyusutan.index', compact('asets'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KartuPenyusutan  $kartuPenyusutan
     * @return \Illuminate\Http\Response
     */
    public function show(KartuPenyusutan $kartuPenyusutan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KartuPenyusutan  $kartuPenyusutan
     * @return \Illuminate\Http\Response
     */
    public function edit(KartuPenyusutan $kartuPenyusutan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KartuPenyusutan  $kartuPenyusutan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, KartuPenyusutan $kartuPenyusutan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KartuPenyusutan  $kartuPenyusutan
     * @return \Illuminate\Http\Response
     */
    public function destroy(KartuPenyusutan $kartuPenyusutan)
    {
        //
    }

    public function save(Request $req)
    {
        // validation
        $validator = Validator::make($req->all(), [
            'id' => 'required|exists:t_kartupenyusutan',
            'aset_id' => 'required|exists:t_aset,id',
            'nama_barang' => 'required',
            'tanggal_operasi' => 'required|date',
            'masa_penggunaan' => 'required|numeric',
            'residu' => 'required|numeric',
            'metode' => 'required',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return response()->json(['msg' => $error], 400);

        // save data
        $data = $req->except(['_method', '_token', 'id']);
        $check = KartuPenyusutan::find($req->id)->update($data);
        if(!$check) return response()->json(['msg' => 'Gagal menyimpan data'], 400);
        return response()->json(['msg' => 'Berhasil menyimpan data'], 201);
    }
}
