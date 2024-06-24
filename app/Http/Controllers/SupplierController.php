<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req, $instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $query = Supplier::orderByDesc('id')->where('instansi_id', $data_instansi->id);
        if ($req->jenis) {
            $query->where('jenis_supplier', $req->input('jenis'));
        }
        $supplier = $query->get();
        return view('master.supplier.index', compact('supplier', 'data_instansi'));
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
            'jenis_supplier' => 'required',
            'nama_supplier' => 'required',
            'alamat_supplier' => 'required',
            'notelp_supplier' => 'required|numeric|digits_between:11,13',
            'instansi_id' => 'required',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);

        // save data
        $data = $req->except(['_method', '_token']);
        $check = Supplier::create($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $instansi, $id)
    {
        // validation
        $validator = Validator::make($req->all(), [
            'jenis_supplier' => 'required',
            'nama_supplier' => 'required',
            'alamat_supplier' => 'required',
            'notelp_supplier' => 'required|numeric|digits_between:11,13',
            'instansi_id' => 'required',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        $checkTelp = Supplier::where('notelp_supplier', $req->notelp_supplier)->where('id', '!=', $id)->first();
        if ($checkTelp) return redirect()->back()->withInput()->with('fail', 'No telpon sudah dipakai');

        // save data
        $data = $req->except(['_method', '_token']);
        $check = Supplier::find($id)->update($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy($instansi, $id)
    {
        $data = Supplier::find($id);
        if(!$data) return response()->json(['msg' => 'Data tidak ditemukan'], 404);
        $check = $data->delete();
        if(!$check) return response()->json(['msg' => 'Gagal menghapus data'], 400);
        return response()->json(['msg' => 'Data berhasil dihapus']);
    }
}
