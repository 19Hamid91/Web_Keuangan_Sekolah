<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kelas = Kelas::all();
        $sekolah = Sekolah::all();
        return view('master.kelas.index', compact(['kelas', 'sekolah']));
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
            'kode' => 'required',
            'kode_sekolah' => 'required',
            'nama_kelas' => 'required',
            'grup_kelas' => 'required',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        $checkKode = Kelas::where('kode', $req->kode)->first();
        if($checkKode) return redirect()->back()->withInput()->with('fail', 'Kode sudah digunakan');

        // save data
        $data = $req->except(['_method', '_token']);
        $check = Kelas::create($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        return redirect()->back()->withInput()->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function show(Kelas $kelas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function edit(Kelas $kelas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $kelas)
    {
        // validation
        $validator = Validator::make($req->all(), [
            'kode' => 'required',
            'kode_sekolah' => 'required',
            'nama_kelas' => 'required',
            'grup_kelas' => 'required',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        $checkKode = Kelas::where('kode', $req->kode)->where('id', '!=', $kelas)->first();
        if($checkKode) return redirect()->back()->withInput()->with('fail', 'Kode sudah digunakan');

        // save data
        $data = $req->except(['_method', '_token']);
        $check = Kelas::find($kelas)->update($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        return redirect()->back()->withInput()->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function destroy($kelas)
    {
        $data = Kelas::find($kelas);
        if(!$data) return response()->json(['msg' => 'Data tidak ditemukan'], 404);
        $check = $data->delete();
        if(!$check) return response()->json(['msg' => 'Gagal menghapus data'], 400);
        return response()->json(['msg' => 'Data berhasil dihapus']);
    }

    public function datakelas($kode_sekolah)
    {
        $kelas = Kelas::where('kode_sekolah', $kode_sekolah)->get();
        if(!$kelas) return response()->json('Error', 400);
        return response()->json($kelas);
    }
}
