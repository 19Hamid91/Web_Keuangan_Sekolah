<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $jabatans = Jabatan::orderByDesc('id')->where('instansi_id', $data_instansi->id)->get();
        return view('master.jabatan.index', compact('jabatans', 'data_instansi'));
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
            'instansi_id' => 'required',
            'jabatan' => 'required',
            'gaji_pokok' => 'required|numeric',
            'tunjangan_jabatan' => 'required|numeric',
            'tunjangan_istrisuami' => 'required|numeric',
            'tunjangan_anak' => 'required|numeric',
            'tunjangan_pendidikan' => 'required|numeric',
            'dana_pensiun' => 'required|numeric',
            'transport' => 'required|numeric',
            'bpjs_kes_sekolah' => 'required|numeric',
            'bpjs_ktk_sekolah' => 'required|numeric',
            'bpjs_kes_pribadi' => 'required|numeric',
            'bpjs_ktk_pribadi' => 'required|numeric',
        ]);
        $validator->sometimes('uang_lembur', 'required|numeric', function ($q) use($instansi) {
            return $instansi === 'tk-kb-tpa';
        });
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        $checkDuplicate = Jabatan::where('jabatan', '$req->jabatan')->where('instansi_id', $data_instansi->id)->exists();
        if($checkDuplicate) return redirect()->back()->withInput()->with('fail', 'Jabatan sudah ada');

        // save data
        $data = $req->except(['_method', '_token']);
        $check = Jabatan::create($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Jabatan  $jabatan
     * @return \Illuminate\Http\Response
     */
    public function show(Jabatan $jabatan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Jabatan  $jabatan
     * @return \Illuminate\Http\Response
     */
    public function edit(Jabatan $jabatan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Jabatan  $jabatan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $instansi, $id)
    {
        // validation
        $validator = Validator::make($req->all(), [
            'instansi_id' => 'required',
            'jabatan' => 'required',
            'gaji_pokok' => 'required|numeric',
            'tunjangan_jabatan' => 'required|numeric',
            'tunjangan_istrisuami' => 'required|numeric',
            'tunjangan_anak' => 'required|numeric',
            'tunjangan_pendidikan' => 'required|numeric',
            'dana_pensiun' => 'required|numeric',
            'transport' => 'required|numeric',
            'bpjs_kes_sekolah' => 'required|numeric',
            'bpjs_ktk_sekolah' => 'required|numeric',
            'bpjs_kes_pribadi' => 'required|numeric',
            'bpjs_ktk_pribadi' => 'required|numeric',
        ]);
        $validator->sometimes('uang_lembur', 'required|numeric', function ($q) use($instansi) {
            return $instansi === 'tk-kb-tpa';
        });
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        $checkDuplicate = Jabatan::where('jabatan', '$req->jabatan')->where('instansi_id', $data_instansi->id)->where('id', '!=', $id)->exists();
        if($checkDuplicate) return redirect()->back()->withInput()->with('fail', 'Jabatan sudah ada');

        // save data
        $data = $req->except(['_method', '_token']);
        $check = Jabatan::find($id)->update($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal diupdate');
        return redirect()->back()->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Jabatan  $jabatan
     * @return \Illuminate\Http\Response
     */
    public function destroy($instansi, $id)
    {
        $data = Jabatan::find($id);
        if(!$data) return response()->json(['msg' => 'Data tidak ditemukan'], 404);
        $check = $data->delete();
        if(!$check) return response()->json(['msg' => 'Gagal menghapus data'], 400);
        return response()->json(['msg' => 'Data berhasil dihapus']);
    }
}
