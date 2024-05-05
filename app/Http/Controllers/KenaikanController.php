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
    public function index()
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
        $sekolah = Sekolah::all();
        $kelas = Kelas::all();
        $tahun_ajaran = TahunAjaran::where('status', 'AKTIF')->get();
        $siswa = Siswa::all();
        return view('kenaikan.create', compact(['kenaikan', 'sekolah', 'kelas', 'tahun_ajaran', 'siswa']));
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
            'kode_kelas_awal' => 'required',
            'kode_kelas_akhir' => 'required',
            'kode_tahun_ajaran' => 'required',
            'tanggal' => 'required|date',
            'nis_siswa' => 'required',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);

        // save data
        $data = $req->except(['_method', '_token']);
        $tanggal = Carbon::createFromFormat('Y-m-d', $data['tanggal'])->format('Ymd');
        $data['kode'] = 'KEN' . $tanggal . $data['nis_siswa'];
        $check = Kenaikan::create($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        $siswa = Siswa::where('nis', $data['nis_siswa'])->first();
        $siswa->kode_kelas = $data['kode_kelas_akhir'];
        $siswa->update();
        return redirect()->route('kenaikan.index')->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kenaikan  $kenaikan
     * @return \Illuminate\Http\Response
     */
    public function show($kenaikan)
    {
        $sekolah = Sekolah::all();
        $kelas = Kelas::all();
        $tahun_ajaran = TahunAjaran::where('status', 'AKTIF')->get();
        $siswa = Siswa::all();
        $data = Kenaikan::find($kenaikan);
        return view('kenaikan.show', compact(['data', 'sekolah', 'kelas', 'tahun_ajaran', 'siswa']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kenaikan  $kenaikan
     * @return \Illuminate\Http\Response
     */
    public function edit($kenaikan)
    {
        $sekolah = Sekolah::all();
        $kelas = Kelas::all();
        $tahun_ajaran = TahunAjaran::all();
        $siswa = Siswa::all();
        $data = Kenaikan::find($kenaikan);
        return view('kenaikan.edit', compact(['data', 'sekolah', 'kelas', 'tahun_ajaran', 'siswa']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kenaikan  $kenaikan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $kenaikan)
    {
        // validation
        $validator = Validator::make($req->all(), [
            'kode' => 'required',
            'kode_sekolah' => 'required',
            'kode_kelas_awal' => 'required',
            'kode_kelas_akhir' => 'required',
            'kode_tahun_ajaran' => 'required',
            'tanggal' => 'required|date',
            'nis_siswa' => 'required',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);

        // save data
        $data = $req->except(['_method', '_token']);
        $check = Kenaikan::find($kenaikan)->update($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal diupdate');
        $siswa = Siswa::where('nis', $data['nis_siswa'])->first();
        $siswa->kode_kelas = $data['kode_kelas_akhir'];
        $siswa->update();
        return redirect()->route('kenaikan.index')->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kenaikan  $kenaikan
     * @return \Illuminate\Http\Response
     */
    public function destroy($kenaikan)
    {
        $data = Kenaikan::find($kenaikan);
        if(!$data) return response()->json(['msg' => 'Data tidak ditemukan'], 404);
        $check = $data->delete();
        if(!$check) return response()->json(['msg' => 'Gagal menghapus data'], 400);
        return response()->json(['msg' => 'Data berhasil dihapus']);
    }
}
