<?php

namespace App\Http\Controllers;

use App\Models\Akun;
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
        $akun = Akun::where('instansi_id', $data_instansi->id)->whereIn('jenis', ['KAS', 'BANK'])->get();
        return view('penggajian.create', compact('data_instansi', 'jabatans', 'karyawans', 'akun'));
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
            'akun_id' => 'required',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        $isDuplicate = Penggajian::where('karyawan_id', $req->karyawan_id)->where('jabatan_id', $req->jabatan_id)->where('presensi_karyawan_id', $req->presensi_karyawan_id)->first();
        if($isDuplicate) return redirect()->back()->withInput()->with('fail', 'Pegawai sudah digaji');

        // save data
        $data_instansi = instansi::where('nama_instansi', $instansi)->first();
        $data = $req->except(['_method', '_token']);
        $check = Penggajian::create($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        $bulanPemetaan = [
            'Januari' => '01',
            'Februari' => '02',
            'Maret' => '03',
            'April' => '04',
            'Mei' => '05',
            'Juni' => '06',
            'Juli' => '07',
            'Agustus' => '08',
            'September' => '09',
            'Oktober' => '10',
            'November' => '11',
            'Desember' => '12'
        ];
        // jurnal
        $akun = Akun::where('instansi_id', $data_instansi->id)->where('nama', 'LIKE', '%Gaji%')->where('jenis', 'BEBAN')->first();
        $presensi = PresensiKaryawan::find($data['presensi_karyawan_id']);
        if (array_key_exists($presensi->bulan, $bulanPemetaan)) {
            $bulanAngka = $bulanPemetaan[$presensi->bulan];
        }
        $tanggal = "$presensi->tahun-$bulanAngka-01";
        
        $jurnal = new Jurnal([
            'instansi_id' => $check->pegawai->instansi_id,
            'keterangan' => 'Penggajian pegawai: ' . $check->presensi->bulan . ' ' . $check->presensi->tahun,
            'nominal' => $check->total_gaji,
            'akun_debit' => $akun->id,
            'akun_kredit' => $data['akun_id'],
            'tanggal' => $tanggal,
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
        $bulanPemetaan = [
            'Januari' => '01',
            'Februari' => '02',
            'Maret' => '03',
            'April' => '04',
            'Mei' => '05',
            'Juni' => '06',
            'Juli' => '07',
            'Agustus' => '08',
            'September' => '09',
            'Oktober' => '10',
            'November' => '11',
            'Desember' => '12'
        ];
        // jurnal
        $presensi = PresensiKaryawan::find($data['presensi_karyawan_id']);
        if (array_key_exists($presensi->bulan, $bulanPemetaan)) {
            $bulanAngka = $bulanPemetaan[$presensi->bulan];
        }
        $tanggal = "$presensi->tahun-$bulanAngka-01";
        $dataJournal = [
            'keterangan' => 'Penggajian pegawai: ' .  Penggajian::find($penggajian)->presensi->bulan . ' ' .  Penggajian::find($penggajian)->presensi->tahun,
            'nominal' => Penggajian::find($penggajian)->total_gaji,
            'tanggal' => $tanggal,
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
