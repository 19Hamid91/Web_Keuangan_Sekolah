<?php

namespace App\Http\Controllers;

use App\Models\Atk;
use App\Models\Instansi;
use App\Models\KartuStok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KartuStokController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $data = KartuStok::whereHas('atk', function($q) use($data_instansi){
            $q->where('instansi_id', $data_instansi->id);
        })->orderByDesc('id')->get();
        $atks = Atk::where('instansi_id', $data_instansi->id)->get();
        return view('kartu_stok.index', compact('data', 'atks', 'data_instansi'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $atks = Atk::where('instansi_id', $data_instansi->id)->get();
        return view('kartu_stok.create', compact('atks', 'data_instansi'));
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
            'atk_id' => 'required',
            'tanggal' => 'required|date',
            'pengambil' => 'required',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        if (!$req->masuk && !$req->keluar) return redirect()->back()->withInput()->with('fail', 'Jumlah tidak boleh kosong');

        // get sisa
        $sisaOld = KartuStok::where('atk_id', $req->atk_id)->latest()->first()->sisa ?? 0;
        $sisaNew = ($sisaOld - $req->keluar) + $req->masuk;
        if($sisaNew < 5) return redirect()->back()->withInput()->with('fail', 'Sisa stok terlalu sedikit' . $sisaNew);
        
        // save data
        $data = $req->except(['_method', '_token']);
        $data['masuk'] = $req->masuk;
        $data['keluar'] = $req->keluar;
        $data['sisa'] = $sisaNew;
        $check = KartuStok::create($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        return redirect()->route('kartu-stok.index', ['instansi' => $instansi])->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KartuStok  $kartuStok
     * @return \Illuminate\Http\Response
     */
    public function show(KartuStok $kartuStok)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KartuStok  $kartuStok
     * @return \Illuminate\Http\Response
     */
    public function edit($kartuStok, $instansi)
    {
        // $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        // $atks = Atk::where('');
        // $data = KartuStok::find($kartuStok);
        // return view('kartu_stok.edit', compact('data', 'data_instansi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KartuStok  $kartuStok
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, KartuStok $kartuStok)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KartuStok  $kartuStok
     * @return \Illuminate\Http\Response
     */
    public function destroy(KartuStok $kartuStok)
    {
        //
    }
}
