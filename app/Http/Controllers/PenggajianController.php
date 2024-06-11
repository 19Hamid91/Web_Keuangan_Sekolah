<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use App\Models\Jabatan;
use App\Models\Jurnal;
use App\Models\Pegawai;
use App\Models\Penggajian;
use App\Models\PresensiKaryawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PenggajianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $penggajian = Penggajian::whereHas('pegawai', function($q) use($data_instansi){
            $q->where('instansi_id', $data_instansi->id);
        })->get();
        return view('penggajian.index', compact('data_instansi', 'penggajian'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $jabatans = Jabatan::where('instansi_id', $data_instansi->id)->get();
        $karyawans = Pegawai::with('jabatan', 'presensi')->where('instansi_id', $data_instansi->id)->get();
        return view('penggajian.create', compact('data_instansi', 'jabatans', 'karyawans'));
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
            'karyawan_id' => 'required|exists:t_gurukaryawan,id',
            'jabatan_id' => 'required|exists:t_jabatan,id',
            'presensi_karyawan_id' => 'required|exists:t_presensi_karyawan,id',
            'potongan_bpjs' => 'required|numeric',
            'total_gaji' => 'required|numeric',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        $isDuplicate = Penggajian::where('karyawan_id', $req->karyawan_id)->where('jabatan_id', $req->jabatan_id)->where('presensi_karyawan_id', $req->presensi_karyawan_id)->first();
        if($isDuplicate) return redirect()->back()->withInput()->with('fail', 'Pegawai sudah digaji');

        // save data
        $data = $req->except(['_method', '_token']);
        $check = Penggajian::create($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        // jurnal
        $jurnal = new Jurnal([
            'instansi_id' => $check->pegawai->instansi_id,
            'keterangan' => 'Penggajian pegawai: ' . $check->presensi->bulan . ' ' . $check->presensi->tahun,
            'nominal' => $check->total_gaji,
            'akun_debit' => null,
            'akun_kredit' => null,
        ]);
        $check->journals()->save($jurnal);
        return redirect()->route('penggajian.index', ['instansi' => $instansi])->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Penggajian  $penggajian
     * @return \Illuminate\Http\Response
     */
    public function show($instansi, $penggajian)
    {
        $data = Penggajian::find($penggajian);
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $jabatans = Jabatan::where('instansi_id', $data_instansi->id)->get();
        $karyawans = Pegawai::with('jabatan', 'presensi')->where('instansi_id', $data_instansi->id)->get();
        return view('penggajian.show', compact('data_instansi', 'jabatans', 'karyawans', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penggajian  $penggajian
     * @return \Illuminate\Http\Response
     */
    public function edit($instansi, $penggajian)
    {
        $data = Penggajian::find($penggajian);
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $jabatans = Jabatan::where('instansi_id', $data_instansi->id)->get();
        $karyawans = Pegawai::with('jabatan', 'presensi')->where('instansi_id', $data_instansi->id)->get();
        return view('penggajian.edit', compact('data_instansi', 'jabatans', 'karyawans', 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Penggajian  $penggajian
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $instansi, $penggajian)
    {
        // validation
        $validator = Validator::make($req->all(), [
            'karyawan_id' => 'required|exists:t_gurukaryawan,id',
            'jabatan_id' => 'required|exists:t_jabatan,id',
            'presensi_karyawan_id' => 'required|exists:t_presensi_karyawan,id',
            'potongan_bpjs' => 'required|numeric',
            'total_gaji' => 'required|numeric',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        $isDuplicate = Penggajian::where('karyawan_id', $req->karyawan_id)->where('jabatan_id', $req->jabatan_id)->where('presensi_karyawan_id', $req->presensi_karyawan_id)->where('id', '!=', $penggajian)->first();
        if($isDuplicate) return redirect()->back()->withInput()->with('fail', 'Pegawai sudah digaji');

        // save data
        $data = $req->except(['_method', '_token']);
        $check = Penggajian::find($penggajian)->update($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal diupdate');
        // jurnal
        $dataJournal = [
            'instansi_id' => Penggajian::find($penggajian)->pegawai->instansi_id,
            'keterangan' => 'Penggajian pegawai: ' .  Penggajian::find($penggajian)->presensi->bulan . ' ' .  Penggajian::find($penggajian)->presensi->tahun,
            'nominal' => Penggajian::find($penggajian)->total_gaji,
        ];
        $journal = Penggajian::find($penggajian)->journals()->first();
        $journal->update($dataJournal);
        return redirect()->route('penggajian.index', ['instansi' => $instansi])->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penggajian  $penggajian
     * @return \Illuminate\Http\Response
     */
    public function destroy($instansi, $id)
    {
        $data = Penggajian::find($id);
        if(!$data) return response()->json(['msg' => 'Data tidak ditemukan'], 404);
        $check = $data->delete();
        if(!$check) return response()->json(['msg' => 'Gagal menghapus data'], 400);
        return response()->json(['msg' => 'Data berhasil dihapus']);
    }
}
