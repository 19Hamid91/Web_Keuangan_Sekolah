<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pembayaran = Pembayaran::all();
        return view('pembayaran.index', compact('pembayaran'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $latestPembayaran = Pembayaran::withTrashed()->orderByDesc('id')->get();
        if(count($latestPembayaran) < 1){
            $getKode = 'BYR' . date('YmdHis') . '00001';
        } else {
            $lastPembayaran = $latestPembayaran->first();
            $kode = substr($lastPembayaran->kode, -5);
            $getKode = 'BYR' . date('YmdHis') . str_pad((int)$kode + 1, 5, '0', STR_PAD_LEFT);
        }
        $tagihans = Tagihan::where('status', 'PENDING')->get();
        return view('pembayaran.create', compact('tagihans', 'getKode'));
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
            'kode_tagihan' => 'required',
            'nominal' => 'required',
            'tanggal' => 'required',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        $checkKode = Pembayaran::where('kode', $req->kode)->first();
        if($checkKode) return redirect()->back()->withInput()->with('fail', 'Kode sudah digunakan');
        $data = $req->except(['_method', '_token']);
        
        // store file
        if ($req->hasFile('bukti')) {
            $file = $req->file('bukti');
            $fileName = $req->kode . date('YmdHis') . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('bukti_pembayaran', $fileName, 'public');
            $data['bukti'] = $filePath;
        } else {
            return redirect()->back()->withInput()->with('fail', 'Bukti tidak ada');
        }
        
        // save data
        $check = Pembayaran::create($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        $tagihan = Tagihan::where('kode', $data['kode_tagihan'])->first();
        if($tagihan->daftar_tagihan->nominal == $data['nominal']){
            $tagihan->status = 'LUNAS';
            $tagihan->update();
        }
        return redirect()->route('pembayaran.index')->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pembayaran  $pembayaran
     * @return \Illuminate\Http\Response
     */
    public function show($pembayaran)
    {
        $data = Pembayaran::find($pembayaran);
        $tagihans = Tagihan::where('status', 'PENDING')->get();
        return view('pembayaran.show', compact('tagihans', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pembayaran  $pembayaran
     * @return \Illuminate\Http\Response
     */
    public function edit($pembayaran)
    {
        $data = Pembayaran::find($pembayaran);
        $tagihans = Tagihan::where('status', 'PENDING')->get();
        return view('pembayaran.edit', compact('tagihans', 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pembayaran  $pembayaran
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $pembayaran)
    {
        // validation
        $validator = Validator::make($req->all(), [
            'kode' => 'required',
            'kode_tagihan' => 'required',
            'nominal' => 'required',
            'tanggal' => 'required',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        $checkKode = Pembayaran::where('kode', $req->kode)->where('id', '!=', $pembayaran)->first();
        if($checkKode) return redirect()->back()->withInput()->with('fail', 'Kode sudah digunakan');
        $data = $req->except(['_method', '_token']);
        
        // store file
        if ($req->hasFile('bukti')) {
            $file = $req->file('bukti');
            $fileName = $req->kode . date('YmdHis') . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('bukti_pembayaran', $fileName, 'public');
            $data['bukti'] = $filePath;
        }
        
        // save data
        $check = Pembayaran::find($pembayaran)->update($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        return redirect()->route('pembayaran.index')->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pembayaran  $pembayaran
     * @return \Illuminate\Http\Response
     */
    public function destroy($pembayaran)
    {
        $data = Pembayaran::find($pembayaran);
        if(!$data) return response()->json(['msg' => 'Data tidak ditemukan'], 404);
        $check = $data->delete();
        if(!$check) return response()->json(['msg' => 'Gagal menghapus data'], 400);
        return response()->json(['msg' => 'Data berhasil dihapus']);
    }
}
