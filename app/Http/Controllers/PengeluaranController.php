<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use App\Models\Sekolah;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->pegawai){
            $pengeluaran = Pengeluaran::where('kode_sekolah', Auth::user()->pegawai->kode_sekolah)->get();
        } else {
            $pengeluaran = Pengeluaran::all();
        }
        return view('pengeluaran.index', compact('pengeluaran'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $latestPengeluaran = Pengeluaran::withTrashed()->orderByDesc('id')->get();
        if(count($latestPengeluaran) < 1){
            $getKode = 'KLR' . date('YmdHis') . '00001';
        } else {
            $lastPengeluaran = $latestPengeluaran->first();
            $kode = substr($lastPengeluaran->kode, -5);
            $getKode = 'KLR' . date('YmdHis') . str_pad((int)$kode + 1, 5, '0', STR_PAD_LEFT);
        }
        $transaksi = Transaksi::where('jenis_transaksi', 'PENGELUARAN')->get();
        if(Auth::user()->pegawai){
            $sekolah = Sekolah::where('kode', Auth::user()->pegawai->kode_sekolah)->get();
        } else {
            $sekolah = Sekolah::all();
        }
        return view('pengeluaran.create', compact('transaksi', 'getKode', 'sekolah'));
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
            'kode' => 'required',
            'kode_transaksi' => 'required',
            'kode_sekolah' => 'required',
            'nominal' => 'required',
            'tanggal' => 'required',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        $checkKode = Pengeluaran::where('kode', $req->kode)->first();
        if($checkKode) return redirect()->back()->withInput()->with('fail', 'Kode sudah digunakan');
        $data = $req->except(['_method', '_token']);
        
        // store file
        if ($req->hasFile('bukti')) {
            $file = $req->file('bukti');
            $fileName = $req->kode . date('YmdHis') . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('bukti_pengeluaran', $fileName, 'public');
            $data['bukti'] = $filePath;
        } else {
            return redirect()->back()->withInput()->with('fail', 'Bukti tidak ada');
        }
        
        // save data
        $check = Pengeluaran::create($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        return redirect()->route('pengeluaran.index')->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pengeluaran  $pengeluaran
     * @return \Illuminate\Http\Response
     */
    public function show($pengeluaran)
    {
        $data = Pengeluaran::find($pengeluaran);
        $transaksi = Transaksi::where('jenis_transaksi', 'PENGELUARAN')->get();
        if(Auth::user()->pegawai){
            $sekolah = Sekolah::where('kode', Auth::user()->pegawai->kode_sekolah)->get();
        } else {
            $sekolah = Sekolah::all();
        }
        return view('pengeluaran.show', compact('data', 'transaksi', 'sekolah'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pengeluaran  $pengeluaran
     * @return \Illuminate\Http\Response
     */
    public function edit($pengeluaran)
    {
        $data = Pengeluaran::find($pengeluaran);
        $transaksi = Transaksi::where('jenis_transaksi', 'PENGELUARAN')->get();
        if(Auth::user()->pegawai){
            $sekolah = Sekolah::where('kode', Auth::user()->pegawai->kode_sekolah)->get();
        } else {
            $sekolah = Sekolah::all();
        }
        return view('pengeluaran.edit', compact('data', 'transaksi', 'sekolah'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pengeluaran  $pengeluaran
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $pengeluaran)
    {
        // validation
        $validator = Validator::make($req->all(), [
            'kode' => 'required',
            'kode_transaksi' => 'required',
            'kode_sekolah' => 'required',
            'nominal' => 'required',
            'tanggal' => 'required',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        $checkKode = Pengeluaran::where('kode', $req->kode)->where('id', '!=', $pengeluaran)->first();
        if($checkKode) return redirect()->back()->withInput()->with('fail', 'Kode sudah digunakan');
        $data = $req->except(['_method', '_token']);
        
        // store file
        if ($req->hasFile('bukti')) {
            $file = $req->file('bukti');
            $fileName = $req->kode . date('YmdHis') . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('bukti_pengeluaran', $fileName, 'public');
            $data['bukti'] = $filePath;
        }
        
        // save data
        $check = Pengeluaran::find($pengeluaran)->update($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        return redirect()->route('pengeluaran.index')->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pengeluaran  $pengeluaran
     * @return \Illuminate\Http\Response
     */
    public function destroy($pengeluaran)
    {
        $data = Pengeluaran::find($pengeluaran);
        if(!$data) return response()->json(['msg' => 'Data tidak ditemukan'], 404);
        $check = $data->delete();
        if(!$check) return response()->json(['msg' => 'Gagal menghapus data'], 400);
        return response()->json(['msg' => 'Data berhasil dihapus']);
    }
}
