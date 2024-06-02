<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\Instansi;
use App\Models\KartuPenyusutan;
use App\Models\PembelianAset;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PembelianAsetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $data = PembelianAset::whereHas('aset', function($q) use($data_instansi){
            $q->where('instansi_id', $data_instansi->id);
        })->get();
        return view('pembelian_aset.index', compact('data_instansi', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($instansi)
    {
        $data_instansi = instansi::where('nama_instansi', $instansi)->first();
        $suppliers = Supplier::all();
        $asets = Aset::where('instansi_id', $data_instansi->id)->get();
        return view('pembelian_aset.create', compact('data_instansi', 'suppliers', 'asets'));
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
            'aset_id' => 'required',
            'tgl_beliaset' => 'required|date',
            'satuan' => 'required',
            'jumlah_aset' => 'required|numeric',
            'hargasatuan_aset' => 'required|numeric',
            'jumlahbayar_aset' => 'required|numeric',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);

        // save data
        $data = $req->except(['_method', '_token']);
        $check = PembelianAset::create($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        $aset = Aset::find($data['aset_id']);
        for ($i=0; $i < $data['jumlah_aset']; $i++) { 
            $check2 = KartuPenyusutan::create([
                'aset_id' => $data['aset_id'],
                'pembelian_aset_id' =>$check->id,
                'nama_barang' => $aset->nama_aset,
                'tanggal_operasi' => now(),
                'masa_penggunaan' => 0,
                'residu' => 0,
                'metode' => 'Tegak Lurus',
            ]);
        }
        return redirect()->route('pembelian-aset.index', ['instansi' => $instansi])->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PembelianAset  $pembelianAset
     * @return \Illuminate\Http\Response
     */
    public function show($instansi, $id)
    {
        $data_instansi = instansi::where('nama_instansi', $instansi)->first();
        $suppliers = Supplier::all();
        $asets = Aset::where('instansi_id', $data_instansi->id)->get();
        $data = PembelianAset::find($id);
        return view('pembelian_aset.show', compact('data_instansi', 'suppliers', 'asets', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PembelianAset  $pembelianAset
     * @return \Illuminate\Http\Response
     */
    public function edit($instansi, $id)
    {
        $data_instansi = instansi::where('nama_instansi', $instansi)->first();
        $suppliers = Supplier::all();
        $asets = Aset::where('instansi_id', $data_instansi->id)->get();
        $data = PembelianAset::find($id);
        return view('pembelian_aset.edit', compact('data_instansi', 'suppliers', 'asets', 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PembelianAset  $pembelianAset
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $instansi, $id)
    {
        // validation
        $validator = Validator::make($req->all(), [
            'supplier_id' => 'required',
            'aset_id' => 'required',
            'tgl_beliaset' => 'required|date',
            'satuan' => 'required',
            'jumlah_aset' => 'required|numeric',
            'hargasatuan_aset' => 'required|numeric',
            'jumlahbayar_aset' => 'required|numeric',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);

        // save data
        $data = $req->except(['_method', '_token']);
        $check = PembelianAset::find($id)->update($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        return redirect()->route('pembelian-aset.index', ['instansi' => $instansi])->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PembelianAset  $pembelianAset
     * @return \Illuminate\Http\Response
     */
    public function destroy($instansi, $id)
    {
        $data = PembelianAset::find($id);
        if(!$data) return response()->json(['msg' => 'Data tidak ditemukan'], 404);
        $check = $data->delete();
        if(!$check) return response()->json(['msg' => 'Gagal menghapus data'], 400);
        return response()->json(['msg' => 'Data berhasil dihapus']);
    }
}
