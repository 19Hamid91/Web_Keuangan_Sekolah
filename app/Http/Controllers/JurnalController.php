<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\Instansi;
use App\Models\Jurnal;
use App\Models\Operasional;
use App\Models\Outbond;
use App\Models\PemasukanLainnya;
use App\Models\PembayaranSiswa;
use App\Models\PembelianAset;
use App\Models\PembelianAtk;
use App\Models\Penggajian;
use App\Models\PerbaikanAset;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JurnalController extends Controller
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
        $akuns = Akun::all();
        $types = [ // list yang masuk jurnal
            PembelianAset::class,
            PembelianAtk::class,
            Penggajian::class,
            Outbond::class,
            PerbaikanAset::class,
            Operasional::class,
            PemasukanLainnya::class,
            PembayaranSiswa::class,
        ];
        $tahun = Jurnal::all()->map(function ($jurnal) {
            return Carbon::parse($jurnal->tanggal)->year;
        })->unique()->values();
        $filterTahun = $req->tahun;
        $filterBulan = $req->bulan;
        $data = collect();
        foreach ($types as $type) {
            $data = $data->merge(
                Jurnal::where('journable_type', $type)
                    ->whereHasMorph('journable', [$type], function($query) use ($type, $data_instansi, $filterBulan, $filterTahun) {
                        if ($filterTahun) {
                            $query->whereYear('tanggal', $filterTahun);
                        }
                        if ($filterBulan) {
                            $query->whereMonth('tanggal', $filterBulan);
                        }
                        $query->when($type === PembelianAset::class, function($query) use ($data_instansi) { //pembelian aset
                            return $query->whereHas('aset.instansi', function($query) use ($data_instansi) {
                                $query->where('id', $data_instansi->id);
                            });
                        });
                        $query->when($type === PembelianAtk::class, function($query) use ($data_instansi) { //pembelian atk
                            return $query->whereHas('atk.instansi', function($query) use ($data_instansi) {
                                $query->where('id', $data_instansi->id);
                            });
                        });
                        $query->when($type === Penggajian::class, function($query) use ($data_instansi) { //penggajian
                            return $query->whereHas('pegawai.instansi', function($query) use ($data_instansi) {
                                $query->where('id', $data_instansi->id);
                            });
                        });
                        $query->when($type === Outbond::class, function($query) use ($data_instansi) { //outbond
                            return $query->where('instansi_id', $data_instansi->id);
                        });
                        $query->when($type === PerbaikanAset::class, function($query) use ($data_instansi) { //perbaikan
                            return $query->where('instansi_id', $data_instansi->id);
                        });
                        $query->when($type === Operasional::class, function($query) use ($data_instansi) { //operasional
                            return $query->where('instansi_id', $data_instansi->id);
                        });
                        $query->when($type === PemasukanLainnya::class, function($query) use ($data_instansi) { //operasional
                            return $query->where('instansi_id', $data_instansi->id);
                        });
                        $query->when($type === PembayaranSiswa::class, function($query) use ($data_instansi) { //operasional
                            return $query->where('instansi_id', $data_instansi->id);
                        });
                    })->get()
            );
        }
        $data = $data->sortBy('tanggal');
        return view('jurnal.index', compact('akuns', 'data', 'bulan', 'tahun'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Jurnal  $jurnal
     * @return \Illuminate\Http\Response
     */
    public function show(Jurnal $jurnal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Jurnal  $jurnal
     * @return \Illuminate\Http\Response
     */
    public function edit(Jurnal $jurnal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Jurnal  $jurnal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Jurnal $jurnal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Jurnal  $jurnal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jurnal $jurnal)
    {
        //
    }

    public function save(Request $req)
    {
        $data = $req->except(['_method', '_token']);

        $rules = [
            'id.*' => 'required|integer',
            'akun_debit.*' => 'nullable|integer',
            'akun_kredit.*' => 'nullable|integer',
        ];
        
        $messages = [
            'id.*.required' => 'ID harus diisi.',
            'id.*.integer' => 'ID harus berupa bilangan bulat.',
            'akun_debit.*.integer' => 'Akun debit harus berupa bilangan bulat.',
            'akun_kredit.*.integer' => 'Akun kredit harus berupa bilangan bulat.',
        ];

        $validator = Validator::make($req->all(), $rules, $messages);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return redirect()->back()->withInput()->with('fail', $errors);
        } else {
            for ($i=0; $i < count($data['id']); $i++) { 
                $jurnal = Jurnal::find($data['id'][$i]);
                if(!$jurnal) return redirect()->back()->withInput()->with('fail', 'Jurnal tidak ditemukan');
                
                if(isset($data['akun_debit'][$i])){
                    $jurnal->akun_debit = $data['akun_debit'][$i];
                }
                if(isset($data['akun_kredit'][$i])){
                    $jurnal->akun_kredit = $data['akun_kredit'][$i];
                }
                $check = $jurnal->update();
                if(!$check) return redirect()->back()->withInput()->with('fail', 'Gagal meyimpan data');
            }
            return redirect()->back()->with('success', 'Data berhasil ditambahkan');
        }
    }
}
