<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\Instansi;
use App\Models\Jabatan;
use App\Models\Jurnal;
use App\Models\Pegawai;
use App\Models\Penggajian;
use App\Models\PresensiKaryawan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PenggajianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req, $instansi)
    {
        $bulan = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $tahun = Penggajian::whereHas('pegawai', function($q) use ($data_instansi) {
            $q->where('instansi_id', $data_instansi->id);
        })->with('presensi')->get()->flatMap(function ($penggajian) {
            return $penggajian->presensi->pluck('tahun');
        })->unique()->values();
        $filterBulan = $req->input('bulan');
        $filterTahun = $req->input('tahun');
        $penggajian = Penggajian::whereHas('pegawai', function($q) use($data_instansi){
            $q->where('instansi_id', $data_instansi->id);
        })->whereHas('presensi', function($q) use($filterBulan, $filterTahun, $bulan){
            $q->when($filterBulan && $filterTahun, function($p) use($filterBulan, $filterTahun, $bulan){
                $p->where('tahun', $filterTahun)->where('bulan', $bulan[$filterBulan]);
            });
        })->get();
        $totalPerBulan = Penggajian::whereHas('pegawai', function($q) use($data_instansi, $filterBulan, $filterTahun, $bulan){
            $q->where('instansi_id', $data_instansi->id);
        })->whereHas('presensi', function($q) use($filterBulan, $filterTahun, $bulan){
            $q->when($filterBulan && $filterTahun, function($p) use($filterBulan, $filterTahun, $bulan){
                $p->where('tahun', $filterTahun)->where('bulan', $bulan[$filterBulan]);
            });
        })->sum('total_gaji') ?? 0;
        $akuns = Akun::where('instansi_id', $data_instansi->id)->get();
        return view('penggajian.index', compact('data_instansi', 'penggajian', 'totalPerBulan', 'tahun', 'bulan', 'akuns'));
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
        $karyawans = Pegawai::with('jabatan', 'presensi')->where('instansi_id', $data_instansi->id)->where('status', 'AKTIF')->get();
        $akun = Akun::where('instansi_id', $data_instansi->id)->whereIn('jenis', ['KAS', 'BANK', 'LIABILITAS JANGKA PENDEK', 'LIABILITAS JANGKA PANJANG'])->get();
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
            'gaji_kotor' => 'required|numeric',
            'total_gaji' => 'required|numeric',
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
        // $akun = Akun::where('instansi_id', $data_instansi->id)->where('nama', 'LIKE', '%Gaji%')->where('jenis', 'BEBAN')->first();
        $presensi = PresensiKaryawan::find($data['presensi_karyawan_id']);
        if (array_key_exists($presensi->bulan, $bulanPemetaan)) {
            $bulanAngka = $bulanPemetaan[$presensi->bulan];
        }
        // $tanggal = "$presensi->tahun-$bulanAngka-01";
        
        // $jurnal = new Jurnal([
        //     'instansi_id' => $check->pegawai->instansi_id,
        //     'keterangan' => 'Penggajian pegawai: ' . $check->presensi->bulan . ' ' . $check->presensi->tahun,
        //     'nominal' => $check->total_gaji,
        //     'akun_debit' => $akun->id,
        //     'akun_kredit' => $data['akun_id'],
        //     'tanggal' => $tanggal,
        // ]);
        // $check->journals()->save($jurnal);
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
        $karyawans = Pegawai::with('jabatan', 'presensi')->where('instansi_id', $data_instansi->id)->where('status', 'AKTIF')->get();
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
        $karyawans = Pegawai::with('jabatan', 'presensi')->where('instansi_id', $data_instansi->id)->where('status', 'AKTIF')->get();
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
            'gaji_kotor' => 'required|numeric',
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
        // $tanggal = "$presensi->tahun-$bulanAngka-01";
        // $dataJournal = [
        //     'keterangan' => 'Penggajian pegawai: ' .  Penggajian::find($penggajian)->presensi->bulan . ' ' .  Penggajian::find($penggajian)->presensi->tahun,
        //     'nominal' => Penggajian::find($penggajian)->total_gaji,
        //     'tanggal' => $tanggal,
        // ];
        // $journal = Penggajian::find($penggajian)->journals()->first();
        // $journal->update($dataJournal);
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

    public function cetak($instansi, $id)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $data = Penggajian::with('pegawai', 'jabatan', 'presensi')->find($id)->toArray();
        $data['instansi_id'] = $data_instansi->id;
        $pdf = Pdf::loadView('penggajian.cetak', $data);
        return $pdf->stream('slip-gaji.pdf');
    }

    public function getNominal(Request $req, $instansi){
        $validator = Validator::make($req->all(), [
            'bulan' => 'required',
            'tahun' => 'required',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return response()->json($error, 400);
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $bulan = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];
        $all = Penggajian::with('jabatan')->whereHas('jabatan', function($q) use($data_instansi){
            $q->where('instansi_id', $data_instansi->id);
        })->whereHas('presensi', function($p) use($req, $bulan){
            $p->where('tahun', $req->tahun)->where('bulan', $bulan[$req->bulan]);
        })->get();
        $gaji_kotor = $all->sum('gaji_kotor') ?? 0;
        $bpjs_sekolah = $all->sum(function($penggajian) {
            return $penggajian->jabatan->bpjs_kes_sekolah + $penggajian->jabatan->bpjs_ktk_sekolah;
        }) ?? 0;
        $bpjs_pribadi = $all->sum(function($penggajian) {
            return $penggajian->jabatan->bpjs_kes_pribadi + $penggajian->jabatan->bpjs_ktk_pribadi;
        }) ?? 0;
        $total = $gaji_kotor + $bpjs_sekolah + $bpjs_pribadi;
        $data = [
            'total' => $total,
            'gaji_kotor' => $gaji_kotor,
            'bpjs_sekolah' => $bpjs_sekolah,
            'bpjs_pribadi' => $bpjs_pribadi,
        ];
        return response()->json($data);
    }
}
