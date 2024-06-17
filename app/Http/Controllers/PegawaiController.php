<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use App\Models\Jabatan;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req, $instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $query = Pegawai::orderByDesc('id')->where('instansi_id', $data_instansi->id);
        if ($req->jabatan) {
            $query->where('jabatan_id', $req->input('jabatan'));
        }
        if ($req->tempatlahir) {
            $query->where('tempat_lahir', $req->input('tempatlahir'));
        }
        if ($req->gender) {
            $query->where('jenis_kelamin', $req->input('gender'));
        }
        if ($req->status) {
            $query->where('status_kawin', $req->input('status'));
        }
        if ($req->anak) {
            switch ($req->anak) {
                case 'Punya Anak':
                    $query->where('jumlah_anak', '>', 0);
                    break;
                
                default:
                $query->where('jumlah_anak', 0);
                    break;
            }
            
        }
        $pegawai = $query->get();
        $jabatan = Jabatan::where('instansi_id', $data_instansi->id)->get();
        $tempatlahir = Pegawai::distinct()->pluck('tempat_lahir');
        return view('pegawai.index', compact('pegawai', 'jabatan', 'tempatlahir'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($instansi)
    {
        $data_instansi = instansi::where('nama_instansi', $instansi)->first();
        $jabatans = Jabatan::where('instansi_id', $data_instansi->id)->get();
        $query = Instansi::with('kelas');
        if(Auth::user()->role == 'SUPERADMIN'){
            $instansi = $query->get();
        } else {
            $instansi = $query->where('kode', Auth::user()->pegawai->kode_instansi)->get();
        }
        return view('pegawai.create', compact('instansi', 'data_instansi', 'jabatans'));
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
            'jabatan_id' => 'required',
            'nip' => 'required',
            'nama_gurukaryawan' => 'required',
            'alamat_gurukaryawan' => 'required',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'no_hp_gurukaryawan' => 'required',
            'status_kawin' => 'required',
            'jumlah_anak' => 'required',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        $checkNIP = Pegawai::where('nip', $req->nip)->first();
        if($checkNIP) return redirect()->back()->withInput()->with('fail', 'NIP sudah digunakan');

        // save data
        $data = $req->except(['_method', '_token']);
        $data['status'] = 'AKTIF';
        $check = Pegawai::create($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        return redirect()->route('pegawai.index', ['instansi' => $instansi])->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function show($instansi, $id)
    {
        $data_instansi = instansi::where('nama_instansi', $instansi)->first();
        $pegawai = Pegawai::find($id);
        $jabatans = Jabatan::where('instansi_id', $data_instansi->id)->get();
        $query = Instansi::with('kelas');
        if(Auth::user()->role == 'SUPERADMIN'){
            $instansi = $query->get();
        } else {
            $instansi = $query->where('kode', Auth::user()->pegawai->kode_instansi)->get();
        }
        return view('pegawai.show', compact(['pegawai', 'instansi', 'data_instansi', 'jabatans']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function edit($instansi, $id)
    {
        $data_instansi = instansi::where('nama_instansi', $instansi)->first();
        $pegawai = Pegawai::find($id);
        $jabatans = Jabatan::where('instansi_id', $data_instansi->id)->get();
        $query = Instansi::with('kelas');
        if(Auth::user()->role == 'SUPERADMIN'){
            $instansi = $query->get();
        } else {
            $instansi = $query->where('kode', Auth::user()->pegawai->kode_instansi)->get();
        }
        return view('pegawai.edit', compact(['pegawai', 'instansi', 'data_instansi', 'jabatans']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $instansi, $id)
    {
        // validation
        $validator = Validator::make($req->all(), [
            'instansi_id' => 'required',
            'jabatan_id' => 'required',
            'nip' => 'required',
            'nama_gurukaryawan' => 'required',
            'alamat_gurukaryawan' => 'required',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'no_hp_gurukaryawan' => 'required',
            'status_kawin' => 'required',
            'jumlah_anak' => 'required',
            'status' => 'required',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        $checkNIP = Pegawai::where('nip', $req->nip)->where('id', '!=', $id)->first();
        if($checkNIP) return redirect()->back()->withInput()->with('fail', 'NIP sudah digunakan');

        // save data
        $data = $req->except(['_method', '_token']);
        $check = Pegawai::find($id)->update($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        return redirect()->route('pegawai.index', ['instansi' => $instansi])->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function destroy($instansi, $id)
    {
        $data = Pegawai::find($id);
        if(!$data) return response()->json(['msg' => 'Data tidak ditemukan'], 404);
        $check = $data->delete();
        if(!$check) return response()->json(['msg' => 'Gagal menghapus data'], 400);
        return response()->json(['msg' => 'Data berhasil dihapus']);
    }

    public function findKaryawan(Request $req)
    {
        $data = Pegawai::with('jabatan', 'presensi')->find($req->karyawan_id);
        if(!$data) return response()->json('Not Found', 404);
        return response()->json($data);
    }
}
