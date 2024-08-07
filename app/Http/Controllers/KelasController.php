<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Instansi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req, $instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $query = Kelas::where('instansi_id', $data_instansi->id);
        if ($req->namakelas) {
            $query->where('tingkat', $req->input('namakelas'));
        }
        $kelas = $query->get();
        $namakelas = Kelas::where('instansi_id', $data_instansi->id)->distinct()->pluck('tingkat');
        return view('master.kelas.index', compact('kelas', 'data_instansi', 'namakelas'));
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
    public function store(Request $req, $instansi)
    {
        // validation
        $validator = Validator::make($req->all(), [
            'instansi_id' => 'required',
            'kelas' => 'required',
            'tingkat' => 'required',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $isDuplicate = Kelas::where('instansi_id', $data_instansi->id)->where('kelas', $req->kelas)->where('tingkat', $req->tingkat)->first();
        if($isDuplicate) return redirect()->back()->withInput()->with('fail', 'Kelas sudah ada');

        // save data
        $data = $req->except(['_method', '_token']);
        $check = Kelas::create($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function show(Kelas $kelas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function edit(Kelas $kelas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $instansi, $id)
    {
        // validation
        $validator = Validator::make($req->all(), [
            'instansi_id' => 'required',
            'kelas' => 'required',
            'tingkat' => 'required',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $isDuplicate = Kelas::where('instansi_id', $data_instansi->id)->where('kelas', $req->kelas)->where('tingkat', $req->tingkat)->where('id', '!=', $id)->first();
        if($isDuplicate) return redirect()->back()->withInput()->with('fail', 'Kelas sudah ada');

        // save data
        $data = $req->except(['_method', '_token']);
        $check = Kelas::find($id)->update($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function destroy($instansi, $id)
    {
        $data = Kelas::find($id);
        if(!$data) return response()->json(['msg' => 'Data tidak ditemukan'], 404);
        $check = $data->delete();
        if(!$check) return response()->json(['msg' => 'Gagal menghapus data'], 400);
        return response()->json(['msg' => 'Data berhasil dihapus']);
    }

    public function datakelas($instansi_id)
    {
        $kelas = Kelas::where('instansi_id', $instansi_id)->get();
        if(!$kelas) return response()->json('Error', 400);
        return response()->json($kelas);
    }
}
