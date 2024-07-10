<?php

namespace App\Http\Controllers;

use App\Exports\JurnalsExport;
use App\Models\Akun;
use App\Models\HonorDokter;
use App\Models\Instansi;
use App\Models\Jurnal;
use App\Models\KartuPenyusutan;
use App\Models\KartuStok;
use App\Models\Operasional;
use App\Models\Outbond;
use App\Models\PemasukanLainnya;
use App\Models\PemasukanYayasan;
use App\Models\PembayaranSiswa;
use App\Models\PembelianAset;
use App\Models\PembelianAtk;
use App\Models\PengeluaranLainnya;
use App\Models\Penggajian;
use App\Models\PerbaikanAset;
use App\Models\Transport;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

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
        $akuns = Akun::where('instansi_id', $data_instansi->id)->get();
        $types = [ // list yang masuk jurnal
            PembelianAset::class,
            PembelianAtk::class,
            Penggajian::class,
            Outbond::class,
            PerbaikanAset::class,
            Operasional::class,
            Transport::class,
            HonorDokter::class,
            PemasukanLainnya::class,
            PengeluaranLainnya::class,
            KartuPenyusutan::class,
            PemasukanYayasan::class,
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
                            return $query->whereHas('supplier.instansi', function($query) use ($data_instansi) {
                                $query->where('id', $data_instansi->id);
                            });
                        });
                        $query->when($type === PembelianAtk::class, function($query) use ($data_instansi) { //pembelian atk
                            return $query->whereHas('supplier.instansi', function($query) use ($data_instansi) {
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
                        $query->when($type === Transport::class, function($query) use ($data_instansi) { //transport
                            return $query->where('instansi_id', $data_instansi->id);
                        });
                        $query->when($type === HonorDokter::class, function($query) use ($data_instansi) { //honor dokter
                            return $query->where('instansi_id', $data_instansi->id);
                        });
                        $query->when($type === PemasukanLainnya::class, function($query) use ($data_instansi) { //pemasukan lainnya
                            return $query->where('instansi_id', $data_instansi->id);
                        });
                        $query->when($type === PengeluaranLainnya::class, function($query) use ($data_instansi) { //pengeluaran lainnya
                            return $query->where('instansi_id', $data_instansi->id);
                        });
                        $query->when($type === KartuPenyusutan::class, function($query) use ($data_instansi) { //kartu penyusutan
                            return $query->where('instansi_id', $data_instansi->id);
                        });
                    })->get()
            );
        }
        $manualInput = Jurnal::with('debit', 'kredit')->where('instansi_id', $data_instansi->id)->whereNull('journable_type')->whereNull('journable_id')->orWhere('journable_type', KartuStok::class)->where('instansi_id', $data_instansi->id)->orWhere('journable_type', PembayaranSiswa::class)->where('instansi_id', $data_instansi->id)->get();
        $data = $data->merge($manualInput);
        $data = $data->sortBy('tanggal');
        $jumlah = $data->sum('nominal');
        return view('jurnal.index', compact('akuns', 'data', 'bulan', 'tahun', 'jumlah', 'data_instansi'));
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
    public function store(Request $req, $instansi)
    {
        // Validasi input
        $validator = Validator::make($req->all(), [
            'akun.*' => 'required',
            'tanggal' => 'required|date',
            'keterangan' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('fail', $validator->errors()->all());
        }

        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        if (!$data_instansi) {
            return redirect()->back()->with('fail', 'Instansi tidak ditemukan');
        }
        $data = $req->except(['_method', '_token']);
        $data['instansi_id'] = $data_instansi->id;

        DB::beginTransaction();
        try {
            foreach ($data['akun'] as $key => $akun) {
                Jurnal::create([
                    'instansi_id' => $data_instansi->id,
                    'journable_type' => $data['journable_type'] ?? null,
                    'journable_id' => $data['journable_id'] ?? null,
                    'keterangan' => $data['keterangan'],
                    'akun_debit' => isset($data['debit'][$key]) ? $akun : null,
                    'akun_kredit' => isset($data['kredit'][$key]) ? $akun : null,
                    'nominal' => $data['debit'][$key] ?? $data['kredit'][$key],
                    'tanggal' => $data['tanggal'],
                ]);
            }
            DB::commit();
            return redirect()->back()->with('success', 'Data berhasil ditambahkan');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->with('fail', 'Terjadi kesalahan: ' . $e->getMessage());
        }
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
            'nominal_debit.*' => 'nullable|integer',
            'nominal_kredit.*' => 'nullable|integer',
            'nama_akun.*' => 'required',
        ];
        
        $messages = [
            'id.*.required' => 'ID harus diisi.',
            'id.*.integer' => 'ID harus berupa bilangan bulat.',
            'nominal_debit.*.integer' => 'Nominal debit harus berupa bilangan bulat.',
            'nominal_kredit.*.integer' => 'Nominal kredit harus berupa bilangan bulat.',
            'nama_akun.*.required' => 'Akun harus diisi.',
        ];

        $validator = Validator::make($req->all(), $rules, $messages);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return redirect()->back()->withInput()->with('fail', $errors);
        } else {
            for ($i=0; $i < count($data['id']); $i++) { 
                $jurnal = Jurnal::find($data['id'][$i]);
                if(!$jurnal) return redirect()->back()->withInput()->with('fail', 'Jurnal tidak ditemukan');
                
                if(isset($data['nominal_debit'][$i])){
                    $jurnal->akun_debit = $data['nama_akun'][$i];
                }
                if(isset($data['nominal_kredit'][$i])){
                    $jurnal->akun_kredit = $data['nama_akun'][$i];
                }
                $check = $jurnal->update();
                if(!$check) return redirect()->back()->withInput()->with('fail', 'Gagal meyimpan data');
            }
            return redirect()->back()->with('success', 'Data berhasil ditambahkan');
        }
    }

    public function excel(Request $req, $instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $types = [ // list yang masuk jurnal
            PembelianAset::class,
            PembelianAtk::class,
            Penggajian::class,
            Outbond::class,
            PerbaikanAset::class,
            Operasional::class,
            Transport::class,
            HonorDokter::class,
            PemasukanLainnya::class,
            PembayaranSiswa::class,
            PengeluaranLainnya::class,
            KartuPenyusutan::class,
        ];
        $filterTahun = $req->tahun;
        $filterBulan = $req->bulan;
        $data = collect();
        foreach ($types as $type) {
            $data = $data->merge(
                Jurnal::with('debit', 'kredit')->where('journable_type', $type)
                    ->whereHasMorph('journable', [$type], function($query) use ($type, $data_instansi, $filterBulan, $filterTahun) {
                        if ($filterTahun) {
                            $query->whereYear('tanggal', $filterTahun);
                        }
                        if ($filterBulan) {
                            $query->whereMonth('tanggal', $filterBulan);
                        }
                        $query->when($type === PembelianAset::class, function($query) use ($data_instansi) { //pembelian aset
                            return $query->whereHas('supplier.instansi', function($query) use ($data_instansi) {
                                $query->where('id', $data_instansi->id);
                            });
                        });
                        $query->when($type === PembelianAtk::class, function($query) use ($data_instansi) { //pembelian atk
                            return $query->whereHas('supplier.instansi', function($query) use ($data_instansi) {
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
                        $query->when($type === Transport::class, function($query) use ($data_instansi) { //transport
                            return $query->where('instansi_id', $data_instansi->id);
                        });
                        $query->when($type === HonorDokter::class, function($query) use ($data_instansi) { //honor dokter
                            return $query->where('instansi_id', $data_instansi->id);
                        });
                        $query->when($type === PemasukanLainnya::class, function($query) use ($data_instansi) { //pemasukan lainnya
                            return $query->where('instansi_id', $data_instansi->id);
                        });
                        $query->when($type === PembayaranSiswa::class, function($query) use ($data_instansi) { //pembyaran siswa
                            return $query->where('instansi_id', $data_instansi->id);
                        });
                        $query->when($type === PengeluaranLainnya::class, function($query) use ($data_instansi) { //pengeluaran lainnya
                            return $query->where('instansi_id', $data_instansi->id);
                        });
                        $query->when($type === KartuPenyusutan::class, function($query) use ($data_instansi) { //kartu penyusutan
                            return $query->where('instansi_id', $data_instansi->id);
                        });
                    })->get()
            );
        }
        $manualInput = Jurnal::with('debit', 'kredit')->where('instansi_id', $data_instansi->id)->whereNull('journable_type')->whereNull('journable_id')->orWhere('journable_type', KartuStok::class)->where('instansi_id', $data_instansi->id)->get();
        $data = $data->merge($manualInput);
        $data = $data->sortBy('tanggal');

        return Excel::download(new JurnalsExport($data), 'Jurnal-'.$filterBulan.'-'.$filterTahun.'.xlsx');
    }

    public function pdf(Request $req, $instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $types = [ // list yang masuk jurnal
            PembelianAset::class,
            PembelianAtk::class,
            Penggajian::class,
            Outbond::class,
            PerbaikanAset::class,
            Operasional::class,
            Transport::class,
            HonorDokter::class,
            PemasukanLainnya::class,
            PembayaranSiswa::class,
            PengeluaranLainnya::class,
            KartuPenyusutan::class,
        ];
        $filterTahun = $req->tahun;
        $filterBulan = $req->bulan;
        $data = collect();
        foreach ($types as $type) {
            $data = $data->merge(
                Jurnal::with('debit', 'kredit')->where('journable_type', $type)
                    ->whereHasMorph('journable', [$type], function($query) use ($type, $data_instansi, $filterBulan, $filterTahun) {
                        if ($filterTahun) {
                            $query->whereYear('tanggal', $filterTahun);
                        }
                        if ($filterBulan) {
                            $query->whereMonth('tanggal', $filterBulan);
                        }
                        $query->when($type === PembelianAset::class, function($query) use ($data_instansi) { //pembelian aset
                            return $query->whereHas('supplier.instansi', function($query) use ($data_instansi) {
                                $query->where('id', $data_instansi->id);
                            });
                        });
                        $query->when($type === PembelianAtk::class, function($query) use ($data_instansi) { //pembelian atk
                            return $query->whereHas('supplier.instansi', function($query) use ($data_instansi) {
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
                        $query->when($type === Transport::class, function($query) use ($data_instansi) { //transport
                            return $query->where('instansi_id', $data_instansi->id);
                        });
                        $query->when($type === HonorDokter::class, function($query) use ($data_instansi) { //honor dokter
                            return $query->where('instansi_id', $data_instansi->id);
                        });
                        $query->when($type === PemasukanLainnya::class, function($query) use ($data_instansi) { //pemasukan lainnya
                            return $query->where('instansi_id', $data_instansi->id);
                        });
                        $query->when($type === PembayaranSiswa::class, function($query) use ($data_instansi) { //pembyaran siswa
                            return $query->where('instansi_id', $data_instansi->id);
                        });
                        $query->when($type === PengeluaranLainnya::class, function($query) use ($data_instansi) { //pengeluaran lainnya
                            return $query->where('instansi_id', $data_instansi->id);
                        });
                        $query->when($type === KartuPenyusutan::class, function($query) use ($data_instansi) { //kartu penyusutan
                            return $query->where('instansi_id', $data_instansi->id);
                        });
                    })->get()
            );
        }
        $dataBulan = [
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
        $manualInput = Jurnal::with('debit', 'kredit')->where('instansi_id', $data_instansi->id)->whereNull('journable_type')->whereNull('journable_id')->orWhere('journable_type', KartuStok::class)->where('instansi_id', $data_instansi->id)->get();
        $data = $data->merge($manualInput);
        $data = $data->sortBy('tanggal')->toArray();
        $totalNominal = collect($data)->sum('nominal');
        $bulan = $dataBulan[$req->bulan];
        $tahun = $req->tahun;
        $pdf = Pdf::loadView('jurnal.pdf', compact('data', 'totalNominal', 'bulan', 'tahun'));
        return $pdf->stream('Jurnal.pdf');
    }
}
