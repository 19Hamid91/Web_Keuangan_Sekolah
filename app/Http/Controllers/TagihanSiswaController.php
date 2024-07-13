<?php

namespace App\Http\Controllers;

use App\Mail\TagihanSiswaEmail;
use App\Models\Instansi;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\TagihanSiswa;
use App\Models\TahunAjaran;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class TagihanSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $tagihan_siswa = $this->getDistinctTingkatWithAllColumns($data_instansi->id);
        return view('tagihan_siswa.index', compact('tagihan_siswa', 'data_instansi'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $tahun_ajaran = TahunAjaran::where('status', 'AKTIF')->first();
        $tingkat = Kelas::where('instansi_id', $data_instansi->id)->pluck('tingkat')->unique();
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
        return view('tagihan_siswa.create', compact('data_instansi', 'tahun_ajaran', 'tingkat', 'bulan'));
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
            'instansi_id' => 'required|exists:t_instansi,id',
            'tahun_ajaran_id' => 'required|exists:t_thnajaran,id',
            'tingkat' => 'required|exists:t_kelas,tingkat',
            'jenis_tagihan.*' => 'required',
            'mulai_bayar.*' => 'required|date',
            'akhir_bayar.*' => 'required|date',
            'jumlah_pembayaran.*' => 'required',
            'nominal.*' => 'required|numeric',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('fail', $validator->errors()->all());
        }

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

        $isDuplicate = TagihanSiswa::where('instansi_id', $req->instansi_id)
            ->where('tahun_ajaran_id', $req->tahun_ajaran_id)
            ->where('tingkat', $req->tingkat)
            ->whereIn('jenis_tagihan', $req->jenis_tagihan)
            ->exists();

        if ($isDuplicate) {
            return redirect()->back()->withInput()->with('fail', 'Tagihan sudah ada');
        }

        DB::beginTransaction();

        try {
            $data = $req->except(['_method', '_token']);
            
            for ($i = 0; $i < count($data['jenis_tagihan']); $i++) {
                $jenisTagihan = $data['jenis_tagihan'][$i];
                $jumlahPembayaran = $data['jumlah_pembayaran'][$i];
                $nominal = $data['nominal'][$i];
                $mulaiBayar = $data['mulai_bayar'][$i];
                $akhirBayar = $data['akhir_bayar'][$i];
                $mulaiBayarDate = new DateTime($mulaiBayar);
                $akhirBayarDate = new DateTime($akhirBayar);

                if ($jumlahPembayaran != 'Per Bulan') {
                    $monthNumber = $mulaiBayarDate->format('m');
                    $namaBulan = $bulan[$monthNumber];

                    TagihanSiswa::create([
                        'instansi_id' => $data['instansi_id'],
                        'tahun_ajaran_id' => $data['tahun_ajaran_id'],
                        'tingkat' => $data['tingkat'],
                        'periode' =>  $namaBulan,
                        'jenis_tagihan' => $jenisTagihan,
                        'mulai_bayar' => $mulaiBayar,
                        'akhir_bayar' => $akhirBayar,
                        'jumlah_pembayaran' => $jumlahPembayaran,
                        'nominal' => $nominal,
                    ]);
                } else {
                    for ($monthOffset = 0; $monthOffset < 12; $monthOffset++) {
                        $newMulai = (clone $mulaiBayarDate)->modify("+$monthOffset months");
                        $newAkhir = (clone $newMulai)->modify('last day of this month');
                    
                        $monthNumber = $newMulai->format('m');
                        $namaBulan = $bulan[$monthNumber];
                        $tahun = $newMulai->format('Y');

                        $monthNumber = $newAkhir->format('m');
                        $namaBulan = $bulan[$monthNumber];
                        $tahun = $newAkhir->format('Y');
                        $periode = $namaBulan . ' ' . $tahun;
                    
                        $newMulaiBayar = $newMulai->format('Y-m-d');
                        $newAkhirBayar = $newAkhir->format('Y-m-d');
                    
                        TagihanSiswa::create([
                            'instansi_id' => $data['instansi_id'],
                            'tahun_ajaran_id' => $data['tahun_ajaran_id'],
                            'tingkat' => $data['tingkat'],
                            'periode' =>  $periode,
                            'jenis_tagihan' => $jenisTagihan,
                            'mulai_bayar' => $newMulaiBayar,
                            'akhir_bayar' => $newAkhirBayar,
                            'jumlah_pembayaran' => $jumlahPembayaran,
                            'nominal' => $nominal,
                        ]);
                    }                    
                }
            }

            DB::commit();
            return redirect()->route('tagihan_siswa.index', ['instansi' => $instansi])->with('success', 'Data berhasil ditambahkan');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->with('fail', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TagihanSiswa  $tagihanSiswa
     * @return \Illuminate\Http\Response
     */
    public function show($instansi, $id)
    {
        $data = $this->getTagihanSiswaByTingkat($id);
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $tahun_ajaran = TahunAjaran::where('status', 'AKTIF')->first();
        $tingkat = Kelas::where('instansi_id', $data_instansi->id)->pluck('tingkat');
        return view('tagihan_siswa.show', compact('data_instansi', 'tahun_ajaran', 'tingkat', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TagihanSiswa  $tagihanSiswa
     * @return \Illuminate\Http\Response
     */
    public function edit($instansi, $id)
    {
        $data = $this->getTagihanSiswaByTingkat($id);
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $tahun_ajaran = TahunAjaran::where('status', 'AKTIF')->first();
        $tingkat = Kelas::where('instansi_id', $data_instansi->id)->pluck('tingkat');
        return view('tagihan_siswa.edit', compact('data_instansi', 'tahun_ajaran', 'tingkat', 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TagihanSiswa  $tagihanSiswa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $instansi, $id)
    {
        // Validasi input
        $validator = Validator::make($req->all(), [
            'instansi_id' => 'required|exists:t_instansi,id',
            'tahun_ajaran_id' => 'required|exists:t_thnajaran,id',
            'tingkat' => 'required|exists:t_kelas,tingkat',
            'jenis_tagihan.*' => 'required',
            'mulai_bayar.*' => 'required|date',
            'akhir_bayar.*' => 'required|date',
            'jumlah_pembayaran.*' => 'required',
            'nominal.*' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('fail', $validator->errors()->all());
        }

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

        DB::beginTransaction();

        try {
            $data = $req->except(['_method', '_token']);

            for ($i = 0; $i < count($data['jenis_tagihan']); $i++) {
                $jenisTagihan = $data['jenis_tagihan'][$i];
                $jumlahPembayaran = $data['jumlah_pembayaran'][$i];
                $nominal = $data['nominal'][$i];
                $mulaiBayar = $data['mulai_bayar'][$i];
                $akhirBayar = $data['akhir_bayar'][$i];
                $mulaiBayarDate = new DateTime($mulaiBayar);
                $akhirBayarDate = new DateTime($akhirBayar);

                if ($jumlahPembayaran != 'Per Bulan') {
                    $monthNumber = $mulaiBayarDate->format('m');
                    $namaBulan = $bulan[$monthNumber];

                    TagihanSiswa::updateOrCreate(
                        [
                            'instansi_id' => $data['instansi_id'],
                            'tahun_ajaran_id' => $data['tahun_ajaran_id'],
                            'tingkat' => $data['tingkat'],
                            'jenis_tagihan' => $jenisTagihan,
                        ],
                        [
                            'periode' => $namaBulan,
                            'mulai_bayar' => $mulaiBayar,
                            'akhir_bayar' => $akhirBayar,
                            'jumlah_pembayaran' => $jumlahPembayaran,
                            'nominal' => $nominal,
                        ]
                    );
                } else {
                    for ($monthOffset = 0; $monthOffset < 12; $monthOffset++) {
                        $newMulai = (clone $mulaiBayarDate)->modify("+$monthOffset months");
                        $newAkhir = (clone $akhirBayarDate)->modify("+$monthOffset months");
                    
                        $monthNumber = $newMulai->format('m');
                        $namaBulan = $bulan[$monthNumber];
                        $tahun = $newMulai->format('Y');

                        $monthNumber = $newAkhir->format('m');
                        $namaBulan = $bulan[$monthNumber];
                        $tahun = $newAkhir->format('Y');
                        $periode = $namaBulan . ' ' . $tahun;
                    
                        $newMulaiBayar = $newMulai->format('Y-m-d');
                        $newAkhirBayar = $newAkhir->format('Y-m-d');
                    
                        TagihanSiswa::updateOrCreate(
                            [
                                'instansi_id' => $data['instansi_id'],
                                'tahun_ajaran_id' => $data['tahun_ajaran_id'],
                                'tingkat' => $data['tingkat'],
                                'jenis_tagihan' => $jenisTagihan,
                                'periode' => $periode,
                            ],
                            [
                                'mulai_bayar' => $newMulaiBayar,
                                'akhir_bayar' => $newAkhirBayar,
                                'jumlah_pembayaran' => $jumlahPembayaran,
                                'nominal' => $nominal,
                            ]
                        );
                    }                    
                }
            }

            DB::commit();
            return redirect()->route('tagihan_siswa.index', ['instansi' => $instansi])->with('success', 'Data berhasil diperbarui');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->with('fail', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TagihanSiswa  $tagihanSiswa
     * @return \Illuminate\Http\Response
     */
    public function destroy($instansi, $tingkat)
    {
        try {
            $tagihanSiswa = TagihanSiswa::where('tingkat', $tingkat)->delete();
            
            if ($tagihanSiswa) {
                return redirect()->route('tagihan_siswa.index', ['instansi' => $instansi])->with('success', 'Data berhasil dihapus');
            } else {
                return redirect()->back()->with('fail', 'Data tidak ditemukan atau gagal menghapus data');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('fail', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function email()
    {
        try {
            $data = TagihanSiswa::whereMonth('mulai_bayar', date('m'))
                                ->whereYear('mulai_bayar', date('Y'))
                                ->get();

            if ($data->isEmpty()) {
                return 'Tidak ada tagihan untuk bulan ini.';
            }

            $siswa = Siswa::with('kelas')->where('status', 'AKTIF')->get();

            foreach ($siswa as $student) {
                $payments = $student->pembayaran->whereIn('tagihan_siswa_id', $data->pluck('id'));

                $paidBills = collect();

                foreach ($payments as $payment) {
                    $tagihanId = $payment->tagihan_siswa_id;
                    $totalPaid = $payment->total;

                    if (!$paidBills->has($tagihanId)) {
                        $paidBills->put($tagihanId, $totalPaid);
                    } else {
                        $paidBills[$tagihanId] += $totalPaid;
                    }
                }

                $unpaidBills = $data->filter(function ($tagihan) use ($paidBills, $student) {
                    if ($tagihan->instansi_id != $student->instansi_id) {
                        return false;
                    }
                    if ($tagihan->tingkat != $student->kelas->tingkat) {
                        return false;
                    }

                    $tagihanId = $tagihan->id;
                    $nominalTagihan = $tagihan->nominal;
                    $totalPaid = $paidBills->get($tagihanId, 0);

                    return $totalPaid < $nominalTagihan;
                });

                if ($unpaidBills->isNotEmpty()) {
                    $bills = $unpaidBills->map(function($tagihan) use ($student, $paidBills) {
                        $tagihanId = $tagihan->id;
                        $nominalTagihan = $tagihan->nominal;
                        $totalPaid = $paidBills->get($tagihanId, 0);
                        $remainingAmount = $nominalTagihan - $totalPaid;

                        return [
                            'type' => $tagihan->jenis_tagihan,
                            'amount' => $remainingAmount,
                            'due_date' => $tagihan->akhir_bayar
                        ];
                    })->toArray();

                    $totalAmount = array_sum(array_column($bills, 'amount'));

                    if (!$student->email_wali_siswa) {
                        Log::warning('Siswa tidak memiliki email wali siswa:', ['student' => $student->nama]);
                        continue;
                    }

                    Mail::to($student->email_wali_siswa)->send(new TagihanSiswaEmail($student->nama, $bills, $totalAmount));
                    Log::info('Email tagihan dikirim ke:', ['email' => $student->email_wali_siswa]);
                }
            }

            return redirect()->back()->with('success', 'Pemberitahuan telah dikirim');
        } catch (\Exception $e) {
            Log::error('Error saat mengirim email tagihan:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('fail', 'Gagal mengirim pemberitahuan');
        }
    }


    public function getDistinctTingkatWithAllColumns($instansiId)
    {
        $distinctIds = DB::table('t_kelas as k1')
        ->select(DB::raw('MIN(k1.id) as id'))
        ->where('k1.instansi_id', $instansiId)
        ->groupBy('k1.tingkat')
        ->pluck('id');

        $kelasDistinctTingkat = Kelas::with('tagihan')
            ->whereIn('id', $distinctIds)
            ->get();

        return $kelasDistinctTingkat;
    }

    public function getTagihanSiswaByTingkat($tingkat)
    {
        $distinctTagihanIds = DB::table('t_tagihan_siswa')
            ->select(DB::raw('MIN(id) as id'))
            ->where('tingkat', $tingkat)
            ->groupBy('jenis_tagihan')
            ->pluck('id');

        $tagihanSiswa = TagihanSiswa::whereIn('id', $distinctTagihanIds)
            ->get();

        return $tagihanSiswa;
    }
}
