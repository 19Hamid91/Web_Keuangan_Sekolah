<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use App\Models\Jabatan;
use App\Models\Pengurus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PengurusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req, $instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $query = Pengurus::orderByDesc('id')->where('instansi_id', $data_instansi->id);
        if ($req->jabatan) {
            $query->where('jabatan', $req->input('jabatan'));
        }
        $pengurus = $query->get();
        $jabatan = Pengurus::where('instansi_id', $data_instansi->id)->distinct()->pluck('jabatan');
        return view('pengurus.index', compact('pengurus', 'jabatan', 'data_instansi'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $jabatans = Jabatan::where('instansi_id', $data_instansi->id)->get();
        return view('pengurus.create', compact('data_instansi', 'jabatans'));
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
            'instansi_id' => 'required',
            'jabatan' => 'required',
            'nama_pengurus' => 'required',
            'alamat_pengurus' => 'required',
            // 'jenis_kelamin' => 'required',
            // 'tempat_lahir' => 'required',
            // 'tanggal_lahir' => 'required|date',
            'no_hp_pengurus' => 'required|digits_between:11,13',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        $checkHP = Pengurus::where('no_hp_pengurus', $req->no_hp_pengurus)->first();
        if($checkHP) return redirect()->back()->withInput()->with('fail', 'No HP sudah digunakan');

        // save data
        $data = $req->except(['_method', '_token']);
        $data['status'] = 'AKTIF';
        $check = Pengurus::create($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        return redirect()->route('pengurus.index', ['instansi' => $instansi])->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pengurus  $pengurus
     * @return \Illuminate\Http\Response
     */
    public function show($instansi, $id)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $jabatans = Jabatan::where('instansi_id', $data_instansi->id)->get();
        $pengurus = Pengurus::find($id);
        return view('pengurus.show', compact('data_instansi', 'jabatans', 'pengurus'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pengurus  $pengurus
     * @return \Illuminate\Http\Response
     */
    public function edit($instansi, $id)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $jabatans = Jabatan::where('instansi_id', $data_instansi->id)->get();
        $pengurus = Pengurus::find($id);
        return view('pengurus.edit', compact('data_instansi', 'jabatans', 'pengurus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pengurus  $pengurus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $instansi, $id)
    {
        // validation
        $validator = Validator::make($req->all(), [
            'instansi_id' => 'required',
            'jabatan' => 'required',
            'nama_pengurus' => 'required',
            'alamat_pengurus' => 'required',
            // 'jenis_kelamin' => 'required',
            // 'tempat_lahir' => 'required',
            // 'tanggal_lahir' => 'required|date',
            'no_hp_pengurus' => 'required|digits_between:11,13',
            'status' => 'required',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        $checkHP = Pengurus::where('no_hp_pengurus', $req->no_hp_pengurus)->where('id', '!=', $id)->first();
        if($checkHP) return redirect()->back()->withInput()->with('fail', 'No HP sudah digunakan');

        // save data
        $data = $req->except(['_method', '_token']);
        $check = Pengurus::find($id)->update($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal diupdate');
        return redirect()->route('pengurus.index', ['instansi' => $instansi])->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pengurus  $pengurus
     * @return \Illuminate\Http\Response
     */
    public function destroy($instansi, $id)
    {
        $data = Pengurus::find($id);
        if(!$data) return response()->json(['msg' => 'Data tidak ditemukan'], 404);
        $check = $data->delete();
        if(!$check) return response()->json(['msg' => 'Gagal menghapus data'], 400);
        return response()->json(['msg' => 'Data berhasil dihapus']);
    }
}
