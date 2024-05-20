<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Kenaikan;
use App\Models\Sekolah;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KenaikanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req, $sekolah)
    {
        $kenaikan = Kenaikan::all();
        return view('kenaikan.index', compact('kenaikan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kenaikan = Kenaikan::all();
        $sekolahs = Sekolah::all();
        $kelas = Kelas::all();
        $tahun_ajaran = TahunAjaran::where('status', 'AKTIF')->get();
        $siswa = Siswa::all();
        return view('kenaikan.create', compact(['kenaikan', 'sekolahs', 'kelas', 'tahun_ajaran', 'siswa']));
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
            'kelas_awal' => 'required',
            'kelas_akhir' => 'required',
            'tahun_ajaran_id' => 'required',
            'siswa_id' => 'required',
            'tanggal' => 'required|date',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        if($req->kelas_awal == $req->kelas_akhir) return redirect()->back()->withInput()->with('fail', 'Kelas tidak boleh sama');

        // save data
        $data = $req->except(['_method', '_token']);
        $check = Kenaikan::create($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        $siswa = Siswa::find($data['siswa_id']);
        $siswa->kelas_id = $data['kelas_akhir'];
        $siswa->update();
        return redirect()->route('kenaikan.index', ['sekolah' => $sekolah])->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kenaikan  $kenaikan
     * @return \Illuminate\Http\Response
     */
    public function show($sekolah, $id)
    {
        $sekolahs = Sekolah::all();
        $kelas = Kelas::all();
        $tahun_ajaran = TahunAjaran::all();
        $siswa = Siswa::with('kelas')->get();
        $data = Kenaikan::find($id);
        return view('kenaikan.show', compact(['data', 'sekolahs', 'kelas', 'tahun_ajaran', 'siswa']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kenaikan  $kenaikan
     * @return \Illuminate\Http\Response
     */
    public function edit($sekolah, $id)
    {
        $sekolahs = Sekolah::all();
        $kelas = Kelas::all();
        $tahun_ajaran = TahunAjaran::all();
        $siswa = Siswa::with('kelas')->get();
        $data = Kenaikan::find($id);
        return view('kenaikan.edit', compact(['data', 'sekolahs', 'kelas', 'tahun_ajaran', 'siswa']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kenaikan  $kenaikan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $sekolah, $id)
    {
        // validation
        $validator = Validator::make($req->all(), [
            'sekolah_id' => 'required',
            'kelas_akhir' => 'required',
            'tahun_ajaran_id' => 'required',
            'siswa_id' => 'required',
            'tanggal' => 'required|date',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        if($req->kelas_awal == $req->kelas_akhir) return redirect()->back()->withInput()->with('fail', 'Kelas tidak boleh sama');

        // save data
        $data = $req->except(['_method', '_token']);
        $check = Kenaikan::find($id)->update($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal diupdate');
        $siswa = Siswa::find($data['siswa_id']);
        $siswa->kelas_id = $data['kelas_akhir'];
        $siswa->update();
        return redirect()->route('kenaikan.index', ['sekolah' => $sekolah])->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kenaikan  $kenaikan
     * @return \Illuminate\Http\Response
     */
    public function destroy($sekolah, $id)
    {
        $data = Kenaikan::find($id);
        if(!$data) return response()->json(['msg' => 'Data tidak ditemukan'], 404);
        $check = $data->delete();
        if(!$check) return response()->json(['msg' => 'Gagal menghapus data'], 400);
        return response()->json(['msg' => 'Data berhasil dihapus']);
    }
}
