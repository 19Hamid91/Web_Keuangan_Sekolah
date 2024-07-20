<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\Aset;
use App\Models\Instansi;
use App\Models\Jurnal;
use App\Models\KartuPenyusutan;
use App\Models\KomponenBeliAset;
use App\Models\PembelianAset;
use App\Models\Supplier;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PembelianAsetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $data = PembelianAset::whereHas('supplier', function($q) use($data_instansi){
            $q->where('instansi_id', $data_instansi->id);
        })->orderByDesc('id')->with('komponen')->get();
        $asets = Aset::where('instansi_id', $data_instansi->id)->get();
        $suppliers = Supplier::where('instansi_id', $data_instansi->id)->where('jenis_supplier', 'Aset')->get();
        return view('pembelian_aset.index', compact('data_instansi', 'asets', 'data', 'suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($instansi)
    {
        $data_instansi = instansi::where('nama_instansi', $instansi)->first();
        $suppliers = Supplier::where('instansi_id', $data_instansi->id)->where('jenis_supplier', 'Aset')->get();
        $asets = Aset::where('instansi_id', $data_instansi->id)->get();
        $akuns = Akun::where('instansi_id', $data_instansi->id)->get();
        return view('pembelian_aset.create', compact('data_instansi', 'suppliers', 'asets', 'akuns'));
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
            'akun.*' => 'required',
            'supplier_id' => 'required',
            'tgl_beliaset' => 'required|date',
            'aset_id.*' => 'required',
            'satuan.*' => 'required',
            'jumlah_aset.*' => 'required|numeric',
            'hargasatuan_aset.*' => 'required|numeric',
            'diskon.*' => 'required|numeric|max:100|min:0',
            'ppn.*' => 'required|numeric|max:100|min:0',
            'harga_total.*' => 'required|numeric',
            'total' => 'required|numeric',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);

        // save data
        $data_instansi = instansi::where('nama_instansi', $instansi)->first();
        $data = $req->except(['_method', '_token']);

        // file
        if ($req->hasFile('file')) {
            $file = $req->file('file');
            $fileName =  'Pembelian-Aset_' . date('YmdHis') . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('Bukti_Beli_Aset', $fileName, 'public');
            $data['file'] = $filePath;
        }

        $check = PembelianAset::create($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');

        // simpan komponen
        $nama_barang = '';
        for ($i=0; $i < count($data['aset_id']); $i++) { 
            $komponen = KomponenBeliAset::create([
                'beliaset_id' => $check->id,
                'aset_id' => $data['aset_id'][$i],
                'satuan' => $data['satuan'][$i],
                'jumlah' => $data['jumlah_aset'][$i],
                'harga_satuan' => $data['hargasatuan_aset'][$i],
                'diskon' => $data['diskon'][$i],
                'ppn' => $data['ppn'][$i],
                'harga_total' => $data['harga_total'][$i],
            ]);

            // buat kartu penyusutan
            $aset = Aset::find($data['aset_id'][$i]);
            $check2 = KartuPenyusutan::create([
                'aset_id' => $data['aset_id'][$i],
                'pembelian_aset_id' => $check->id,
                'komponen_id' => $komponen->id,
                'nama_barang' => $aset->nama_aset,
                'jumlah_barang' => $data['jumlah_aset'][$i],
                'tanggal_operasi' => now(),
                'masa_penggunaan' => 0,
                'residu' => 0,
                'metode' => 'Garis Lurus',
            ]);
            $nama_barang .= $aset->nama_aset . ', ';
        }

        // jurnal
        if($data_instansi->id == 1){
            $akun = Akun::where('instansi_id', $data_instansi->id)->where('nama', 'LIKE', '%Biaya Aset Tetap%')->where('jenis', 'BEBAN')->first();
        } else {
            $akun = Akun::where('instansi_id', $data_instansi->id)->where('nama', 'LIKE', '%Pembelian Aset Tetap%')->where('jenis', 'BEBAN')->first();
        }
        // create akun
        for ($i = 0; $i < count($data['akun']); $i++) {
            $this->createJurnal('Pembelian Aset', $data['akun'][$i], $data['debit'][$i], $data['kredit'][$i], $data_instansi->id , now());
        }
        // $jurnal = new Jurnal([
        //     'instansi_id' => $data_instansi->id,
        //     'keterangan' => 'Pembelian aset: ' . $nama_barang,
        //     'nominal' => $check->total,
        //     'akun_debit' => $akun->id,
        //     'akun_kredit' => $data['akun_id'],
        //     'tanggal' => $check->tgl_beliaset,
        // ]);
        // $check->journals()->save($jurnal);
        return redirect()->route('pembelian-aset.index', ['instansi' => $instansi])->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PembelianAset  $pembelianAset
     * @return \Illuminate\Http\Response
     */
    public function show($instansi, $id)
    {
        $data_instansi = instansi::where('nama_instansi', $instansi)->first();
        $suppliers = Supplier::where('instansi_id', $data_instansi->id)->where('jenis_supplier', 'Aset')->get();
        $asets = Aset::where('instansi_id', $data_instansi->id)->get();
        $data = PembelianAset::with('komponen')->find($id);
        return view('pembelian_aset.show', compact('data_instansi', 'suppliers', 'asets', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PembelianAset  $pembelianAset
     * @return \Illuminate\Http\Response
     */
    public function edit($instansi, $id)
    {
        $data_instansi = instansi::where('nama_instansi', $instansi)->first();
        $suppliers = Supplier::where('instansi_id', $data_instansi->id)->where('jenis_supplier', 'Aset')->get();
        $asets = Aset::where('instansi_id', $data_instansi->id)->get();
        $data = PembelianAset::with('komponen')->find($id);
        return view('pembelian_aset.edit', compact('data_instansi', 'suppliers', 'asets', 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PembelianAset  $pembelianAset
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $instansi, $id)
    {
        // validation
        $validator = Validator::make($req->all(), [
            'supplier_id' => 'required',
            'tgl_beliaset' => 'required|date',
            'aset_id.*' => 'required',
            'satuan.*' => 'required',
            'jumlah_aset.*' => 'required|numeric',
            'hargasatuan_aset.*' => 'required|numeric',
            'diskon.*' => 'required|numeric|max:100|min:0',
            'ppn.*' => 'required|numeric|max:100|min:0',
            'harga_total.*' => 'required|numeric',
            'total' => 'required|numeric',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);

        // save data
        $data = $req->except(['_method', '_token']);

        // file
        if ($req->hasFile('file')) {
            $file = $req->file('file');
            $fileName =  'Pembelian-Aset_' . date('YmdHis') . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('Bukti_Beli_Aset', $fileName, 'public');
            $data['file'] = $filePath;
        }
        
        $check = PembelianAset::find($id)->update($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');

        // simpan komponen
        PembelianAset::find($id)->komponen()->get()->each(function($komponen) {
            $komponen->delete();
        });
        $nama_barang = '';
        for ($i=0; $i < count($data['aset_id']); $i++) { 
            $komponen = KomponenBeliAset::create([
                'beliaset_id' => $id,
                'aset_id' => $data['aset_id'][$i],
                'satuan' => $data['satuan'][$i],
                'jumlah' => $data['jumlah_aset'][$i],
                'harga_satuan' => $data['hargasatuan_aset'][$i],
                'diskon' => $data['diskon'][$i],
                'ppn' => $data['ppn'][$i],
                'harga_total' => $data['harga_total'][$i],
            ]);

            // buat kartu penyusutan
            $aset = Aset::find($data['aset_id'][$i]);
            $check2 = KartuPenyusutan::create([
                'aset_id' => $data['aset_id'][$i],
                'pembelian_aset_id' => $id,
                'komponen_id' => $komponen->id,
                'nama_barang' => $aset->nama_aset,
                'jumlah_barang' => $data['jumlah_aset'][$i],
                'tanggal_operasi' => now(),
                'masa_penggunaan' => 0,
                'residu' => 0,
                'metode' => 'Garis Lurus',
            ]);
            $nama_barang .= $aset->nama_aset . ', ';
        }
        
        // jurnal
        // $dataJournal = [
        //     'keterangan' => 'Pembelian aset: ' . $nama_barang,
        //     'nominal' => PembelianAset::find($id)->total,
        //     'tanggal' => PembelianAset::find($id)->tgl_beliaset,
        // ];
        // $journal = PembelianAset::find($id)->journals()->first();
        // $journal->update($dataJournal);
        return redirect()->route('pembelian-aset.index', ['instansi' => $instansi])->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PembelianAset  $pembelianAset
     * @return \Illuminate\Http\Response
     */
    public function destroy($instansi, $id)
    {
        $data = PembelianAset::find($id);
        if(!$data) return response()->json(['msg' => 'Data tidak ditemukan'], 404);
        $check = $data->delete();
        if(!$check) return response()->json(['msg' => 'Gagal menghapus data'], 400);
        return response()->json(['msg' => 'Data berhasil dihapus']);
    }

    public function cetak($instansi, $id)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $data = PembelianAset::with('komponen.aset', 'supplier')->find($id)->toArray();
        $data['instansi_id'] = $data_instansi->id;
        // dd($data);
        $pdf = Pdf::loadView('pembelian_aset.cetak', $data)->setPaper('a4', 'landscape');
        return $pdf->stream('kwitansi-beli-aset.pdf');
    }

    private function createJurnal($keterangan, $akun, $debit, $kredit, $instansi_id, $tanggal)
    {
        Jurnal::create([
            'instansi_id' => $instansi_id,
            'journable_type' => PembelianAset::class,
            'journable_id' => null,
            'keterangan' => $keterangan,
            'akun_debit' => $debit ? $akun : null,
            'akun_kredit' => $kredit ? $akun : null,
            'nominal' => $debit ?? $kredit,
            'tanggal' => $tanggal,
        ]);
    }
}
