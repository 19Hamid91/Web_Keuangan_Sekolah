<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\Atk;
use App\Models\Instansi;
use App\Models\Jurnal;
use App\Models\KartuStok;
use App\Models\KomponenBeliAtk;
use App\Models\PembelianAtk;
use App\Models\Supplier;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PembelianAtkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $data = PembelianAtk::whereHas('supplier', function($q) use($data_instansi){
            $q->where('instansi_id', $data_instansi->id);
        })->orderByDesc('id')->with('komponen')->get();
        $atks = Atk::where('instansi_id', $data_instansi->id)->get();
        $suppliers = Supplier::where('instansi_id', $data_instansi->id)->where('jenis_supplier', 'ATK')->get();
        return view('pembelian_atk.index', compact('data_instansi', 'data', 'atks', 'suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($instansi)
    {
        $data_instansi = instansi::where('nama_instansi', $instansi)->first();
        $suppliers = Supplier::where('instansi_id', $data_instansi->id)->where('jenis_supplier', 'ATK')->get();
        $atks = Atk::where('instansi_id', $data_instansi->id)->get();
        $akuns = Akun::where('instansi_id', $data_instansi->id)->get();
        return view('pembelian_atk.create', compact('data_instansi', 'suppliers', 'atks', 'akuns'));
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
            'tgl_beliatk' => 'required|date',
            'atk_id.*' => 'required',
            'satuan.*' => 'required',
            'jumlah_atk.*' => 'required|numeric',
            'hargasatuan_atk.*' => 'required|numeric',
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
            $fileName =  'Pembelian-ATK_' . date('YmdHis') . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('Bukti_Beli_ATK', $fileName, 'public');
            $data['file'] = $filePath;
        }

        $check = PembelianAtk::create($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');

        // simpan komponen
        $nama_barang = '';
        for ($i=0; $i < count($data['atk_id']); $i++) { 
            $komponen = KomponenBeliAtk::create([
                'beliatk_id' => $check->id,
                'atk_id' => $data['atk_id'][$i],
                'satuan' => $data['satuan'][$i],
                'jumlah' => $data['jumlah_atk'][$i],
                'harga_satuan' => $data['hargasatuan_atk'][$i],
                'diskon' => $data['diskon'][$i],
                'ppn' => $data['ppn'][$i],
                'harga_total' => $data['harga_total'][$i],
            ]);
        
            $atk = Atk::find($data['atk_id'][$i]);
            $lastKartuStok = KartuStok::where('atk_id', $data['atk_id'][$i])->orderByDesc('tanggal')->orderByDesc('id')->first();
            $sisaBefore = $lastKartuStok ? $lastKartuStok->sisa : 0;
        
            // Hitung harga rata-rata untuk pembelian
            $totalHargaStokSebelumnya = $lastKartuStok ? $lastKartuStok->total_harga_stok : 0;
            $stokSebelumnya = $lastKartuStok ? $lastKartuStok->sisa : 0;
            $hargaRataRata = ($totalHargaStokSebelumnya + $komponen->harga_total) / ($stokSebelumnya + $komponen->jumlah);
        
            $kartuStok = KartuStok::updateOrCreate(
                [
                    'pembelian_atk_id' => $check->id,
                    'komponen_beliatk_id' => $komponen->id,
                    'atk_id' => $data['atk_id'][$i],
                    'tanggal' => $check->tgl_beliatk,
                ],
                [
                    'masuk' => $komponen->jumlah,
                    'keluar' => 0,
                    'sisa' => $sisaBefore + $komponen->jumlah,
                    'harga_unit_masuk' => $komponen->harga_satuan,
                    'total_harga_masuk' => $komponen->harga_total,
                    'harga_rata_rata' => $hargaRataRata,
                    'total_harga_stok' => $totalHargaStokSebelumnya + $komponen->harga_total,
                    'pengambil' => $check->supplier->nama_supplier,
                ]
            );
        
            $nama_barang .= $atk->nama_atk . ', ';
        }

        // jurnal
        $akun = Akun::where('instansi_id', $data_instansi->id)->where('nama', 'LIKE', '%PERSEDIAAN ATK%')->where('jenis', 'BEBAN')->first();
        // $jurnal = new Jurnal([
        //     'instansi_id' => $data_instansi->id,
        //     'keterangan' => 'Pembelian Atk: ' . $nama_barang,
        //     'nominal' => $check->total,
        //     'akun_debit' => $akun->id,
        //     'akun_kredit' => $data['akun_id'],
        //     'tanggal' => $check->tgl_beliatk,
        // ]);
        // $check->journals()->save($jurnal);

        // create akun
        for ($i = 0; $i < count($data['akun']); $i++) {
            $this->createJurnal('Pembelian ATK', $data['akun'][$i], $data['debit'][$i], $data['kredit'][$i], $data_instansi->id , now());
        }

        return redirect()->route('pembelian-atk.index', ['instansi' => $instansi])->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PembelianAtk  $pembelianAtk
     * @return \Illuminate\Http\Response
     */
    public function show($instansi, $id)
    {
        $data_instansi = instansi::where('nama_instansi', $instansi)->first();
        $suppliers = Supplier::where('instansi_id', $data_instansi->id)->where('jenis_supplier', 'ATK')->get();
        $atks = Atk::where('instansi_id', $data_instansi->id)->get();
        $data = PembelianAtk::with('komponen')->find($id);
        return view('pembelian_atk.show', compact('data_instansi', 'suppliers', 'atks', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PembelianAtk  $pembelianAtk
     * @return \Illuminate\Http\Response
     */
    public function edit($instansi, $id)
    {
        $data_instansi = instansi::where('nama_instansi', $instansi)->first();
        $suppliers = Supplier::where('instansi_id', $data_instansi->id)->where('jenis_supplier', 'ATK')->get();
        $atks = Atk::where('instansi_id', $data_instansi->id)->get();
        $data = PembelianAtk::with('komponen')->find($id);
        return view('pembelian_atk.edit', compact('data_instansi', 'suppliers', 'atks', 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PembelianAtk  $pembelianAtk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $instansi, $id)
    {
        // validation
        $validator = Validator::make($req->all(), [
            'supplier_id' => 'required',
            'tgl_beliatk' => 'required|date',
            'atk_id.*' => 'required',
            'satuan.*' => 'required',
            'jumlah_atk.*' => 'required|numeric',
            'hargasatuan_atk.*' => 'required|numeric',
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
            $fileName =  'Pembelian-ATK_' . date('YmdHis') . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('Bukti_Beli_ATK', $fileName, 'public');
            $data['file'] = $filePath;
        }

        $oldKartuStok = PembelianAtk::find($id);
        $check = PembelianAtk::find($id)->update($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');

        // simpan komponen
        PembelianAtk::find($id)->komponen()->get()->each(function($komponen) {
            $komponen->delete();
        });
        $nama_barang = '';
        for ($i=0; $i < count($data['atk_id']); $i++) { 
            $komponen = KomponenBeliAtk::create([
                'beliatk_id' => $id,
                'atk_id' => $data['atk_id'][$i],
                'satuan' => $data['satuan'][$i],
                'jumlah' => $data['jumlah_atk'][$i],
                'harga_satuan' => $data['hargasatuan_atk'][$i],
                'diskon' => $data['diskon'][$i],
                'ppn' => $data['ppn'][$i],
                'harga_total' => $data['harga_total'][$i],
            ]);

            // buat kartu penyusutan
            $atk = Atk::find($data['atk_id'][$i]);
            $lastKartuStok = KartuStok::where('atk_id', $data['atk_id'][$i])->orderByDesc('tanggal')->orderByDesc('id')->first();
            $sisaBefore = $lastKartuStok ? $lastKartuStok->sisa : 0;
        
            // Hitung harga rata-rata untuk pembelian
            $totalHargaStokSebelumnya = $lastKartuStok ? $lastKartuStok->total_harga_stok : 0;
            $stokSebelumnya = $lastKartuStok ? $lastKartuStok->sisa : 0;
            $hargaRataRata = ($totalHargaStokSebelumnya + $komponen->harga_total) / ($stokSebelumnya + $komponen->jumlah);
        
            $kartuStok = KartuStok::updateOrCreate(
                [
                    'pembelian_atk_id' => PembelianAtk::find($id)->id,
                    'komponen_beliatk_id' => $komponen->id,
                    'atk_id' => $data['atk_id'][$i],
                ],
                [
                    'tanggal' => PembelianAtk::find($id)->tgl_beliatk,
                    'masuk' => $komponen->jumlah,
                    'keluar' => 0,
                    'sisa' => $sisaBefore + $komponen->jumlah,
                    'harga_unit_masuk' => $komponen->harga_satuan,
                    'total_harga_masuk' => $komponen->harga_total,
                    'harga_rata_rata' => $hargaRataRata,
                    'total_harga_stok' => $totalHargaStokSebelumnya + $komponen->harga_total,
                    'pengambil' => PembelianAtk::find($id)->supplier->nama_supplier,
                ]
            );
        
            $nama_barang .= $atk->nama_atk . ', ';
            if($lastKartuStok){
                $lastKartuStok->forceDelete();
            }
            $this->updateKartuStok($data['atk_id'][$i]);
        }
        // jurnal
        // $dataJournal = [
        //     'keterangan' => 'Pembelian atk: ' .$nama_barang,
        //     'nominal' => PembelianAtk::find($id)->total,
        //     'tanggal' => PembelianAtk::find($id)->tgl_beliatk,
        // ];
        // $journal = PembelianAtk::find($id)->journals()->first();
        // $journal->update($dataJournal);
        return redirect()->route('pembelian-atk.index', ['instansi' => $instansi])->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PembelianAtk  $pembelianAtk
     * @return \Illuminate\Http\Response
     */
    public function destroy($instansi, $id)
    {
        $data = PembelianAtk::find($id);
        if(!$data) return response()->json(['msg' => 'Data tidak ditemukan'], 404);
        $check = $data->delete();
        foreach ($data->komponen as $komponen) {
            $this->updateKartuStok($komponen->atk_id);
        }
        if(!$check) return response()->json(['msg' => 'Gagal menghapus data'], 400);
        return response()->json(['msg' => 'Data berhasil dihapus']);
    }

    public function cetak($instansi, $id)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $data = PembelianAtk::with('komponen.atk', 'supplier')->find($id)->toArray();
        $data['instansi_id'] = $data_instansi->id;
        // dd($data);
        $pdf = Pdf::loadView('pembelian_atk.cetak', $data)->setPaper('a4', 'landscape');
        return $pdf->stream('kwitansi-beli-atk.pdf');
    }

    public function updateKartuStok($atk_id)
    {
        $data = KartuStok::where('atk_id', $atk_id)->whereHas('pembelian_atk')->orderBy('tanggal')->get();
        $sisaSebelumnya = 0;

        foreach ($data as $item) {
            $item->sisa = ($sisaSebelumnya + ($item->masuk ?? 0)) - ($item->keluar ?? 0);
            $item->save();
            $sisaSebelumnya = $item->sisa;
        }
    }

    private function createJurnal($keterangan, $akun, $debit, $kredit, $instansi_id, $tanggal)
    {
        Jurnal::create([
            'instansi_id' => $instansi_id,
            'journable_type' => PembelianAtk::class,
            'journable_id' => null,
            'keterangan' => $keterangan,
            'akun_debit' => $debit ? $akun : null,
            'akun_kredit' => $kredit ? $akun : null,
            'nominal' => $debit ?? $kredit,
            'tanggal' => $tanggal,
        ]);
    }
}
