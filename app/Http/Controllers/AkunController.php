<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\Instansi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AkunController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req, $instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $tipe = Akun::distinct()->pluck('tipe');
        $jenis = Akun::distinct()->pluck('jenis');
        $kelompok = Akun::distinct()->pluck('kelompok');
        $query = Akun::where('instansi_id', $data_instansi->id);
        if ($req->tipe) {
            $query->where('tipe', $req->input('tipe'));
        }
        if ($req->jenis) {
            $query->where('jenis', $req->input('jenis'));
        }
        if ($req->kelompok) {
            $query->where('kelompok', $req->input('kelompok'));
        }
        $akun = $query->get();
        return view('master.akun.index', compact('akun', 'data_instansi', 'tipe', 'jenis', 'kelompok'));
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
            'kode' => 'required',
            'nama' => 'required',
            'tipe' => 'required',
            'jenis' => 'required',
            'kelompok' => 'required',
            'saldo_awal' => 'required|numeric'
        ]);
        $error = $validator->errors()->all();
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        $checkKode = Akun::where('instansi_id', $data_instansi->id)->where('kode', $req->kode)->first();
        if($checkKode) return redirect()->back()->withInput()->with('fail', 'Kode sudah digunakan');

        // save data
        $data = $req->except(['_method', '_token']);
        
        $data['instansi_id'] = $data_instansi->id;
        dd('s');
        $check = Akun::create($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Akun  $akun
     * @return \Illuminate\Http\Response
     */
    public function show(Akun $akun)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Akun  $akun
     * @return \Illuminate\Http\Response
     */
    public function edit(Akun $akun)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Akun  $akun
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $instansi, $akun)
    {
        // validation
        $validator = Validator::make($req->all(), [
            'kode' => 'required',
            'nama' => 'required',
            'tipe' => 'required',
            'jenis' => 'required',
            'kelompok' => 'required',
            'saldo_awal' => 'required|numeric'
        ]);
        $error = $validator->errors()->all();
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        $checkKode = Akun::where('instansi_id', $data_instansi->id)->where('kode', $req->kode)->where('id', '!=', $akun)->first();
        if($checkKode) return redirect()->back()->withInput()->with('fail', 'Kode sudah digunakan');

        // save data
        $data = $req->except(['_method', '_token']);
        $check = Akun::find($akun)->update($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Akun  $akun
     * @return \Illuminate\Http\Response
     */
    public function destroy($instansi,$akun)
    {
        $data = Akun::find($akun);
        if(!$data) return response()->json(['msg' => 'Data tidak ditemukan'], 404);
        $check = $data->delete();
        if(!$check) return response()->json(['msg' => 'Gagal menghapus data'], 400);
        return response()->json(['msg' => 'Data berhasil dihapus']);
    }
}
