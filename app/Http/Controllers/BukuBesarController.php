<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\BukuBesar;
use App\Models\Jurnal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BukuBesarController extends Controller
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
        $tahun = Jurnal::all()->map(function ($jurnal) {
            return Carbon::parse($jurnal->tanggal)->year;
        })->unique()->values();
        $saldo_awal = 0;
        $saldo_akhir = 0;
        $akun = Akun::all();
        $getAkun = Akun::find($req->akun);

        $data = collect();
        if(isset($req->akun) && isset($req->tahun) && isset($req->bulan)){
            $data = Jurnal::orderBy('tanggal')
                ->where(function($query) use ($req) {
                    $query->where('akun_debit', $req->akun)
                        ->orWhere('akun_kredit', $req->akun);
                })
                ->whereYear('tanggal', $req->tahun)
                ->whereMonth('tanggal', $req->bulan)
                ->get();

            if($getAkun){
                $tanggal = Carbon::createFromFormat('Y-m', $req->tahun . '-' . $req->bulan)->startOfMonth();
    
                $tanggalSebelumnya = $tanggal->subMonth();
                $tahunSebelumnya = $tanggalSebelumnya->year;
                $bulanSebelumnya = $tanggalSebelumnya->format('m');
    
                $bukubesar = BukuBesar::where('akun_id', $req->akun)
                            ->whereYear('tanggal', $tahunSebelumnya)
                            ->whereMonth('tanggal', $bulanSebelumnya)
                            ->first();
                if($bukubesar){
                    $saldo_awal = $bukubesar->saldo_akhir;
                } else {
                    $saldo_awal = $getAkun->saldo_awal;
                }
                $temp_saldo = $saldo_awal;
                foreach ($data as $item) {
                    if($item->akun_kredit){
                        $temp_saldo -= $item->nominal;
                    } else if($item->akun_debit)
                        $temp_saldo += $item->nominal;
                }
                $saldo_akhir = $temp_saldo;
            }
        }
        return view('buku_besar.index', compact('bulan', 'akun', 'data', 'tahun', 'saldo_awal', 'saldo_akhir'));
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
     * @param  \App\Models\BukuBesar  $bukuBesar
     * @return \Illuminate\Http\Response
     */
    public function show(BukuBesar $bukuBesar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BukuBesar  $bukuBesar
     * @return \Illuminate\Http\Response
     */
    public function edit(BukuBesar $bukuBesar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BukuBesar  $bukuBesar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BukuBesar $bukuBesar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BukuBesar  $bukuBesar
     * @return \Illuminate\Http\Response
     */
    public function destroy(BukuBesar $bukuBesar)
    {
        //
    }

    public function save(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'akun' => 'required|exists:t_akun,id',
            'tahun' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'bulan' => ['required', 'regex:/^(0[1-9]|1[0-2])$/'],
            'saldo_awal' => 'required|numeric',
            'saldo_akhir' => 'required|numeric',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);

        // save data
        $data = $req->except(['_method', '_token']);
        $tanggal = Carbon::createFromFormat('Y-m', $data['tahun'] . '-' . $data['bulan'])->startOfMonth();
    
        $tanggalSebelumnya = $tanggal->subMonth();
        $tahunSebelumnya = $tanggalSebelumnya->year;
        $bulanSebelumnya = $tanggalSebelumnya->format('m');

        $bulan_sebelumnya = BukuBesar::where('akun_id', $data['akun'])
                    ->whereYear('tanggal', $tahunSebelumnya)
                    ->whereMonth('tanggal', $bulanSebelumnya)
                    ->first();

        if(empty($bulan_sebelumnya)) return redirect()->back()->withInput()->with('fail', 'Bulan sebelumnya belum dibuat');
        $check = BukuBesar::updateOrCreate(
            [
                'akun_id' => $data['akun'],
                'tanggal' => $data['tahun'] . '-' . str_pad($data['bulan'], 2, '0', STR_PAD_LEFT) . '-01'
            ],
            [
                'saldo_awal' => $data['saldo_awal'],
                'saldo_akhir' => $data['saldo_akhir'],
            ]
        );

        if(!$check) return redirect()->back()->withInput()->with('fail', 'Gagal menyimpan data');
    
        $message = $check->wasRecentlyCreated ? 'Data buku besar berhasil dibuat.' : 'Data buku besar berhasil diperbarui.';
        return redirect()->back()->with('success', $message);
    }
}
