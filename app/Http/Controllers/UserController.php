<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $user = User::orderByDesc('id')->get();
        $pegawai = Pegawai::all();
        return view('master.user.index', compact('user', 'pegawai', 'data_instansi'));
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
    public function store($instansi, Request $req)
    {
        // validation
        $validator = Validator::make($req->all(), [
            'name' => 'required',
            'email' => 'required',
            'role' => 'required',
            'password' => 'required'
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        $checkEmail = User::where('email', $req->email)->first();
        if($checkEmail) return redirect()->back()->withInput()->with('fail', 'Email sudah digunakan');

        // save data
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $data = $req->except(['_method', '_token']);
        $data['password'] = bcrypt($data['password']);
        $data['instansi_id'] = $data['role'] == 'ADMIN' ? 0 : $data_instansi->id;
        $check = User::create($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $instansi, $id)
    {
        // validation
        $validator = Validator::make($req->all(), [
            'name' => 'required',
            'email' => 'required',
            'role' => 'required',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        $checkEmail = User::where('email', $req->email)->where('id', '!=', $id)->first();
        if($checkEmail) return redirect()->back()->withInput()->with('fail', 'Email sudah digunakan');

        // save data
        $data = $req->except(['_method', '_token']);
        $data['password'] = bcrypt($data['password']);
        $check = User::find($id)->update($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($instansi, $id)
    {
        $data = User::find($id);
        if(!$data) return response()->json(['msg' => 'Data tidak ditemukan'], 404);
        $check = $data->delete();
        if(!$check) return response()->json(['msg' => 'Gagal menghapus data'], 400);
        return response()->json(['msg' => 'Data berhasil dihapus']);
    }
}
