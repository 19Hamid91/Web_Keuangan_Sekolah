<?php

namespace App\Http\Controllers;

use App\Models\DaftarTagihan;
use App\Models\Siswa;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TagihanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Tagihan::query();
        if(Auth::user()->role == 'SUPERADMIN'){
            $tagihan = $query->get();
        } else {
            $tagihan = $query->whereHas('siswa', function($query) {
                $query->where('kode_sekolah', Auth::user()->pegawai->kode_sekolah);
            })->get();
        }
        return view('tagihan.index', compact('tagihan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $query = DaftarTagihan::query();
        if(Auth::user()->role == 'SUPERADMIN'){
            $daftartagihan = $query->get();
        } else {
            $daftartagihan = $query->where('kode_sekolah', Auth::user()->pegawai->kode_sekolah)->get();
        }
        $query = Siswa::query();
        if(Auth::user()->role == 'SUPERADMIN'){
            $siswa = $query->get();
        } else {
            $siswa = $query->where('kode_sekolah', Auth::user()->pegawai->kode_sekolah)->get();
        }
        $latestTagihan = Tagihan::withTrashed()->orderByDesc('id')->get();

        // kode do
        if(count($latestTagihan) < 1){
            $getKode = 'TAG' . date('YmdHis') . '00001';
        } else {
            $lastTagihan = $latestTagihan->first();
            $kode = substr($lastTagihan->kode, -5);
            $getKode = 'TAG' . date('YmdHis') . str_pad((int)$kode + 1, 5, '0', STR_PAD_LEFT);
        }
        return view('tagihan.create', compact('daftartagihan', 'siswa', 'getKode'));
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
            'kode_daftar_tagihan' => 'required',
            'nis_siswa' => 'required',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);

        // save data
        $data = $req->except(['_method', '_token']);
        $check = Tagihan::create($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        return redirect()->route('tagihan.index')->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function show($tagihan)
    {
        $query = DaftarTagihan::query();
        if(Auth::user()->role == 'SUPERADMIN'){
            $daftartagihan = $query->get();
        } else {
            $daftartagihan = $query->where('kode_sekolah', Auth::user()->pegawai->kode_sekolah)->get();
        }
        $query = Siswa::query();
        if(Auth::user()->role == 'SUPERADMIN'){
            $siswa = $query->get();
        } else {
            $siswa = $query->where('kode_sekolah', Auth::user()->pegawai->kode_sekolah)->get();
        }
        $data = Tagihan::find($tagihan);
        return view('tagihan.show', compact('daftartagihan', 'siswa', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function edit($tagihan)
    {
        $query = DaftarTagihan::query();
        if(Auth::user()->role == 'SUPERADMIN'){
            $daftartagihan = $query->get();
        } else {
            $daftartagihan = $query->where('kode_sekolah', Auth::user()->pegawai->kode_sekolah)->get();
        }
        $query = Siswa::query();
        if(Auth::user()->role == 'SUPERADMIN'){
            $siswa = $query->get();
        } else {
            $siswa = $query->where('kode_sekolah', Auth::user()->pegawai->kode_sekolah)->get();
        }
        $data = Tagihan::find($tagihan);
        return view('tagihan.edit', compact('daftartagihan', 'siswa', 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $tagihan)
    {
        // validation
        $validator = Validator::make($req->all(), [
            'kode' => 'required',
            'kode_daftar_tagihan' => 'required',
            'nis_siswa' => 'required',
            'status' => 'required',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);

        // save data
        $data = $req->except(['_method', '_token']);
        $check = Tagihan::find($tagihan)->update($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal diupdate');
        return redirect()->route('tagihan.index')->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function destroy($tagihan)
    {
        $data = Tagihan::find($tagihan);
        if(!$data) return response()->json(['msg' => 'Data tidak ditemukan'], 404);
        $check = $data->delete();
        if(!$check) return response()->json(['msg' => 'Gagal menghapus data'], 400);
        return response()->json(['msg' => 'Data berhasil dihapus']);
    }
}
