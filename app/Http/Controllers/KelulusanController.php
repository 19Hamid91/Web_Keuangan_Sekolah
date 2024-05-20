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
    public function index($sekolah)
    {
        $kelulusan = Kelulusan::all();
        return view('kelulusan.index', compact('kelulusan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($sekolah)
    {
        $kelulusan = Kelulusan::all();
        $sekolahs = Sekolah::all();
        $kelas = Kelas::all();
        $tahun_ajaran = TahunAjaran::where('status', 'AKTIF')->get();
        $siswa = Siswa::doesntHave('kelulusan')->get();
        return view('kelulusan.create', compact(['kelulusan', 'sekolahs', 'kelas', 'tahun_ajaran', 'siswa']));
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
            'tahun_ajaran_id' => 'required',
            'siswa_id' => 'required',
            'tanggal' => 'required|date',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        $isLulus = Kelulusan::where('siswa_id', $req->siswa_id)->first();
        if($isLulus) return redirect()->back()->withInput()->with('fail', 'Siswa sudah lulus');

        // save data
        $data = $req->except(['_method', '_token']);
        $check = Kelulusan::create($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        return redirect()->route('kelulusan.index', ['sekolah' => $sekolah])->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kelulusan  $kelulusan
     * @return \Illuminate\Http\Response
     */
    public function show($sekolah, $id)
    {
        $sekolahs = Sekolah::all();
        $kelas = Kelas::all();
        $tahun_ajaran = TahunAjaran::where('status', 'AKTIF')->get();
        $siswa = Siswa::all();
        $data = Kelulusan::find($id);
        return view('kelulusan.show', compact(['data', 'sekolahs', 'kelas', 'tahun_ajaran', 'siswa']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kelulusan  $kelulusan
     * @return \Illuminate\Http\Response
     */
    public function edit($sekolah, $id)
    {
        $sekolahs = Sekolah::all();
        $kelas = Kelas::all();
        $tahun_ajaran = TahunAjaran::where('status', 'AKTIF')->get();
        $siswa = Siswa::all();
        $data = Kelulusan::find($id);
        return view('kelulusan.edit', compact(['data', 'sekolahs', 'kelas', 'tahun_ajaran', 'siswa']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kelulusan  $kelulusan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $sekolah, $id)
    {
        // validation
        $validator = Validator::make($req->all(), [
            'sekolah_id' => 'required',
            'kelas_id' => 'required',
            'tahun_ajaran_id' => 'required',
            'siswa_id' => 'required',
            'tanggal' => 'required|date',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);

        // save data
        $data = $req->except(['_method', '_token']);
        $check = Kelulusan::find($id)->update($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal diupdate');
        return redirect()->route('kelulusan.index', ['sekolah' => $sekolah])->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kelulusan  $kelulusan
     * @return \Illuminate\Http\Response
     */
    public function destroy($sekolah, $id)
    {
        $data = Kelulusan::find($id);
        if(!$data) return response()->json(['msg' => 'Data tidak ditemukan'], 404);
        $check = $data->delete();
        if(!$check) return response()->json(['msg' => 'Gagal menghapus data'], 400);
        return response()->json(['msg' => 'Data berhasil dihapus']);
    }
}
