<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\instansi;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req, $instansi)
    {
        $instansi_id = instansi::where('nama_instansi', $instansi)->first();
        $query = Siswa::orderByDesc('id')->with('instansi', 'kelas')->where('instansi_id', $instansi_id->id);
        if ($req->kelas) {
            $query->where('kelas_id', $req->input('kelas'));
        }
        if ($req->tempatlahir) {
            $query->where('tempat_lahir', $req->input('tempatlahir'));
        }
        if ($req->gender) {
            $query->where('jenis_kelamin', $req->input('gender'));
        }
        $siswa = $query->get();
        $tempatlahir = Siswa::distinct()->pluck('tempat_lahir');
        $kelas = Kelas::where('instansi_id', $instansi_id->id)->get();
        return view('siswa.index', compact('siswa', 'kelas', 'tempatlahir'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($instansi)
    {
        $data_instansi = instansi::where('nama_instansi', $instansi)->first();
        $data_kelas = Kelas::where('instansi_id', $data_instansi->id)->get();
        return view('siswa.create', compact('data_instansi', 'data_kelas'));
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
            'kelas_id' => 'required',
            'nama_siswa' => 'required',
            'nis' => 'required|numeric',
            'alamat_siswa' => 'required',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'nama_wali_siswa' => 'required',
            'pekerjaan_wali_siswa' => 'required',
            'nohp_wali_siswa' => 'required|numeric',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        $checkNIS = Siswa::where('nis', $req->nis)->first();
        if($checkNIS) return redirect()->back()->withInput()->with('fail', 'NIS sudah digunakan');

        // save data
        $data = $req->except(['_method', '_token']);
        if($instansi == 'tk-kb-tpa'){
            $data['nohp_siswa'] = 0;
        }else{
            $data['nohp_siswa'] = $req->nohp_siswa;
        }
        $data['status'] = 'AKTIF';
        $check = Siswa::create($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        return redirect()->route('siswa.index', ['instansi' => $instansi])->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function show($instansi, $id)
    {
        $siswa = Siswa::find($id);
        $instansis = instansi::with('kelas')->where('nama_instansi', $instansi)->first();
        return view('siswa.show', compact('siswa', 'instansis'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function edit($instansi, $id)
    {
        $siswa = Siswa::find($id);
        $instansis = instansi::with('kelas')->where('nama_instansi', $instansi)->first();
        return view('siswa.edit', compact('siswa', 'instansis'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $instansi, $id)
    {
        // validation
        $validator = Validator::make($req->all(), [
            'instansi_id' => 'required',
            'kelas_id' => 'required',
            'nama_siswa' => 'required',
            'nis' => 'required|numeric',
            'alamat_siswa' => 'required',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'nama_wali_siswa' => 'required',
            'pekerjaan_wali_siswa' => 'required',
            'nohp_wali_siswa' => 'required|numeric',
            'status' => 'required',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        $checkNIS = Siswa::where('nis', $req->nis)->where('id', '!=', $id)->first();
        if($checkNIS) return redirect()->back()->withInput()->with('fail', 'NIS sudah digunakan');

        // save data
        $data = $req->except(['_method', '_token']);
        $data['nohp_siswa'] = 0;
        $check = Siswa::find($id)->update($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal diupdate');
        return redirect()->route('siswa.index', ['instansi' => $instansi])->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function destroy($instansi, $id)
    {
        $data = Siswa::find($id);
        if(!$data) return response()->json(['msg' => 'Data tidak ditemukan'], 404);
        $check = $data->delete();
        if(!$check) return response()->json(['msg' => 'Gagal menghapus data'], 400);
        return response()->json(['msg' => 'Data berhasil dihapus']);
    }

    public function datasiswa($siswa_id)
    {
        $data = Siswa::with('instansi', 'kelas')->find($siswa_id);
        return response()->json($data);
    }
}
