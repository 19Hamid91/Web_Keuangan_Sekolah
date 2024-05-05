<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Inventory;
use App\Models\LogInventory;
use App\Models\Sekolah;
use App\Models\Yayasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LogInventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $logs = LogInventory::all();
        return view('log_inventory.index', compact('logs'));
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $query = Inventory::query();
        if (Auth::user()->role == 'SUPERADMIN') {
            $barang = $query->with('barang')->get()->unique('barang.kode');
        } else {
            $barang = $query->where('kode_lokasi', Auth::user()->pegawai->kode_lokasi)->with('barang')->get()->unique('barang.kode');
        }
        $sekolah = Sekolah::all();
        $yayasan = Yayasan::all();
        return view('log_inventory.create', compact('barang', 'sekolah', 'yayasan'));
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
            'kode_barang' => 'required',
            'jenis_lokasi' => 'required',
            'jumlah' => 'required',
            'peminjam' => 'required',
            'kondisi' => 'required',
            'alasan' => 'required',
            'tanggal_pinjam' => 'required|date',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);

        $exist = Inventory::where('kode_barang', $req->kode_barang)->where('jenis_lokasi', $req->jenis_lokasi)->where('kode_lokasi', $req->kode_lokasi_sekolah ?? $req->kode_lokasi_yayasan)->where('kondisi', $req->kondisi)->first();
        if(empty($exist)) return redirect()->back()->withInput()->with('fail', 'Barang tidak ada');

        if($req->jumlah > $exist->jumlah) return redirect()->back()->withInput()->with('fail', 'Jumlah tidak mencukupi');

        // save data
        $data = $req->except(['_method', '_token']);
        $data['kode_lokasi'] = $req->kode_lokasi_sekolah ?? $req->kode_lokasi_yayasan;
        $check = LogInventory::create($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        return redirect()->route('inven.index', ['jenis' => $data['jenis_lokasi']])->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LogInventory  $logInventory
     * @return \Illuminate\Http\Response
     */
    public function show($logInventory)
    {
        $data = LogInventory::find($logInventory);
        $query = Inventory::query();
        if (Auth::user()->role == 'SUPERADMIN') {
            $barang = $query->with('barang')->get()->unique('barang.kode');
        } else {
            $barang = $query->where('kode_lokasi', Auth::user()->pegawai->kode_lokasi)->with('barang')->get()->unique('barang.kode');
        }
        $sekolah = Sekolah::all();
        $yayasan = Yayasan::all();
        return view('log_inventory.show', compact('barang', 'sekolah', 'yayasan', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LogInventory  $logInventory
     * @return \Illuminate\Http\Response
     */
    public function edit($logInventory)
    {
        $data = LogInventory::find($logInventory);
        $query = Inventory::query();
        if (Auth::user()->role == 'SUPERADMIN') {
            $barang = $query->with('barang')->get()->unique('barang.kode');
        } else {
            $barang = $query->where('kode_lokasi', Auth::user()->pegawai->kode_lokasi)->with('barang')->get()->unique('barang.kode');
        }
        $sekolah = Sekolah::all();
        $yayasan = Yayasan::all();
        return view('log_inventory.edit', compact('barang', 'sekolah', 'yayasan', 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LogInventory  $logInventory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $logInventory)
    {
        // validation
        $validator = Validator::make($req->all(), [
            'kode_barang' => 'required',
            'jenis_lokasi' => 'required',
            'jumlah' => 'required',
            'peminjam' => 'required',
            'kondisi' => 'required',
            'alasan' => 'required',
            'tanggal_pinjam' => 'required|date',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);

        $exist = Inventory::where('kode_barang', $req->kode_barang)->where('jenis_lokasi', $req->jenis_lokasi)->where('kode_lokasi', $req->kode_lokasi_sekolah ?? $req->kode_lokasi_yayasan)->where('kondisi', $req->kondisi)->first();
        if(empty($exist)) return redirect()->back()->withInput()->with('fail', 'Barang tidak ada');

        $log = LogInventory::find($logInventory);
        $exist->jumlah += $log->jumlah;
        $exist->update();

        if($req->jumlah > $exist->jumlah) return redirect()->back()->withInput()->with('fail', 'Jumlah tidak mencukupi');

        // save data
        $data = $req->except(['_method', '_token']);
        $data['kode_lokasi'] = $req->kode_lokasi_sekolah ?? $req->kode_lokasi_yayasan;
        $check = $log->update($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        return redirect()->route('inven.index', ['jenis' => $data['jenis_lokasi']])->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LogInventory  $logInventory
     * @return \Illuminate\Http\Response
     */
    public function destroy($logInventory)
    {
        $data = LogInventory::find($logInventory);
        if(!$data) return response()->json(['msg' => 'Data tidak ditemukan'], 404);

        $updateInventory = Inventory::where('kode_barang', $data->kode_barang)->where('jenis_lokasi', $data->jenis_lokasi)->where('kode_lokasi', $data->kode_lokasi)->where('kondisi', $data->kondisi)->first();
        $updateInventory->jumlah += $data->jumlah;
        $updateInventory->update();
        
        $check = $data->delete();
        if(!$check) return response()->json(['msg' => 'Gagal menghapus data'], 400);
        return response()->json(['msg' => 'Data berhasil dihapus']);
    }
}
