<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\Instansi;
use App\Models\SetAkun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SetAkunController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $setakun = SetAkun::all();
        $akuns = Akun::all();
        return view('master.setakun.index', compact('setakun', 'data_instansi', 'akuns'));
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
    public function store(Request $req)
    {
        // validation
        $validator = Validator::make($req->all(), [
            'akun_id' => 'required|exists:t_akun,id',
            'grup' => 'required',
            'jenis_akun' => 'required',
            'saldo_normal' => 'required|numeric'
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);

        // save data
        $data = $req->except(['_method', '_token']);
        $check = SetAkun::create($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SetAkun  $setAkun
     * @return \Illuminate\Http\Response
     */
    public function show(SetAkun $setAkun)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SetAkun  $setAkun
     * @return \Illuminate\Http\Response
     */
    public function edit(SetAkun $setAkun)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SetAkun  $setAkun
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $instansi, $setakun)
    {
        // validation
        $validator = Validator::make($req->all(), [
            'akun_id' => 'required|exists:t_akun,id',
            'grup' => 'required',
            'jenis_akun' => 'required',
            'saldo_normal' => 'required|numeric'
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);

        // save data
        $data = $req->except(['_method', '_token']);
        $check = SetAkun::find($setakun)->update($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SetAkun  $setAkun
     * @return \Illuminate\Http\Response
     */
    public function destroy($instansi,$setakun)
    {
        $data = SetAkun::find($setakun);
        if(!$data) return response()->json(['msg' => 'Data tidak ditemukan'], 404);
        $check = $data->delete();
        if(!$check) return response()->json(['msg' => 'Gagal menghapus data'], 400);
        return response()->json(['msg' => 'Data berhasil dihapus']);
    }
}
