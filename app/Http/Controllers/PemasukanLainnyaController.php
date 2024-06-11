<?php

namespace App\Http\Controllers;

use App\Models\Donatur;
use App\Models\Instansi;
use App\Models\Jurnal;
use App\Models\PemasukanLainnya;
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
        $data = PemasukanLainnya::where('instansi_id', $data_instansi->id)->get();
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
        return view('pemasukan_lainnya.create', compact('data_instansi', 'donaturs'));
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
        $data = $req->except(['_method', '_token']);
        if ($instansi == 'yayasan') {
            $donatur = Donatur::find($req->donatur_id);
            $data['donatur_id'] = $req->donatur_id;
        } else {
            $donatur = $req->donatur;
        }
        $data['donatur'] = $donatur;
        $check = PemasukanLainnya::create($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        // jurnal
        $jurnal = new Jurnal([
            'instansi_id' => $check->instansi_id,
            'keterangan' => 'Pemasukan: ' . $check->jenis,
            'nominal' => $check->total,
            'akun_debit' => null,
            'akun_kredit' => null,
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
    public function show(PemasukanLainnya $pemasukanLainnya)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PemasukanLainnya  $pemasukanLainnya
     * @return \Illuminate\Http\Response
     */
    public function edit(PemasukanLainnya $pemasukanLainnya)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PemasukanLainnya  $pemasukanLainnya
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PemasukanLainnya $pemasukanLainnya)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PemasukanLainnya  $pemasukanLainnya
     * @return \Illuminate\Http\Response
     */
    public function destroy(PemasukanLainnya $pemasukanLainnya)
    {
        //
    }
}
