<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pegawai = Pegawai::with('sekolah')->get();
        return view('pegawai.index', compact('pegawai'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sekolah = Sekolah::all();
        return view('pegawai.create', compact('sekolah'));
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
            'kode_sekolah' => 'required',
            'nama_pegawai' => 'required',
            'nip' => 'required',
            'no_hp_pegawai' => 'required',
            'alamat' => 'required',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'jabatan' => 'required',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        $checkNIP = Pegawai::where('nip', $req->nip)->first();
        if($checkNIP) return redirect()->back()->withInput()->with('fail', 'NIP sudah digunakan');

        // save data
        $data = $req->except(['_method', '_token']);
        $data['status'] = 'AKTIF';
        $check = Pegawai::create($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        return redirect()->route('pegawai.index')->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function show($pegawai)
    {
        $pegawai = Pegawai::find($pegawai);
        $sekolah = Sekolah::all();
        return view('pegawai.show', compact(['pegawai', 'sekolah']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function edit($pegawai)
    {
        $pegawai = Pegawai::find($pegawai);
        $sekolah = Sekolah::all();
        return view('pegawai.edit', compact(['pegawai', 'sekolah']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $pegawai)
    {
        // validation
        $validator = Validator::make($req->all(), [
            'kode_sekolah' => 'required',
            'nama_pegawai' => 'required',
            'nip' => 'required',
            'no_hp_pegawai' => 'required',
            'alamat' => 'required',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'jabatan' => 'required',
            'status' => 'required',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        $checkNIP = Pegawai::where('nip', $req->nip)->where('id', '!=', $pegawai)->first();
        if($checkNIP) return redirect()->back()->withInput()->with('fail', 'NIP sudah digunakan');

        // save data
        $data = $req->except(['_method', '_token']);
        $check = Pegawai::find($pegawai)->update($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        return redirect()->route('pegawai.index')->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function destroy($pegawai)
    {
        $data = Pegawai::find($pegawai);
        if(!$data) return response()->json(['msg' => 'Data tidak ditemukan'], 404);
        $check = $data->delete();
        if(!$check) return response()->json(['msg' => 'Gagal menghapus data'], 400);
        return response()->json(['msg' => 'Data berhasil dihapus']);
    }
}
