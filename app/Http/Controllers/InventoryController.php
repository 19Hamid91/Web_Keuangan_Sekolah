<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Inventory;
use App\Models\Sekolah;
use App\Models\Yayasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        // validation
        $validator = Validator::make($req->all(), [
            'jenis' => 'required',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);

        $inventories = Inventory::where('jenis_lokasi', $req->jenis)->get();
        return view('inventory.index', compact('inventories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $barang = Barang::all();
        $sekolah = Sekolah::all();
        $yayasan = Yayasan::all();
        return view('inventory.create', compact('barang', 'sekolah', 'yayasan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        // dd($req);
        // validation
        $validator = Validator::make($req->all(), [
            'kode_barang' => 'required',
            'jenis_lokasi' => 'required',
            'jumlah' => 'required',
            'lokasi_penyimpanan' => 'required',
            'kondisi' => 'required',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        $duplicate = Inventory::where('kode_barang', $req->kode_barang)->where('jenis_lokasi', $req->jenis_lokasi)->where('kode_lokasi', $req->kode_lokasi_sekolah ?? $req->kode_lokasi_yayasan)->where('kondisi', $req->kondisi)->first();
        if(!empty($duplicate)) return redirect()->back()->withInput()->with('fail', 'Barang sudah ada');

        // save data
        $data = $req->except(['_method', '_token']);
        $data['kode_lokasi'] = $req->kode_lokasi_sekolah ?? $req->kode_lokasi_yayasan;
        $check = Inventory::create($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        return redirect()->route('inven.index')->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function show($inventory)
    {
        $data = Inventory::find($inventory);
        $barang = Barang::all();
        $sekolah = Sekolah::all();
        $yayasan = Yayasan::all();
        return view('inventory.show', compact('data', 'barang', 'sekolah', 'yayasan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function edit($inventory)
    {
        $data = Inventory::find($inventory);
        $barang = Barang::all();
        $sekolah = Sekolah::all();
        $yayasan = Yayasan::all();
        return view('inventory.edit', compact('data', 'barang', 'sekolah', 'yayasan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $inventory)
    {
        // validation
        $validator = Validator::make($req->all(), [
            'kode_barang' => 'required',
            'jenis_lokasi' => 'required',
            'jumlah' => 'required',
            'lokasi_penyimpanan' => 'required',
            'kondisi' => 'required',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        $duplicate = Inventory::where('kode_barang', $req->kode_barang)->where('jenis_lokasi', $req->jenis_lokasi)->where('kode_lokasi', $req->kode_lokasi)->where('id', '!=', $inventory)->first();
        if($duplicate) return redirect()->back()->withInput()->with('fail', 'Barang sudah ada');

        // save data
        $data = $req->except(['_method', '_token']);
        $data['kode_lokasi'] = $req->kode_lokasi_sekolah ?? $req->kode_lokasi_yayasan;
        $check = Inventory::find($inventory)->update($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal diupdate');
        return redirect()->route('inven.index')->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function destroy($inventory)
    {
        $data = Inventory::find($inventory);
        if(!$data) return response()->json(['msg' => 'Data tidak ditemukan'], 404);
        $check = $data->delete();
        if(!$check) return response()->json(['msg' => 'Gagal menghapus data'], 400);
        return response()->json(['msg' => 'Data berhasil dihapus']);
    }
}
