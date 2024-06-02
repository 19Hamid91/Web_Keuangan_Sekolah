<?php

namespace App\Http\Controllers;

use App\Models\Atk;
use App\Models\Instansi;
use App\Models\KartuStok;
use App\Models\PembelianAtk;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PembelianAtkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $data = PembelianAtk::orderByDesc('id')->whereHas('atk', function($q) use($data_instansi){
            $q->where('instansi_id', $data_instansi->id);
        })->get();
        $atks = Atk::where('instansi_id', $data_instansi->id)->get();
        $suppliers = Supplier::where('jenis_supplier', 'ATK')->get();
        return view('pembelian_atk.index', compact('data_instansi', 'data', 'atks', 'suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($instansi)
    {
        $data_instansi = instansi::where('nama_instansi', $instansi)->first();
        $suppliers = Supplier::where('jenis_supplier', 'ATK')->get();
        $atks = Atk::where('instansi_id', $data_instansi->id)->get();
        return view('pembelian_atk.create', compact('data_instansi', 'suppliers', 'atks'));
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
            'supplier_id' => 'required',
            'atk_id' => 'required',
            'tgl_beliatk' => 'required|date',
            'satuan' => 'required',
            'jumlah_atk' => 'required|numeric',
            'hargasatuan_atk' => 'required|numeric',
            'jumlahbayar_atk' => 'required|numeric',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);

        // save data
        $data = $req->except(['_method', '_token']);
        $check = PembelianAtk::create($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');

        $getSisaAtk = KartuStok::where('atk_id', $data['atk_id'])->latest()->first()->sisa ?? 0;

        $createKartuStok = new KartuStok();
        $createKartuStok->atk_id = $data['atk_id'];
        $createKartuStok->tanggal = $data['tgl_beliatk'];
        $createKartuStok->masuk = $data['jumlah_atk'];
        $createKartuStok->keluar = 0;
        $createKartuStok->sisa = intval($getSisaAtk) + intval($data['jumlah_atk']);
        $createKartuStok->pengambil = '-';
        $createKartuStok->save();

        return redirect()->route('pembelian-atk.index', ['instansi' => $instansi])->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PembelianAtk  $pembelianAtk
     * @return \Illuminate\Http\Response
     */
    public function show($instansi, $id)
    {
        $data_instansi = instansi::where('nama_instansi', $instansi)->first();
        $suppliers = Supplier::where('jenis_supplier', 'ATK')->get();
        $atks = Atk::where('instansi_id', $data_instansi->id)->get();
        $data = PembelianAtk::find($id);
        return view('pembelian_atk.show', compact('data_instansi', 'suppliers', 'atks', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PembelianAtk  $pembelianAtk
     * @return \Illuminate\Http\Response
     */
    public function edit($instansi, $id)
    {
        $data_instansi = instansi::where('nama_instansi', $instansi)->first();
        $suppliers = Supplier::where('jenis_supplier', 'ATK')->get();
        $atks = Atk::where('instansi_id', $data_instansi->id)->get();
        $data = PembelianAtk::find($id);
        return view('pembelian_atk.edit', compact('data_instansi', 'suppliers', 'atks', 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PembelianAtk  $pembelianAtk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $instansi, $id)
    {
        // validation
        $validator = Validator::make($req->all(), [
            'supplier_id' => 'required',
            'atk_id' => 'required',
            'tgl_beliatk' => 'required|date',
            'satuan' => 'required',
            'jumlah_atk' => 'required|numeric',
            'hargasatuan_atk' => 'required|numeric',
            'jumlahbayar_atk' => 'required|numeric',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);

        // save data
        $data = $req->except(['_method', '_token']);
        $check = PembelianAtk::find($id)->update($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        return redirect()->route('pembelian-atk.index', ['instansi' => $instansi])->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PembelianAtk  $pembelianAtk
     * @return \Illuminate\Http\Response
     */
    public function destroy($instansi, $id)
    {
        $data = PembelianAtk::find($id);
        if(!$data) return response()->json(['msg' => 'Data tidak ditemukan'], 404);
        $check = $data->delete();
        if(!$check) return response()->json(['msg' => 'Gagal menghapus data'], 400);
        return response()->json(['msg' => 'Data berhasil dihapus']);
    }
}
