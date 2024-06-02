<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\PembayaranSiswa;
use Illuminate\Http\Request;

class PembayaranSiswaController extends Controller
{
    public function daftar()
    {
        $dataKelas = Kelas::withCount(['siswa' => function ($query) {
            $query->doesntHave('kelulusan');
        }])->get();
        return view('pembayaran_siswa.daftar', compact('dataKelas'));
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($instansi, $kelas)
    {
        return view('pembayaran_siswa.index', compact('kelas'));
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
    public function store(Request $request)
    {
        //
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
