<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Kelulusan;
use App\Models\Sekolah;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KelulusanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kelulusan = Kelulusan::all();
        return view('kelulusan.index', compact('kelulusan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kelulusan = Kelulusan::all();
        $sekolah = Sekolah::all();
        $kelas = Kelas::all();
        $tahun_ajaran = TahunAjaran::where('status', 'AKTIF')->get();
        $siswa = Siswa::all();
        return view('kelulusan.create', compact(['kelulusan', 'sekolah', 'kelas', 'tahun_ajaran', 'siswa']));
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
            'kode_tahun_ajaran' => 'required',
            'tanggal' => 'required|date',
            'nis_siswa' => 'required',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);

        // save data
        $data = $req->except(['_method', '_token']);
        $tanggal = Carbon::createFromFormat('Y-m-d', $data['tanggal'])->format('Ymd');
        $data['kode'] = 'KEL' . $tanggal . $data['nis_siswa'];
        $check = Kelulusan::create($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        return redirect()->route('kelulusan.index')->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kelulusan  $kelulusan
     * @return \Illuminate\Http\Response
     */
    public function show($kelulusan)
    {
        $sekolah = Sekolah::all();
        $kelas = Kelas::all();
        $tahun_ajaran = TahunAjaran::where('status', 'AKTIF')->get();
        $siswa = Siswa::all();
        $data = Kelulusan::find($kelulusan);
        return view('kelulusan.show', compact(['data', 'sekolah', 'kelas', 'tahun_ajaran', 'siswa']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kelulusan  $kelulusan
     * @return \Illuminate\Http\Response
     */
    public function edit($kelulusan)
    {
        $sekolah = Sekolah::all();
        $kelas = Kelas::all();
        $tahun_ajaran = TahunAjaran::where('status', 'AKTIF')->get();
        $siswa = Siswa::all();
        $data = Kelulusan::find($kelulusan);
        return view('kelulusan.edit', compact(['data', 'sekolah', 'kelas', 'tahun_ajaran', 'siswa']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kelulusan  $kelulusan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $kelulusan)
    {
        // validation
        $validator = Validator::make($req->all(), [
            'kode' => 'required',
            'kode_sekolah' => 'required',
            'kode_kelas' => 'required',
            'kode_tahun_ajaran' => 'required',
            'tanggal' => 'required|date',
            'nis_siswa' => 'required',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);

        // save data
        $data = $req->except(['_method', '_token']);
        $check = Kelulusan::find($kelulusan)->update($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal diupdate');
        return redirect()->route('kelulusan.index')->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kelulusan  $kelulusan
     * @return \Illuminate\Http\Response
     */
    public function destroy($kelulusan)
    {
        $data = Kelulusan::find($kelulusan);
        if(!$data) return response()->json(['msg' => 'Data tidak ditemukan'], 404);
        $check = $data->delete();
        if(!$check) return response()->json(['msg' => 'Gagal menghapus data'], 400);
        return response()->json(['msg' => 'Data berhasil dihapus']);
    }
}
