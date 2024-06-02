<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function jurnal_index()
    {
        return view('laporan.jurnal');
    }
    
    public function buku_besar_index()
    {
        return view('laporan.buku_besar');
    }
    
    public function laporan_index()
    {
        return view('laporan.laporan');
    }
}
