<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\Donatur;
use App\Models\Instansi;
use App\Models\Jurnal;
use App\Models\PemasukanLainnya;
use App\Models\PenyewaKantin;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PemasukanLainnyaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req, $instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $query = PemasukanLainnya::where('instansi_id', $data_instansi->id)->orderByDesc('id');
        if($req->jenis){
            $jenis = $req->jenis;
            $query->where('jenis', $jenis);
        } else {
            $jenis = 'Lainnya';
            $query->where('jenis', $jenis);
        }
        $data = $query->get();
        $akuns = Akun::where('instansi_id', $data_instansi->id)->get();
        return view('pemasukan_lainnya.index', compact('data_instansi', 'data', 'jenis', 'akuns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($instansi)
    {
        $donaturs = Donatur::all();
        $penyewa_kantin = PenyewaKantin::all();
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $akuns = Akun::where('instansi_id', $data_instansi->id)->get();
        return view('pemasukan_lainnya.create', compact('data_instansi', 'donaturs', 'akuns', 'penyewa_kantin'));
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
            'instansi_id' => 'required|exists:t_instansi,id',
            'jenis' => 'required',
            'tanggal' => 'required|date',
            'total' => 'required|numeric',
            'keterangan' => 'required',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);

        // save data
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $data = $req->except(['_method', '_token']);
        $data['invoice'] = 'INVL' . date('Ymdhis');

        // file
        if ($req->hasFile('file')) {
            $file = $req->file('file');
            $jenis = str_replace(' ', '-', $req->jenis);
            $fileName =  $jenis . '_' . date('YmdHis') . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('Bukti_Pemasukan_lainnya', $fileName, 'public');
            $data['file'] = $filePath;
        }

        if ($data['jenis'] == 'Donasi') {
            $donatur = Donatur::find($req->donatur_id)->nama;
            $data['donatur_id'] = $req->donatur_id;
            $data['donatur'] = $donatur;
        } elseif ($data['jenis'] == 'Sewa Kantin') {
            $penyewa = PenyewaKantin::find($req->penyewa_id)->nama;
            $data['penyewa_id'] = $req->penyewa_id;
            $data['donatur'] = $penyewa;
        } else {
            $donatur = $req->donatur;
        }
        $check = PemasukanLainnya::create($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        // create akun
            // for ($i = 0; $i < count($data['akun']); $i++) {
            //     $this->createJurnal('Pemasukan Lainnya', $data['akun'][$i], $data['debit'][$i], $data['kredit'][$i], $data_instansi->id , now(), $check->id);
            // }
        // $akun = Akun::where('instansi_id', $data_instansi->id)->where('nama', 'LIKE', '%Pendapatan '.$data['jenis'].'%')->where('jenis', 'PENDAPATAN')->first();
        // $jurnal = new Jurnal([
        //     'instansi_id' => $check->instansi_id,
        //     'keterangan' => 'Pemasukan: ' . $check->jenis,
        //     'nominal' => $check->total,
        //     'akun_debit' => $data['akun_id'],
        //     'akun_kredit' => $akun->id,
        //     'tanggal' => $check->tanggal,
        // ]);
        // $check->journals()->save($jurnal);
        return redirect()->route('pemasukan_lainnya.index', ['instansi' => $instansi])->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PemasukanLainnya  $pemasukanLainnya
     * @return \Illuminate\Http\Response
     */
    public function show($instansi, $pemasukan_lainnya)
    {
        $data = PemasukanLainnya::find($pemasukan_lainnya);
        $donaturs = Donatur::all();
        $penyewa_kantin = PenyewaKantin::all();
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        return view('pemasukan_lainnya.show', compact('data_instansi', 'donaturs', 'data', 'penyewa_kantin'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PemasukanLainnya  $pemasukanLainnya
     * @return \Illuminate\Http\Response
     */
    public function edit($instansi, $pemasukan_lainnya)
    {
        $data = PemasukanLainnya::find($pemasukan_lainnya);
        $donaturs = Donatur::all();
        $penyewa_kantin = PenyewaKantin::all();
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        return view('pemasukan_lainnya.edit', compact('data_instansi', 'donaturs', 'data', 'penyewa_kantin'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PemasukanLainnya  $pemasukanLainnya
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $instansi, $pemasukanLainnya)
    {
        // validation
        $validator = Validator::make($req->all(), [
            'instansi_id' => 'required|exists:t_instansi,id',
            'jenis' => 'required',
            'tanggal' => 'required|date',
            'total' => 'required|numeric',
            'keterangan' => 'required',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);

        // save data
        $data = $req->except(['_method', '_token']);

        // file
        if ($req->hasFile('file')) {
            $file = $req->file('file');
            $jenis = str_replace(' ', '-', $req->jenis);
            $fileName =  $jenis . '_' . date('YmdHis') . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('Bukti_Pemasukan_lainnya', $fileName, 'public');
            $data['file'] = $filePath;
        }

        if ($data['jenis'] == 'Donasi') {
            $donatur = Donatur::find($req->donatur_id)->nama;
            $data['donatur_id'] = $req->donatur_id;
            $data['donatur'] = $donatur;
        } elseif ($data['jenis'] == 'Sewa Kantin') {
            $penyewa = PenyewaKantin::find($req->penyewa_id)->nama;
            $data['penyewa_id'] = $req->penyewa_id;
            $data['donatur'] = $penyewa;
        } else {
            $donatur = $req->donatur;
        }
        $check = PemasukanLainnya::find($pemasukanLainnya)->update($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        // jurnal
        // $dataJournal = [
        //     'keterangan' => 'Pemasukan: ' . PemasukanLainnya::find($pemasukanLainnya)->jenis,
        //     'nominal' => PemasukanLainnya::find($pemasukanLainnya)->total,
        //     'tanggal' => PemasukanLainnya::find($pemasukanLainnya)->tanggal,
        // ];
        // $journal = PemasukanLainnya::find($pemasukanLainnya)->journals()->first();
        // $journal->update($dataJournal);
        return redirect()->route('pemasukan_lainnya.index', ['instansi' => $instansi])->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PemasukanLainnya  $pemasukanLainnya
     * @return \Illuminate\Http\Response
     */
    public function destroy($instansi, $pemasukanLainnya)
    {
        $data = PemasukanLainnya::find($pemasukanLainnya);
        if(!$data) return response()->json(['msg' => 'Data tidak ditemukan'], 404);
        $check = $data->delete();
        if(!$check) return response()->json(['msg' => 'Gagal menghapus data'], 400);
        return response()->json(['msg' => 'Data berhasil dihapus']);
    }

    public function cetak($instansi, $id)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $data = PemasukanLainnya::with('donasi')->find($id)->toArray();
        $data['instansi_id'] = $data_instansi->id;
        $pdf = Pdf::loadView('pemasukan_lainnya.cetak', $data)->setPaper('a4', 'landscape');
        return $pdf->stream('kwitansi-pemasukan-lainnya.pdf');
    }

    private function createJurnal($keterangan, $akun, $debit, $kredit, $instansi_id, $tanggal, $id)
    {
        Jurnal::create([
            'instansi_id' => $instansi_id,
            'journable_type' => PemasukanLainnya::class,
            'journable_id' => $id,
            'keterangan' => $keterangan,
            'akun_debit' => $debit ? $akun : null,
            'akun_kredit' => $kredit ? $akun : null,
            'nominal' => $debit ?? $kredit,
            'tanggal' => $tanggal,
        ]);
    }

    public function getNominal(Request $req, $instansi)
    {
        $validator = Validator::make($req->all(), [
            'tanggal' => 'required',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return response()->json($error, 400);
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();

        $data = PemasukanLainnya::whereDate('tanggal', $req->tanggal)->get();
        $overtime = $data->where('jenis', 'Overtime')->pluck('total')->sum() ?? 0;
        $donasi = $data->where('jenis', 'Donasi')->pluck('total')->sum() ?? 0;
        $sewa_kantin = $data->where('jenis', 'Sewa Kantin')->pluck('total')->sum() ?? 0;
        $lainnya = $data->where('jenis', 'Lainnya')->pluck('total')->sum() ?? 0;
        $total = $data->pluck('total')->sum();
        if($instansi == 'yayasan') $total = $lainnya + $sewa_kantin + $donasi;
        if($instansi == 'tk-kb-tpa') $total = $lainnya + $overtime;
        if($instansi == 'smp') $total = $lainnya;
        $data = [
            'total' => $total,
            'overtime' => $overtime,
            'donasi' => $donasi,
            'sewa_kantin' => $sewa_kantin,
            'lainnya' => $lainnya,
        ];
        return response()->json($data);
    }
}
