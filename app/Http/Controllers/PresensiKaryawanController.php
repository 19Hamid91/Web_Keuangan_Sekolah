<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use App\Models\Pegawai;
use App\Models\PresensiKaryawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PresensiKaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $data = PresensiKaryawan::orderByDesc('id')->whereHas('pegawai', function($q) use($data_instansi){
            $q->where('instansi_id', $data_instansi->id);
        })->get();
        return view('presensi_pegawai.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $karyawans = Pegawai::where('instansi_id', $data_instansi->id)->get();
        return view('presensi_pegawai.create', compact('karyawans'));
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
            'karyawan_id' => 'required|exists:t_gurukaryawan,id',
            'tahun' => 'required',
            'bulan' => 'required',
            'hadir' => 'required',
            'sakit' => 'required',
            'izin' => 'required',
            'alpha' => 'required',
            'lembur' => 'required',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        $isRecorded = PresensiKaryawan::where('karyawan_id', $req->karyawan_id)->where('tahun', $req->tahun)->where('bulan', $req->bulan)->first();
        if ($isRecorded) return redirect()->back()->withInput()->with('fail', 'Data sudah ada');

        // save data
        $data = $req->except(['_method', '_token']);
        $check = PresensiKaryawan::create($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');

        return redirect()->route('presensi.index', ['instansi' => $instansi])->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PresensiKaryawan  $presensiKaryawan
     * @return \Illuminate\Http\Response
     */
    public function show($instansi, $id)
    {
        $data = PresensiKaryawan::find($id);
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $karyawans = Pegawai::where('instansi_id', $data_instansi->id)->get();
        return view('presensi_pegawai.show', compact('karyawans', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PresensiKaryawan  $presensiKaryawan
     * @return \Illuminate\Http\Response
     */
    public function edit($instansi, $id)
    {
        $data = PresensiKaryawan::find($id);
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $karyawans = Pegawai::where('instansi_id', $data_instansi->id)->get();
        return view('presensi_pegawai.edit', compact('karyawans', 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PresensiKaryawan  $presensiKaryawan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $instansi, $id)
    {
        // validation
        $validator = Validator::make($req->all(), [
            'karyawan_id' => 'required|exists:t_gurukaryawan,id',
            'tahun' => 'required',
            'bulan' => 'required',
            'hadir' => 'required',
            'sakit' => 'required',
            'izin' => 'required',
            'alpha' => 'required',
            'lembur' => 'required',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        $isRecorded = PresensiKaryawan::where('karyawan_id', $req->karyawan_id)->where('tahun', $req->tahun)->where('bulan', $req->bulan)->where('id', '!=', $id)->first();
        if ($isRecorded) return redirect()->back()->withInput()->with('fail', 'Data sudah ada');

        // save data
        $data = $req->except(['_method', '_token']);
        $check = PresensiKaryawan::find($id)->update($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal diupdate');

        return redirect()->route('presensi.index', ['instansi' => $instansi])->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PresensiKaryawan  $presensiKaryawan
     * @return \Illuminate\Http\Response
     */
    public function destroy($instansi, $id)
    {
        $data = PresensiKaryawan::find($id);
        if(!$data) return response()->json(['msg' => 'Data tidak ditemukan'], 404);
        $check = $data->delete();
        if(!$check) return response()->json(['msg' => 'Gagal menghapus data'], 400);
        return response()->json(['msg' => 'Data berhasil dihapus']);
    }
}
