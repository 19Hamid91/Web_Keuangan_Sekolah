<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use App\Models\Kelas;
use App\Models\TagihanSiswa;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TagihanSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $tagihan_siswa = TagihanSiswa::where('instansi_id', $data_instansi->id)->get();
        return view('tagihan_siswa.index', compact('tagihan_siswa'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $tahun_ajaran = TahunAjaran::where('status', 'AKTIF')->first();
        $kelas = Kelas::where('instansi_id', $data_instansi->id)->get();
        return view('tagihan_siswa.create', compact('data_instansi', 'tahun_ajaran', 'kelas'));
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
            'instansi_id' => 'required|exists:t_instansi,id',
            'tahun_ajaran_id' => 'required|exists:t_thnajaran,id',
            'kelas_id' => 'required|exists:t_kelas,id',
            'jenis_tagihan' => 'required',
            'mulai_bayar' => 'required|date',
            'akhir_bayar' => 'required|date',
            'jumlah_pembayaran' => 'required|numeric',
            'nominal' => 'required|numeric',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        $isDuplicate = TagihanSiswa::where('instansi_id', $req->instansi_id)->where('tahun_ajaran_id', $req->tahun_ajaran_id)->where('kelas_id', $req->kelas_id)->where('jenis_tagihan', $req->jenis_tagihan)->first();
        if($isDuplicate) return redirect()->back()->withInput()->with('fail', 'Tagihan sudah ada');

        // save data
        $data = $req->except(['_method', '_token']);
        $check = TagihanSiswa::create($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        return redirect()->route('tagihan_siswa.index', ['instansi' => $instansi])->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TagihanSiswa  $tagihanSiswa
     * @return \Illuminate\Http\Response
     */
    public function show($instansi, $id)
    {
        $data = TagihanSiswa::find($id);
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $tahun_ajaran = TahunAjaran::where('status', 'AKTIF')->first();
        $kelas = Kelas::where('instansi_id', $data_instansi->id)->get();
        return view('tagihan_siswa.show', compact('data_instansi', 'tahun_ajaran', 'kelas', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TagihanSiswa  $tagihanSiswa
     * @return \Illuminate\Http\Response
     */
    public function edit($instansi, $id)
    {
        $data = TagihanSiswa::find($id);
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $tahun_ajaran = TahunAjaran::where('status', 'AKTIF')->first();
        $kelas = Kelas::where('instansi_id', $data_instansi->id)->get();
        return view('tagihan_siswa.edit', compact('data_instansi', 'tahun_ajaran', 'kelas', 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TagihanSiswa  $tagihanSiswa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $instansi, $id)
    {
        // validation
        $validator = Validator::make($req->all(), [
            'instansi_id' => 'required|exists:t_instansi,id',
            'tahun_ajaran_id' => 'required|exists:t_thnajaran,id',
            'kelas_id' => 'required|exists:t_kelas,id',
            'jenis_tagihan' => 'required',
            'mulai_bayar' => 'required|date',
            'akhir_bayar' => 'required|date',
            'jumlah_pembayaran' => 'required|numeric',
            'nominal' => 'required|numeric',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        $isDuplicate = TagihanSiswa::where('instansi_id', $req->instansi_id)->where('tahun_ajaran_id', $req->tahun_ajaran_id)->where('kelas_id', $req->kelas_id)->where('jenis_tagihan', $req->jenis_tagihan)->where('id', '!=', $id)->first();
        if($isDuplicate) return redirect()->back()->withInput()->with('fail', 'Tagihan sudah ada');

        // save data
        $data = $req->except(['_method', '_token']);
        $check = TagihanSiswa::find($id)->update($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal diupdate');
        return redirect()->route('tagihan_siswa.index', ['instansi' => $instansi])->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TagihanSiswa  $tagihanSiswa
     * @return \Illuminate\Http\Response
     */
    public function destroy($instansi, $id)
    {
        $data = TagihanSiswa::find($id);
        if(!$data) return response()->json(['msg' => 'Data tidak ditemukan'], 404);
        $check = $data->delete();
        if(!$check) return response()->json(['msg' => 'Gagal menghapus data'], 400);
        return response()->json(['msg' => 'Data berhasil dihapus']);
    }
}
