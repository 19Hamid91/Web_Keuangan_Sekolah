<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\Aset;
use App\Models\Biro;
use App\Models\HonorDokter;
use App\Models\Instansi;
use App\Models\Jurnal;
use App\Models\Operasional;
use App\Models\Outbond;
use App\Models\Pegawai;
use App\Models\PengeluaranLainnya;
use App\Models\Pengurus;
use App\Models\PerbaikanAset;
use App\Models\Teknisi;
use App\Models\Transport;
use App\Models\Utilitas;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Constraint\Operator;
use Symfony\Component\Console\Output\Output;

class PengeluaranLainnyaController extends Controller
{
    public function index($instansi)
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
        $tahunHonorDokter = HonorDokter::all()->map(function ($item) {
            return Carbon::parse($item->tanggal)->year;
        });
        if ($tahunHonorDokter->isEmpty()) {
            $tahunHonorDokter = collect([date('Y')]);
        }
        $tahunTransport = Transport::all()->map(function ($item) {
            return Carbon::parse($item->tanggal)->year;
        });
        if ($tahunTransport->isEmpty()) {
            $tahunTransport = collect([date('Y')]);
        }
        $tahun = $tahunHonorDokter->merge($tahunTransport)->unique()->sort()->values();
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $akuns = Akun::where('instansi_id', $data_instansi->id)->get();
        return view('pengeluaran_lainnya.index', compact('data_instansi', 'bulan', 'tahun', 'akuns'));
    }

    public function create($instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $teknisi = Teknisi::where('instansi_id', $data_instansi->id)->get();
        $aset = Aset::where('instansi_id', $data_instansi->id)->get();
        $biro = Biro::all();
        $karyawan = Pegawai::where('instansi_id', $data_instansi->id)->get();
        $utilitas = Utilitas::all();
        $pengurus = Pengurus::all();
        $akuns = Akun::where('instansi_id', $data_instansi->id)->get();
        return view('pengeluaran_lainnya.create', compact('data_instansi', 'teknisi', 'aset', 'biro', 'karyawan', 'akuns', 'utilitas', 'pengurus'));
    }

    public function store(Request $req, $instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $isPerbaikan = $req->has('teknisi_id');
        $isOutbond = $req->has('biro_id');
        $isOperasional = $req->has('karyawan_id');

        if (($isPerbaikan && $isOutbond) || ($isPerbaikan && $isOperasional) || ($isOutbond && $isOperasional)) {
            return redirect()->back()->withInput()->with('fail', 'Hanya satu jenis form yang boleh diisi.');
        }

        if ($req->jenis_pengeluaran == 'Perbaikan Aset') {
            $validator = Validator::make($req->all(), [
                'teknisi_id' => 'required|exists:t_teknisi,id',
                'aset_id' => 'required|exists:t_aset,id',
                'tanggal' => 'required|date',
                'jenis' => 'required|string',
                'harga' => 'required|numeric',
            ]);
        } elseif ($req->jenis_pengeluaran == 'Outbond') {
            $validator = Validator::make($req->all(), [
                'biro_id' => 'required|exists:t_biro,id',
                'tanggal_pembayaran' => 'required|date',
                'harga_outbond' => 'required|numeric',
                'tanggal_outbond' => 'required|date',
                'tempat_outbond' => 'required|string',
            ]);
        } elseif ($req->jenis_pengeluaran == 'Operasional') {
            $validator = Validator::make($req->all(), [
                'jenis' => 'required|string',
                'tanggal_pembayaran' => 'required|date',
                'jumlah_tagihan' => 'required|numeric',
                'keterangan' => 'required',
            ]);
            $validator->sometimes('karyawan_id', 'required|exists:t_utilitas,id', function ($q) use($instansi) {
                return $instansi === 'yayasan';
            });
            $validator->sometimes('karyawan_id', 'required|exists:t_gurukaryawan,id', function ($q) use($instansi) {
                return $instansi !== 'yayasan';
            });
        } elseif($req->jenis_pengeluaran == 'Transport') {
            $validator = Validator::make($req->all(), [
                'pengurus_id' => 'required|exists:t_pengurus,id',
                'tanggal' => 'required|date',
                'nominal' => 'required|numeric',
                'keterangan' => 'required',
            ]);
        } elseif($req->jenis_pengeluaran == 'Honor Dokter') {
            $validator = Validator::make($req->all(), [
                'pengurus_id' => 'required|exists:t_pengurus,id',
                'tanggal' => 'required|date',
                'total_jam_kerja' => 'required|numeric',
                'honor_harian' => 'required|numeric',
                'total_honor' => 'required|numeric',
                'keterangan' => 'required',
            ]);
        } elseif($req->jenis_pengeluaran == 'Lainnya') {
            $validator = Validator::make($req->all(), [
                'nama' => 'required|string',
                'tanggal' => 'required|date',
                'nominal' => 'required|numeric',
                'keterangan' => 'required',
            ]);
        }
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);

        $data = $req->except(['_method', '_token']);

        // file
        if ($req->hasFile('file')) {
            $file = $req->file('file');
            $jenis_pengeluaran = str_replace(' ', '-', $req->jenis_pengeluaran);
            $fileName = $jenis_pengeluaran . '_' . date('YmdHis') . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('Bukti_Pengeluaran', $fileName, 'public');
            $data['file'] = $filePath;
        }

        // save data
        $data_instansi = instansi::where('nama_instansi', $instansi)->first();
        if ($req->jenis_pengeluaran == 'Perbaikan Aset') {
            $check = PerbaikanAset::create($data);
            $type = PerbaikanAset::class; 
            // jurnal
            $akun = Akun::where('instansi_id', $data_instansi->id)->where('nama', 'LIKE', '%Perbaikan%')->where('jenis', 'BEBAN')->first();
            // $jurnal = new Jurnal([
            //     'instansi_id' => $data_instansi->id,
            //     'keterangan' => 'Perbaikan aset: ' . $check->aset->nama_aset,
            //     'nominal' => $check->harga,
            //     'akun_debit' => $akun->id,
            //     'akun_kredit' => $data['akun_id'],
            //     'tanggal' => $check->tanggal,
            // ]);
            // $check->journals()->save($jurnal);
        } elseif ($req->jenis_pengeluaran == 'Outbond') {
            $check = Outbond::create($data);
            $type = Outbond::class; 
            // jurnal
            $akun = Akun::where('instansi_id', $data_instansi->id)->where('nama', 'LIKE', '%Outbond%')->where('jenis', 'BEBAN')->first();
            // $jurnal = new Jurnal([
            //     'instansi_id' => $data_instansi->id,
            //     'keterangan' => 'Pengeluaran Outbond ' . formatTanggal($check->tanggal_outbond),
            //     'nominal' => $check->harga_outbond,
            //     'akun_debit' =>  $akun->id,
            //     'akun_kredit' => $data['akun_id'],
            //     'tanggal' => $check->tanggal_pembayaran,
            // ]);
            // $check->journals()->save($jurnal);
        } elseif ($req->jenis_pengeluaran == 'Operasional') {
            $check = Operasional::create($data);
            $type = Operasional::class; 
            // jurnal
            if($instansi == 'yayasan'){
                $akun = Akun::where('instansi_id', $data_instansi->id)->where('nama', 'LIKE', '%'.$check->jenis.'%')->where('jenis', 'BEBAN')->first();
            } else {
                $akun = Akun::where('instansi_id', $data_instansi->id)->where('nama', 'LIKE', '%Operasional Sekolah%')->where('jenis', 'BEBAN')->first();
            }
            // $jurnal = new Jurnal([
            //     'instansi_id' => $data_instansi->id,
            //     'keterangan' => 'Pengeluaran Operasional: ' . $check->jenis,
            //     'nominal' => $check->jumlah_tagihan,
            //     'akun_debit' =>  $akun->id,
            //     'akun_kredit' => $data['akun_id'],
            //     'tanggal' => $check->tanggal_pembayaran,
            // ]);
            // $check->journals()->save($jurnal);
        } elseif ($req->jenis_pengeluaran == 'Transport') {
            $check = Transport::create($data);
            $type = Transport::class; 
            // jurnal
            $akun = Akun::where('instansi_id', $data_instansi->id)->where('nama', 'LIKE', '%Transport%')->where('jenis', 'BEBAN')->first();
            // $jurnal = new Jurnal([
            //     'instansi_id' => $data_instansi->id,
            //     'keterangan' => 'Pengeluaran Transport: ' . $check->pengurus->nama_penguruss,
            //     'nominal' => $check->nominal,
            //     'akun_debit' =>  $akun->id,
            //     'akun_kredit' => $data['akun_id'],
            //     'tanggal' => $check->tanggal,
            // ]);
            // $check->journals()->save($jurnal);
        } elseif ($req->jenis_pengeluaran == 'Honor Dokter') {
            $check = HonorDokter::create($data);
            $type = HonorDokter::class; 
            // jurnal
            $akun = Akun::where('instansi_id', $data_instansi->id)->where('nama', 'LIKE', '%Honor Dokter%')->where('jenis', 'BEBAN')->first();
            // $jurnal = new Jurnal([
            //     'instansi_id' => $data_instansi->id,
            //     'keterangan' => 'Pengeluaran Lainnya: ' . $check->jenis_pengeluaran,
            //     'nominal' => $check->total_honor,
            //     'akun_debit' =>  $akun->id,
            //     'akun_kredit' => $data['akun_id'],
            //     'tanggal' => $check->tanggal,
            // ]);
            // $check->journals()->save($jurnal);
        } else {
            $check = PengeluaranLainnya::create($data);
            $type = PengeluaranLainnya::class; 
            // jurnal
            $akun = Akun::where('instansi_id', $data_instansi->id)->where('nama', 'LIKE', '%Biaya Lainnya%')->where('jenis', 'BEBAN')->first();
            // $jurnal = new Jurnal([
            //     'instansi_id' => $data_instansi->id,
            //     'keterangan' => 'Pengeluaran Lainnya: ' . $check->nama,
            //     'nominal' => $check->nominal,
            //     'akun_debit' =>  $akun->id,
            //     'akun_kredit' => $data['akun_id'],
            //     'tanggal' => $check->tanggal,
            // ]);
            // $check->journals()->save($jurnal);
        }
        // create akun
        if($req->jenis_pengeluaran != 'Honor Dokter' && $req->jenis_pengeluaran != 'Transport'){
            for ($i = 0; $i < count($data['akun']); $i++) {
                $this->createJurnal('Pemasukan Lainnya', $data['akun'][$i], $data['debit'][$i], $data['kredit'][$i], $data_instansi->id , now(), $type, $check->id);
            }
        }
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        return redirect()->route('pengeluaran_lainnya.index', ['instansi' => $instansi])->with('success', 'Data berhasil ditambahkan');
    }

    public function show($instansi, $pengeluaran_lainnya, $id)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        switch ($pengeluaran_lainnya) {
            case 'Perbaikan Aset':
                $aset = Aset::where('instansi_id', $data_instansi->id)->get();
                $teknisi = Teknisi::where('instansi_id', $data_instansi->id)->get();
                $data = PerbaikanAset::find($id);
                return view('pengeluaran_lainnya.show', compact('pengeluaran_lainnya', 'data_instansi', 'aset', 'teknisi', 'data'));
                break;
            case 'Outbond':
                $biro = Biro::all();
                $data = Outbond::find($id);
                return view('pengeluaran_lainnya.show', compact('pengeluaran_lainnya', 'biro', 'data', 'data_instansi'));
                break;
            case 'Operasional':
                $karyawan = Pegawai::where('instansi_id', $data_instansi->id)->get();
                $utilitas = Utilitas::all();
                $data = Operasional::find($id);
                return view('pengeluaran_lainnya.show', compact('pengeluaran_lainnya', 'karyawan', 'data', 'data_instansi', 'utilitas'));
                break;
            case 'Transport':
                $pengurus = Pengurus::where('instansi_id', $data_instansi->id)->get();
                $data = Transport::find($id);
                return view('pengeluaran_lainnya.show', compact('pengeluaran_lainnya', 'pengurus', 'data', 'data_instansi'));
                break;
            case 'Honor Dokter':
                $pengurus = Pengurus::where('instansi_id', $data_instansi->id)->get();
                $data = HonorDokter::find($id);
                return view('pengeluaran_lainnya.show', compact('pengeluaran_lainnya', 'pengurus', 'data', 'data_instansi'));
                break;
            case 'Lainnya':
                $data = PengeluaranLainnya::find($id);
                return view('pengeluaran_lainnya.show', compact('pengeluaran_lainnya', 'data', 'data_instansi'));
                break;
            default:
                return redirect()->back()->withInput()->with('fail', 'Jenis tidak terdaftar');
                break;
        }
        
    }

    public function edit($instansi, $pengeluaran_lainnya, $id)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        switch ($pengeluaran_lainnya) {
            case 'Perbaikan Aset':
                $aset = Aset::where('instansi_id', $data_instansi->id)->get();
                $teknisi = Teknisi::where('instansi_id', $data_instansi->id)->get();
                $data = PerbaikanAset::find($id);
                return view('pengeluaran_lainnya.edit', compact('pengeluaran_lainnya', 'data_instansi', 'aset', 'teknisi', 'data'));
                break;
            case 'Outbond':
                $biro = Biro::all();
                $data = Outbond::find($id);
                return view('pengeluaran_lainnya.edit', compact('pengeluaran_lainnya', 'biro', 'data', 'data_instansi'));
                break;
            case 'Operasional':
                $karyawan = Pegawai::where('instansi_id', $data_instansi->id)->get();
                $utilitas = Utilitas::all();
                $data = Operasional::find($id);
                return view('pengeluaran_lainnya.edit', compact('pengeluaran_lainnya', 'karyawan', 'data', 'data_instansi', 'utilitas'));
                break;
            case 'Transport':
                $pengurus = Pengurus::where('instansi_id', $data_instansi->id)->get();
                $data = Transport::find($id);
                return view('pengeluaran_lainnya.edit', compact('pengeluaran_lainnya', 'pengurus', 'data', 'data_instansi'));
                break;
            case 'Honor Dokter':
                $pengurus = Pengurus::where('instansi_id', $data_instansi->id)->get();
                $data = HonorDokter::find($id);
                return view('pengeluaran_lainnya.edit', compact('pengeluaran_lainnya', 'pengurus', 'data', 'data_instansi'));
                break;
            case 'Lainnya':
                $data = PengeluaranLainnya::find($id);
                return view('pengeluaran_lainnya.edit', compact('pengeluaran_lainnya', 'data', 'data_instansi'));
                break;
            default:
                return redirect()->back()->withInput()->with('fail', 'Jenis tidak terdaftar');
                break;
        }
    }

    public function update(Request $req, $instansi, $pengeluaran_lainnya, $id)
    {
        if (!in_array($pengeluaran_lainnya, ['Perbaikan Aset', 'Outbond', 'Operasional', 'Transport', 'Honor Dokter', 'Lainnya'])) {
            return redirect()->back()->withInput()->with('fail', 'Hanya satu jenis form yang boleh diisi.');
        }
        if ($pengeluaran_lainnya == 'Perbaikan Aset') {
            $validator = Validator::make($req->all(), [
                'teknisi_id' => 'required|exists:t_teknisi,id',
                'aset_id' => 'required|exists:t_aset,id',
                'tanggal' => 'required|date',
                'jenis' => 'required|string',
                'harga' => 'required|numeric',
            ]);
        } elseif ($pengeluaran_lainnya == 'Outbond') {
            $validator = Validator::make($req->all(), [
                'biro_id' => 'required|exists:t_biro,id',
                'tanggal_pembayaran' => 'required|date',
                'harga_outbond' => 'required|numeric',
                'tanggal_outbond' => 'required|date',
                'tempat_outbond' => 'required|string',
            ]);
        } elseif ($pengeluaran_lainnya == 'Operasional') {
            $validator = Validator::make($req->all(), [
                'jenis' => 'required|string',
                'tanggal_pembayaran' => 'required|date',
                'jumlah_tagihan' => 'required|numeric',
                'keterangan' => 'required',
            ]);
            $validator->sometimes('karyawan_id', 'required|exists:t_utilitas,id', function ($q) use($instansi) {
                return $instansi === 'yayasan';
            });
            $validator->sometimes('karyawan_id', 'required|exists:t_gurukaryawan,id', function ($q) use($instansi) {
                return $instansi !== 'yayasan';
            });
        } elseif ($pengeluaran_lainnya == 'Transport') {
            $validator = Validator::make($req->all(), [
                'pengurus_id' => 'required|exists:t_pengurus,id',
                'tanggal' => 'required|date',
                'nominal' => 'required|numeric',
                'keterangan' => 'required',
            ]);
        } elseif ($pengeluaran_lainnya == 'Honor Dokter') {
            $validator = Validator::make($req->all(), [
                'pengurus_id' => 'required|exists:t_pengurus,id',
                'tanggal' => 'required|date',
                'total_jam_kerja' => 'required|numeric',
                'honor_harian' => 'required|numeric',
                'total_honor' => 'required|numeric',
                'keterangan' => 'required',
            ]);
        } else {
            $validator = Validator::make($req->all(), [
                'nama' => 'required|string',
                'tanggal' => 'required|date',
                'nominal' => 'required|numeric',
                'keterangan' => 'required',
            ]);
        }
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);

        $data = $req->except(['_method', '_token']);

        // file
        if ($req->hasFile('file')) {
            $file = $req->file('file');
            $jenis_pengeluaran = str_replace(' ', '-', $req->jenis_pengeluaran);
            $fileName = $jenis_pengeluaran . '_' . date('YmdHis') . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('Bukti_Pengeluaran', $fileName, 'public');
            $data['file'] = $filePath;
        }

        // save data
        if ($pengeluaran_lainnya == 'Perbaikan Aset') {
            $check = PerbaikanAset::find($id)->update($data);
            // jurnal
            $dataJournal = [
                'keterangan' => 'Perbaikan aset: ' . PerbaikanAset::find($id)->aset->nama_aset,
                'nominal' => PerbaikanAset::find($id)->harga,
                'tanggal' => PerbaikanAset::find($id)->tanggal,
            ];
            $journal = PerbaikanAset::find($id)->journals()->first();
            $journal->update($dataJournal);
        } elseif ($pengeluaran_lainnya == 'Outbond') {
            $check = Outbond::find($id)->update($data);
            // jurnal
            $dataJournal = [
                'keterangan' => 'Pengeluaran Outbond ' . formatTanggal(Outbond::find($id)->tanggal_outbond),
                'nominal' => Outbond::find($id)->harga_outbond,
                'tanggal' =>  Outbond::find($id)->tanggal_pembayaran,
            ];
            $journal = Outbond::find($id)->journals()->first();
            $journal->update($dataJournal);
        } elseif ($pengeluaran_lainnya == 'Operasional') {
            $check = Operasional::find($id)->update($data);
            // jurnal
            $dataJournal = [
                'keterangan' => 'Pengeluaran Operasional: ' . Operasional::find($id)->jenis,
                'nominal' => Operasional::find($id)->jumlah_tagihan,
                'tanggal' => Operasional::find($id)->tanggal_pembayaran,
            ];
            $journal = Operasional::find($id)->journals()->first();
            $journal->update($dataJournal);
        } elseif($pengeluaran_lainnya == 'Transport') {
            $check = Transport::find($id)->update($data);
            // jurnal
            $dataJournal = [
                'keterangan' => 'Pengeluaran Lainnya: ' . Transport::find($id)->keterangan,
                'nominal' => Transport::find($id)->nominal,
                'tanggal' => Transport::find($id)->tanggal,
            ];
            $journal = Transport::find($id)->journals()->first();
            $journal->update($dataJournal);
        } elseif($pengeluaran_lainnya == 'Honor Dokter') {
            $check = HonorDokter::find($id)->update($data);
            // jurnal
            $dataJournal = [
                'keterangan' => 'Pengeluaran Lainnya: ' . HonorDokter::find($id)->keterangan,
                'nominal' => HonorDokter::find($id)->total_honor,
                'tanggal' => HonorDokter::find($id)->tanggal,
            ];
            $journal = HonorDokter::find($id)->journals()->first();
            $journal->update($dataJournal);
        } else {
            $check = PengeluaranLainnya::find($id)->update($data);
            // jurnal
            $dataJournal = [
                'keterangan' => 'Pengeluaran Lainnya: ' . PengeluaranLainnya::find($id)->nama,
                'nominal' => PengeluaranLainnya::find($id)->nominal,
                'tanggal' => PengeluaranLainnya::find($id)->tanggal,
            ];
            $journal = PengeluaranLainnya::find($id)->journals()->first();
            $journal->update($dataJournal);
        }

        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal diupdate');
        return redirect()->route('pengeluaran_lainnya.index', ['instansi' => $instansi])->with('success', 'Data berhasil diupdate');
    }

    public function destroy($instansi, $pengeluaran_lainnya, $id)
    {
        switch ($pengeluaran_lainnya) {
            case 'Perbaikan Aset':
                $data = PerbaikanAset::find($id);
                break;
            case 'Outbond':
                $data = Outbond::find($id);
                break;
            case 'Operasional':
                $data = Operasional::find($id);
                break;
            case 'Transport':
                $data = Transport::find($id);
                break;
            case 'Honor Dokter':
                $data = HonorDokter::find($id);
                break;
            case 'Lainnya':
                $data = PengeluaranLainnya::find($id);
                break;
            default:
                return response()->json(['msg' => 'Jenis tidak terdaftar'], 404);
                break;
        }
        if(!$data) return response()->json(['msg' => 'Data tidak ditemukan'], 404);
        $check = $data->delete();
        if(!$check) return response()->json(['msg' => 'Gagal menghapus data'], 400);
        return response()->json(['msg' => 'Data berhasil dihapus']);
    }

    public function getData($instansi, Request $req)
    {
        $data = [];
        $totalRecords = 0;
        $filteredRecords = 0;
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
    
        if ($req->filterJenis == 'Perbaikan Aset') {
            $query = PerbaikanAset::where('instansi_id', $data_instansi->id);

            // ordering
            if(!empty($req->order[0])){
                $columnIndex = $req->order[0]['column'];
                $columnName = $req->columns[$columnIndex]['data'];
                $order = $req->order[0]['dir'];;
                $query->orderBy($columnName, $order);
            }

            // searching
            if(!empty($req->search['value'])){
                $searchValue = $req->search['value'];
                $query->like('tanggal', $searchValue)
                      ->orLike('jenis', $searchValue)
                      ->orLike('harga', $searchValue)
                      ->orWhereHas('teknisi', function($q) use($searchValue){
                        $q->like('nama', $searchValue);
                      })
                      ->orWhereHas('aset', function($r) use($searchValue){
                        $r->like('nama_aset', $searchValue);
                      });
            }

            $totalRecords = $query->count();
            $filteredRecords = $totalRecords;
    
            $pengeluaran_lainnya = $query->skip($req->start)
                                        ->take($req->length)
                                        ->get();
    
            foreach ($pengeluaran_lainnya as $pengeluaran) {
                $data[] = [
                    'teknisi_id' => $pengeluaran->teknisi->nama ?? '',
                    'aset_id' => $pengeluaran->aset->nama_aset ?? '',
                    'tanggal' => $pengeluaran->tanggal ? formattanggal($pengeluaran->tanggal) : '',
                    'jenis' => $pengeluaran->jenis ?? '',
                    'harga' => $pengeluaran->harga ? formatRupiah($pengeluaran->harga) : '',
                    'id' => $pengeluaran->id ?? '',
                ];
            }
        } elseif ($req->filterJenis == 'Outbond') {
            $query = Outbond::where('instansi_id', $data_instansi->id);

            // ordering
            if(!empty($req->order[0])){
                $columnIndex = $req->order[0]['column'];
                $columnName = $req->columns[$columnIndex]['data'];
                $order = $req->order[0]['dir'];;
                $query->orderBy($columnName, $order);
            }

            // searching
            if(!empty($req->search['value'])){
                $searchValue = $req->search['value'];
                $query->like('tempat_outbond', $searchValue)
                      ->orLike('tanggal_outbond', $searchValue)
                      ->orLike('harga_outbond', $searchValue)
                      ->orLike('tanggal_pembayaran', $searchValue)
                      ->orWhereHas('biro', function($q) use($searchValue){
                        $q->like('nama', $searchValue);
                      });
            }

            $totalRecords = $query->count();
            $filteredRecords = $totalRecords;
    
            $pengeluaran_lainnya = $query->skip($req->start)
                                        ->take($req->length)
                                        ->get();
    
            foreach ($pengeluaran_lainnya as $pengeluaran) {
                $data[] = [
                    'biro_id' => $pengeluaran->biro->nama ?? '',
                    'tanggal_pembayaran' => $pengeluaran->tanggal_pembayaran ? formatTanggal($pengeluaran->tanggal_pembayaran) : '',
                    'harga_outbond' => $pengeluaran->harga_outbond ? formatRupiah($pengeluaran->harga_outbond) : '',
                    'tanggal_outbond' => $pengeluaran->tanggal_outbond ? formatTanggal($pengeluaran->tanggal_outbond) : '',
                    'tempat_outbond' => $pengeluaran->tempat_outbond ?? '',
                    'id' => $pengeluaran->id ?? '',
                ];
            }
        } elseif ($req->filterJenis == 'Operasional') {
            $query = Operasional::where('instansi_id', $data_instansi->id);

            // ordering
            if(!empty($req->order[0])){
                $columnIndex = $req->order[0]['column'];
                $columnName = $req->columns[$columnIndex]['data'];
                $order = $req->order[0]['dir'];;
                $query->orderBy($columnName, $order);
            }

            // searching
            if(!empty($req->search['value'])){
                $searchValue = $req->search['value'];
                $query->like('tanggal_pembayaran', $searchValue)
                      ->orLike('jenis', $searchValue)
                      ->orLike('jumlah_tagihan', $searchValue)
                      ->orLike('keterangan', $searchValue)
                      ->orWhereHas('pegawai', function($r) use($searchValue){
                        $r->like('nama_gurukaryawan', $searchValue);
                      })->orWhereHas('utilitas', function($r) use($searchValue){
                        $r->like('nama', $searchValue);
                      });
            }

            $totalRecords = $query->count();
            $filteredRecords = $totalRecords;
    
            $pengeluaran_lainnya = $query->skip($req->start)
                                        ->take($req->length)
                                        ->get();
    
            foreach ($pengeluaran_lainnya as $pengeluaran) {
                if ($instansi == 'yayasan') {
                    $data[] = [
                        'karyawan_id' => $pengeluaran->utilitas->nama ?? '',
                        'jenis' => $pengeluaran->jenis ?? '',
                        'tanggal_pembayaran' => $pengeluaran->tanggal_pembayaran ? formatTanggal($pengeluaran->tanggal_pembayaran) : '',
                        'jumlah_tagihan' => $pengeluaran->jumlah_tagihan ? formatRupiah($pengeluaran->jumlah_tagihan) : '',
                        'keterangan' => $pengeluaran->keterangan ?? '',
                        'id' => $pengeluaran->id ?? '',
                    ];
                } else {
                    $data[] = [
                        'karyawan_id' => $pengeluaran->pegawai->nama_gurukaryawan ?? '',
                        'jenis' => $pengeluaran->jenis ?? '',
                        'tanggal_pembayaran' => $pengeluaran->tanggal_pembayaran ? formatTanggal($pengeluaran->tanggal_pembayaran) : '',
                        'jumlah_tagihan' => $pengeluaran->jumlah_tagihan ? formatRupiah($pengeluaran->jumlah_tagihan) : '',
                        'keterangan' => $pengeluaran->keterangan ?? '',
                        'id' => $pengeluaran->id ?? '',
                    ];
                }
            }
        } elseif ($req->filterJenis == 'Transport') {
            $query = Transport::where('instansi_id', $data_instansi->id);

            // ordering
            if(!empty($req->order[0])){
                $columnIndex = $req->order[0]['column'];
                $columnName = $req->columns[$columnIndex]['data'];
                $order = $req->order[0]['dir'];;
                $query->orderBy($columnName, $order);
            }

            // searching
            if(!empty($req->search['value'])){
                $searchValue = $req->search['value'];
                $query->like('tanggal', $searchValue)
                      ->orWhereHas('pengurus', function($r) use($searchValue){
                        $r->like('nama_pengurus', $searchValue);
                      })
                      ->orLike('nominal', $searchValue)
                      ->orLike('keterangan', $searchValue);
            }

            $totalRecords = $query->count();
            $filteredRecords = $totalRecords;
    
            $pengeluaran_lainnya = $query->skip($req->start)
                                        ->take($req->length)
                                        ->get();
    
            foreach ($pengeluaran_lainnya as $pengeluaran) {
                $data[] = [
                    'nama' => $pengeluaran->pengurus->nama_pengurus ?? '',
                    'tanggal' => $pengeluaran->tanggal ? formatTanggal($pengeluaran->tanggal) : '',
                    'nominal' => $pengeluaran->nominal ? formatRupiah($pengeluaran->nominal) : '',
                    'keterangan' => $pengeluaran->keterangan ?? '',
                    'id' => $pengeluaran->id ?? '',
                    ];
            }
        } elseif ($req->filterJenis == 'Honor Dokter') {
            $query = HonorDokter::where('instansi_id', $data_instansi->id);

            // ordering
            if(!empty($req->order[0])){
                $columnIndex = $req->order[0]['column'];
                $columnName = $req->columns[$columnIndex]['data'];
                $order = $req->order[0]['dir'];;
                $query->orderBy($columnName, $order);
            }

            // searching
            if(!empty($req->search['value'])){
                $searchValue = $req->search['value'];
                $query->like('tanggal', $searchValue)
                      ->orWhereHas('pengurus', function($r) use($searchValue){
                        $r->like('nama_pengurus', $searchValue);
                      })
                      ->orLike('total_jam_kerja', $searchValue)
                      ->orLike('honor_harian', $searchValue)
                      ->orLike('total_honor', $searchValue);
            }

            $totalRecords = $query->count();
            $filteredRecords = $totalRecords;
    
            $pengeluaran_lainnya = $query->skip($req->start)
                                        ->take($req->length)
                                        ->get();
    
            foreach ($pengeluaran_lainnya as $pengeluaran) {
                $data[] = [
                    'nama' => $pengeluaran->pengurus->nama_pengurus ?? '',
                    'tanggal' => $pengeluaran->tanggal ? formatTanggal($pengeluaran->tanggal) : '',
                    'nominal' => $pengeluaran->total_honor ? formatRupiah($pengeluaran->total_honor) : '',
                    'keterangan' => $pengeluaran->keterangan ?? '',
                    'id' => $pengeluaran->id ?? '',
                    ];
            }
        } elseif ($req->filterJenis == 'Lainnya') {
            $query = PengeluaranLainnya::where('instansi_id', $data_instansi->id);

            // ordering
            if(!empty($req->order[0])){
                $columnIndex = $req->order[0]['column'];
                $columnName = $req->columns[$columnIndex]['data'];
                $order = $req->order[0]['dir'];;
                $query->orderBy($columnName, $order);
            }

            // searching
            if(!empty($req->search['value'])){
                $searchValue = $req->search['value'];
                $query->like('tanggal', $searchValue)
                      ->orLike('nama', $searchValue)
                      ->orLike('nominal', $searchValue)
                      ->orLike('keterangan', $searchValue);
            }

            $totalRecords = $query->count();
            $filteredRecords = $totalRecords;
    
            $pengeluaran_lainnya = $query->skip($req->start)
                                        ->take($req->length)
                                        ->get();
    
            foreach ($pengeluaran_lainnya as $pengeluaran) {
                $data[] = [
                    'nama' => $pengeluaran->nama ?? '',
                    'tanggal' => $pengeluaran->tanggal ? formatTanggal($pengeluaran->tanggal) : '',
                    'nominal' => $pengeluaran->nominal ? formatRupiah($pengeluaran->nominal) : '',
                    'keterangan' => $pengeluaran->keterangan ?? '',
                    'id' => $pengeluaran->id ?? '',
                    ];
            }
        } else {
            return response()->json('Jenis salah', 400);
        }
    
        return response()->json([
            'draw' => intval($req->draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data,
        ]);
    } 
    
    public function cetak($instansi, $pengeluaran_lainnya, $id)
    {
        switch ($pengeluaran_lainnya) {
            case 'Perbaikan Aset':
                $getData = PerbaikanAset::find($id);
                $data = [
                    'instansi_sumber' => $getData->instansi_id,
                    'nominal' => $getData->harga,
                    'nama' => 'Perbaikan ' . $getData->aset->nama_aset,
                    'tanggal' => $getData->tanggal,
                ];
                break;
            case 'Outbond':
                $getData = Outbond::find($id);
                $data = [
                    'instansi_sumber' => $getData->instansi_id,
                    'nominal' => $getData->harga_outbond,
                    'nama' => 'Outbond',
                    'tanggal' => $getData->tanggal_pembayaran,
                ];
                break;
            case 'Operasional':
                $getData = Operasional::find($id);
                $data = [
                    'instansi_sumber' => $getData->instansi_id,
                    'nominal' => $getData->jumlah_tagihan,
                    'nama' => 'Biaya ' . $getData->jenis,
                    'tanggal' => $getData->tanggal_pembayaran,
                ];
                break;
            case 'Transport':
                $getData = Transport::find($id);
                $data = [
                    'instansi_sumber' => $getData->instansi_id,
                    'nominal' => $getData->nominal,
                    'nama' => $getData->pengurus->nama_pengurus,
                    'tanggal' => $getData->tanggal,
                ];
                break;
            case 'Honor Dokter':
                $getData = HonorDokter::find($id);
                $data = [
                    'instansi_sumber' => $getData->instansi_id,
                    'nominal' => $getData->total_honor,
                    'nama' => $getData->pengurus->nama_pengurus,
                    'tanggal' => $getData->tanggal,
                ];
                break;
            case 'Lainnya':
                $getData = PengeluaranLainnya::find($id);
                $data = [
                    'instansi_sumber' => $getData->instansi_id,
                    'nominal' => $getData->nominal,
                    'nama' => $getData->nama,
                    'tanggal' => $getData->tanggal,
                ];
                break;
            default:
                return response()->json(['msg' => 'Jenis tidak terdaftar'], 404);
                break;
        }
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $data['instansi_id'] = $data_instansi->id;
        $data['pengeluaran_lainnya'] = $pengeluaran_lainnya;
        $pdf = Pdf::loadView('pengeluaran_lainnya.cetak', $data)->setPaper('a4', 'landscape');
        return $pdf->stream('kwitansi-pengeluaran-lainnya.pdf');
    }

    public function getNominal(Request $req, $instansi){
        $validator = Validator::make($req->all(), [
            'jenis' => 'required',
            'bulan' => 'required',
            'tahun' => 'required',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return response()->json($error, 400);
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        if($req->jenis == 'Transport'){
            $data = Transport::whereMonth('tanggal', $req->bulan)->whereYear('tanggal', $req->tahun)->sum('nominal') ?? 0;
        } else if($req->jenis == 'Honor Dokter'){
            $data = HonorDokter::whereMonth('tanggal', $req->bulan)->whereYear('tanggal', $req->tahun)->sum('total_honor') ?? 0;
        } else {
            return response()->json('Jenis tidak sesuai', 400);
        }
        return response()->json($data);
    }

    private function createJurnal($keterangan, $akun, $debit, $kredit, $instansi_id, $tanggal, $type, $id)
    {
        Jurnal::create([
            'instansi_id' => $instansi_id,
            'journable_type' => $type,
            'journable_id' => $id,
            'keterangan' => $keterangan,
            'akun_debit' => $debit ? $akun : null,
            'akun_kredit' => $kredit ? $akun : null,
            'nominal' => $debit ?? $kredit,
            'tanggal' => $tanggal,
        ]);
    }
}
