<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use App\Models\Kelas;
use App\Models\PembayaranSiswa;
use App\Models\Siswa;
use App\Models\TagihanSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PembayaranSiswaController extends Controller
{
    public function daftar($instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $dataKelas = Kelas::withCount(['siswa' => function ($query) {
            $query->doesntHave('kelulusan');
        }])->where('instansi_id', $data_instansi->id)->get();
        return view('pembayaran_siswa.daftar', compact('dataKelas'));
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($instansi, $kelas)
    {
        $data = PembayaranSiswa::whereHas('siswa', function($q) use($kelas){
            $q->where('kelas_id', $kelas);
        })->get();
        return view('pembayaran_siswa.index', compact('kelas', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($instansi, $kelas)
    {
        $tagihan_siswa = TagihanSiswa::where('kelas_id', $kelas)->get();
        $siswa = Siswa::where('kelas_id', $kelas)->get();
        return view('pembayaran_siswa.create', compact('tagihan_siswa', 'siswa', 'kelas'));
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
            'tagihan_siswa_id' => 'required|exists:t_tagihan_siswa,id',
            'siswa_id' => 'required|exists:t_siswa,id',
            'tanggal' => 'required|date',
            'total' => 'required|numeric',
            'sisa' => 'required|numeric',
            'tipe_pembayaran' => 'required',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $isPaid = PembayaranSiswa::where('tagihan_siswa_id', $req->tagihan_siswa_id)->where('siswa_id', $req->siswa_id)->first();
        if($isPaid) return redirect()->back()->withInput()->with('fail', 'Siswa Sudah membayar');

        // save data
        $data = $req->except(['_method', '_token']);
        $data['status'] = 'LUNAS';
        $check = PembayaranSiswa::create($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        return redirect()->route('pembayaran_siswa.index', ['instansi' => $instansi])->with('success', 'Data berhasil ditambahkan');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PambayaranSiswa  $pambayaranSiswa
     * @return \Illuminate\Http\Response
     */
    public function show(PembayaranSiswa $pembayaranSiswa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PambayaranSiswa  $pambayaranSiswa
     * @return \Illuminate\Http\Response
     */
    public function edit(PembayaranSiswa $pembayaranSiswa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PambayaranSiswa  $pambayaranSiswa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PembayaranSiswa $pembayaranSiswa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PambayaranSiswa  $pambayaranSiswa
     * @return \Illuminate\Http\Response
     */
    public function destroy(PembayaranSiswa $pembayaranSiswa)
    {
        //
    }
}
