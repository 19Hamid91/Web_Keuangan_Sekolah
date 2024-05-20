<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Sekolah;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($sekolah)
    {
        $sekolah_id = Sekolah::where('nama', $sekolah)->first();
        $siswa = Siswa::with('sekolah', 'kelas')->where('sekolah_id', $sekolah_id->id)->get();
        return view('siswa.index', compact('siswa'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($sekolah)
    {
        $data_sekolah = Sekolah::where('nama', $sekolah)->first();
        $data_kelas = Kelas::where('sekolah_id', $data_sekolah->id)->get();
        return view('siswa.create', compact('data_sekolah', 'data_kelas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req, $sekolah)
    {
        // validation
        $validator = Validator::make($req->all(), [
            'sekolah_id' => 'required',
            'kelas_id' => 'required',
            'nama_siswa' => 'required',
            'nis' => 'required',
            'handphone_siswa' => 'required',
            'alamat' => 'required',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'nama_wali' => 'required',
            'pekerjaan_wali' => 'required',
            'handphone_wali' => 'required',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        $checkNIS = Siswa::where('nis', $req->nis)->first();
        if($checkNIS) return redirect()->back()->withInput()->with('fail', 'NIS sudah digunakan');

        // save data
        $data = $req->except(['_method', '_token']);
        $data['status'] = 'AKTIF';
        $check = Siswa::create($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        return redirect()->route('siswa.index', ['sekolah' => $sekolah])->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function show($sekolah, $id)
    {
        $siswa = Siswa::find($id);
        $sekolahs = Sekolah::with('kelas')->where('nama', $sekolah)->first();
        return view('siswa.show', compact(['siswa', 'sekolahs']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function edit($sekolah, $id)
    {
        $siswa = Siswa::find($id);
        $sekolahs = Sekolah::with('kelas')->where('nama', $sekolah)->first();
        return view('siswa.edit', compact(['siswa', 'sekolahs']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $sekolah, $id)
    {
        // validation
        $validator = Validator::make($req->all(), [
            'sekolah_id' => 'required',
            'kelas_id' => 'required',
            'nama_siswa' => 'required',
            'nis' => 'required',
            'handphone_siswa' => 'required',
            'alamat' => 'required',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'nama_wali' => 'required',
            'pekerjaan_wali' => 'required',
            'handphone_wali' => 'required',
            'status' => 'required',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        $checkNIS = Siswa::where('nis', $req->nis)->where('id', '!=', $id)->first();
        if($checkNIS) return redirect()->back()->withInput()->with('fail', 'NIS sudah digunakan');

        // save data
        $data = $req->except(['_method', '_token']);
        $check = Siswa::find($id)->update($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal diupdate');
        return redirect()->route('siswa.index', ['sekolah' => $sekolah])->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function destroy($sekolah, $id)
    {
        $data = Siswa::find($id);
        if(!$data) return response()->json(['msg' => 'Data tidak ditemukan'], 404);
        $check = $data->delete();
        if(!$check) return response()->json(['msg' => 'Gagal menghapus data'], 400);
        return response()->json(['msg' => 'Data berhasil dihapus']);
    }

    public function datasiswa($nis_siswa)
    {
        $data = Siswa::with('sekolah', 'kelas')->where('nis', $nis_siswa)->first();
        return response()->json($data);
    }
}
