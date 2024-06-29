<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\Donatur;
use App\Models\Instansi;
use App\Models\Jurnal;
use App\Models\PemasukanLainnya;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PemasukanLainnyaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $data = PemasukanLainnya::where('instansi_id', $data_instansi->id)->orderByDesc('id')->get();
        return view('pemasukan_lainnya.index', compact('data_instansi', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($instansi)
    {
        $donaturs = Donatur::all();
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $akun = Akun::where('instansi_id', $data_instansi->id)->whereIn('jenis', ['KAS', 'BANK', 'LIABILITAS JANGKA PENDEK', 'LIABILITAS JANGKA PANJANG'])->get();
        return view('pemasukan_lainnya.create', compact('data_instansi', 'donaturs', 'akun'));
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
            'akun_id' => 'required',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);

        // save data
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $data = $req->except(['_method', '_token']);

        // file
        if ($req->hasFile('file')) {
            $file = $req->file('file');
            $jenis = str_replace(' ', '-', $req->jenis);
            $fileName =  $jenis . '_' . date('YmdHis') . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('Bukti_Beli_ATK', $fileName, 'public');
            $data['file'] = $filePath;
        }

        if ($data['jenis'] == 'Donasi') {
            $donatur = Donatur::find($req->donatur_id)->nama;
            $data['donatur_id'] = $req->donatur_id;
        } else {
            $donatur = $req->donatur;
        }
        $data['donatur'] = $donatur;
        $check = PemasukanLainnya::create($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        // jurnal
        
        $akun = Akun::where('instansi_id', $data_instansi->id)->where('nama', 'LIKE', '%Pendapatan '.$data['jenis'].'%')->where('jenis', 'PENDAPATAN')->first();
        $jurnal = new Jurnal([
            'instansi_id' => $check->instansi_id,
            'keterangan' => 'Pemasukan: ' . $check->jenis,
            'nominal' => $check->total,
            'akun_debit' => $data['akun_id'],
            'akun_kredit' => $akun->id,
            'tanggal' => $check->tanggal,
        ]);
        $check->journals()->save($jurnal);
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
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        return view('pemasukan_lainnya.show', compact('data_instansi', 'donaturs', 'data'));
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
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        return view('pemasukan_lainnya.edit', compact('data_instansi', 'donaturs', 'data'));
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
            $filePath = $file->storeAs('Bukti_Beli_ATK', $fileName, 'public');
            $data['file'] = $filePath;
        }

        if ($data['jenis'] == 'Donasi') {
            $donatur = Donatur::find($req->donatur_id)->nama;
            $data['donatur_id'] = $req->donatur_id;
        } else {
            $donatur = $req->donatur;
        }
        $data['donatur'] = $donatur;
        $check = PemasukanLainnya::find($pemasukanLainnya)->update($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        // jurnal
        $dataJournal = [
            'keterangan' => 'Pemasukan: ' . PemasukanLainnya::find($pemasukanLainnya)->jenis,
            'nominal' => PemasukanLainnya::find($pemasukanLainnya)->total,
            'tanggal' => PemasukanLainnya::find($pemasukanLainnya)->tanggal,
        ];
        $journal = PemasukanLainnya::find($pemasukanLainnya)->journals()->first();
        $journal->update($dataJournal);
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
}
