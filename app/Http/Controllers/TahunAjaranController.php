<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TahunAjaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $tahun_ajaran = TahunAjaran::orderByDesc('id')->get();
        return view('master.tahun_ajaran.index', compact('tahun_ajaran', 'data_instansi'));
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
            'thn_ajaran' => 'required|min:9|max:9',
            'status' => 'required'
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        $isDuplicate = TahunAjaran::where('thn_ajaran', $req->thn_ajaran)->first();
        if($isDuplicate) return redirect()->back()->withInput()->with('fail', 'Tahun ajaran sudah ada');

        // deactivate all data
        if($req->status == 'AKTIF'){
            $tahun_ajaran = TahunAjaran::all();
            foreach ($tahun_ajaran as $item) {
                $item->status = 'TIDAK AKTIF';
                $item->update();
            }
        }

        // save data
        $data = $req->except(['_method', '_token']);
        $check = TahunAjaran::create($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TahunAjaran  $tahunAjaran
     * @return \Illuminate\Http\Response
     */
    public function show(TahunAjaran $tahunAjaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TahunAjaran  $tahunAjaran
     * @return \Illuminate\Http\Response
     */
    public function edit(TahunAjaran $tahunAjaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TahunAjaran  $tahunAjaran
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $instansi, $id)
    {
        // validation
        $validator = Validator::make($req->all(), [
            'thn_ajaran' => 'required|min:9|max:9',
            'status' => 'required'
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        $isDuplicate = TahunAjaran::where('thn_ajaran', $req->thn_ajaran)->where('id', '!=', $id)->first();
        if($isDuplicate) return redirect()->back()->withInput()->with('fail', 'Tahun ajaran sudah ada');

        // deactivate all data
        if($req->status == 'AKTIF'){
            $tahun_ajaran = TahunAjaran::all();
            foreach ($tahun_ajaran as $item) {
                $item->status = 'TIDAK AKTIF';
                $item->update();
            }
        }

        // save data
        $data = $req->except(['_method', '_token']);
        $check = TahunAjaran::find($id)->update($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal diupdate');
        return redirect()->back()->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TahunAjaran  $tahunAjaran
     * @return \Illuminate\Http\Response
     */
    public function destroy($instansi, $id)
    {
        $data = TahunAjaran::find($id);
        $isActive = $data->status == 'AKTIF' ? true : false;
        if(!$data) return response()->json(['msg' => 'Data tidak ditemukan'], 404);
        $check = $data->delete();
        if(!$check) return response()->json(['msg' => 'Gagal menghapus data'], 400);
        if($isActive){
            $latest = TahunAjaran::latest()->first();
            $latest->status = 'AKTIF';
            $latest->update();
        }
        return response()->json(['msg' => 'Data berhasil dihapus']);
    }
}
