<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Sekolah;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $siswa = Siswa::with(['sekolah', 'kelas'])->get();
        return view('siswa.index', compact('siswa'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sekolah = Sekolah::all();
        return view('siswa.create', compact('sekolah'));
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
            'kode_kelas' => 'required',
            'nama_siswa' => 'required',
            'nis' => 'required',
            'no_hp_siswa' => 'required',
            'alamat' => 'required',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'nama_wali' => 'required',
            'pekerjaan_wali' => 'required',
            'no_hp_wali' => 'required',
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
        return redirect()->route('siswa.index')->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function show($siswa)
    {
        $siswa = Siswa::find($siswa);
        $sekolah = Sekolah::all();
        return view('siswa.show', compact(['siswa', 'sekolah']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function edit($siswa)
    {
        $siswa = Siswa::find($siswa);
        $sekolah = Sekolah::all();
        return view('siswa.edit', compact(['siswa', 'sekolah']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $siswa)
    {
        // validation
        $validator = Validator::make($req->all(), [
            'kode_sekolah' => 'required',
            'kode_kelas' => 'required',
            'nama_siswa' => 'required',
            'nis' => 'required',
            'no_hp_siswa' => 'required',
            'alamat' => 'required',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'nama_wali' => 'required',
            'pekerjaan_wali' => 'required',
            'no_hp_wali' => 'required',
            'status' => 'required',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        $checkNIS = Siswa::where('nis', $req->nis)->where('id', '!=', $siswa)->first();
        if($checkNIS) return redirect()->back()->withInput()->with('fail', 'NIS sudah digunakan');

        // save data
        $data = $req->except(['_method', '_token']);
        $check = Siswa::find($siswa)->update($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal diupdate');
        return redirect()->route('siswa.index')->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function destroy($siswa)
    {
        $data = Siswa::find($siswa);
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
