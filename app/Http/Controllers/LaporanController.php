<?php

namespace App\Http\Controllers;

use App\Exports\ArusKasExport;
use App\Exports\AsetNettoExport;
use App\Exports\DonasiExport;
use App\Exports\GajiExport;
use App\Exports\JPIExport;
use App\Exports\KomprehensifExport;
use App\Exports\OperasionalExport;
use App\Exports\OutbondExport;
use App\Exports\OvertimeExport;
use App\Exports\PemasukanLainnyaExport;
use App\Exports\PemasukanOutbondExport;
use App\Exports\PemasukanYayasanExport;
use App\Exports\PembelianAsetExport;
use App\Exports\PembelianAtkExport;
use App\Exports\PengeluaranLainnyaExport;
use App\Exports\PerbaikanAsetExport;
use App\Exports\PosisiExport;
use App\Exports\PosisiKonsolidasiExport;
use App\Exports\RegistrasiExport;
use App\Exports\SewaKantinExport;
use App\Exports\SPPExport;
use App\Models\Akun;
use App\Models\Aset;
use App\Models\Atk;
use App\Models\Biro;
use App\Models\BukuBesar;
use App\Models\Instansi;
use App\Models\Jurnal;
use App\Models\KartuStok;
use App\Models\Kelas;
use App\Models\Operasional;
use App\Models\Outbond;
use App\Models\Pegawai;
use App\Models\PemasukanLainnya;
use App\Models\PemasukanYayasan;
use App\Models\PembayaranSiswa;
use App\Models\PembelianAset;
use App\Models\PembelianAtk;
use App\Models\PengeluaranLainnya;
use App\Models\Penggajian;
use App\Models\PerbaikanAset;
use App\Models\Supplier;
use App\Models\Teknisi;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index_spp($instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $kelas = Kelas::where('instansi_id', $data_instansi->id)->get();
        return view('laporan_data.spp', compact('kelas'));
    }

    public function print_spp(Request $request, $instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();

        $query = PembayaranSiswa::with('tagihan_siswa', 'siswa', )->whereHas('tagihan_siswa', function($q) use ($data_instansi) {
            $q->where('jenis_tagihan', 'SPP')->where('instansi_id', $data_instansi->id);
        });

        if (!empty($request->filterDateStart)) {
            $query->whereDate('tanggal', '>=', $request->filterDateStart);
        }

        if (!empty($request->filterDateEnd)) {
            $query->whereDate('tanggal', '<=', $request->filterDateEnd);
        }

        if (!empty($request->filterTipe)) {
            $query->where('tipe_pembayaran', $request->filterTipe);
        }

        if (!empty($request->filterKelas)) {
            $query->whereHas('siswa', function($q) use ($request) {
                $q->where('kelas_id', $request->filterKelas);
            });
        }

        if ($request->has('export')) {
            if ($request->export == 'pdf') {
                $data = $query->get()->toArray();
                $pdf = PDF::loadView('pdf.spp', compact('data'));
                return $pdf->download('SPP.pdf');
            } elseif ($request->export == 'excel') {
                $data = $query->get();
                return Excel::download(new SPPExport($data), 'SPP.xlsx');
            }
        }
    }

    public function index_pem_outbond($instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $kelas = Kelas::where('instansi_id', $data_instansi->id)->get();
        return view('laporan_data.pemasukan_outbond', compact('kelas'));
    }

    public function print_pem_outbond(Request $request, $instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();

        $query = PembayaranSiswa::with('tagihan_siswa', 'siswa', )->whereHas('tagihan_siswa', function($q) use ($data_instansi) {
            $q->where('jenis_tagihan', 'Outbond')->where('instansi_id', $data_instansi->id);
        });

        if (!empty($request->filterDateStart)) {
            $query->whereDate('tanggal', '>=', $request->filterDateStart);
        }

        if (!empty($request->filterDateEnd)) {
            $query->whereDate('tanggal', '<=', $request->filterDateEnd);
        }

        if (!empty($request->filterTipe)) {
            $query->where('tipe_pembayaran', $request->filterTipe);
        }

        if (!empty($request->filterKelas)) {
            $query->whereHas('siswa', function($q) use ($request) {
                $q->where('kelas_id', $request->filterKelas);
            });
        }

        if ($request->has('export')) {
            if ($request->export == 'pdf') {
                $data = $query->get()->toArray();
                $pdf = PDF::loadView('pdf.pemasukan_outbond', compact('data'));
                return $pdf->download('Pemasukan-Outbond.pdf');
            } elseif ($request->export == 'excel') {
                $data = $query->get();
                return Excel::download(new PemasukanOutbondExport($data), 'Pemasukan-Outbond.xlsx');
            }
        }
    }

    public function index_jpi($instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $kelas = Kelas::where('instansi_id', $data_instansi->id)->get();
        return view('laporan_data.jpi', compact('kelas'));
    }

    public function print_jpi(Request $request, $instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();

        $query = PembayaranSiswa::with('tagihan_siswa', 'siswa', )->whereHas('tagihan_siswa', function($q) use ($data_instansi) {
            $q->where('jenis_tagihan', 'JPI')->where('instansi_id', $data_instansi->id);
        });

        if (!empty($request->filterDateStart)) {
            $query->whereDate('tanggal', '>=', $request->filterDateStart);
        }

        if (!empty($request->filterDateEnd)) {
            $query->whereDate('tanggal', '<=', $request->filterDateEnd);
        }

        if (!empty($request->filterTipe)) {
            $query->where('tipe_pembayaran', $request->filterTipe);
        }

        if (!empty($request->filterKelas)) {
            $query->whereHas('siswa', function($q) use ($request) {
                $q->where('kelas_id', $request->filterKelas);
            });
        }

        if ($request->has('export')) {
            if ($request->export == 'pdf') {
                $data = $query->get()->toArray();
                $pdf = PDF::loadView('pdf.jpi', compact('data'));
                return $pdf->download('JPI.pdf');
            } elseif ($request->export == 'excel') {
                $data = $query->get();
                return Excel::download(new JPIExport($data), 'JPI.xlsx');
            }
        }
    }

    public function index_yayasan($instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        return view('laporan_data.yayasan');
    }

    public function print_yayasan(Request $request, $instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();

        $query = PemasukanYayasan::query();

        if (!empty($request->filterDateStart)) {
            $query->whereDate('tanggal', '>=', $request->filterDateStart);
        }

        if (!empty($request->filterDateEnd)) {
            $query->whereDate('tanggal', '<=', $request->filterDateEnd);
        }

        if (!empty($request->filterTipe)) {
            $query->where('jenis', $request->filterTipe);
        }

        if ($request->has('export')) {
            if ($request->export == 'pdf') {
                $data = $query->get()->toArray();
                $pdf = PDF::loadView('pdf.yayasan', compact('data'));
                return $pdf->download('Pemasukan-Yayasan.pdf');
            } elseif ($request->export == 'excel') {
                $data = $query->get();
                return Excel::download(new PemasukanYayasanExport($data), 'Pemasukan-Yayasan.xlsx');
            }
        }
    }

    public function index_registrasi($instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $kelas = Kelas::where('instansi_id', $data_instansi->id)->get();
        return view('laporan_data.registrasi', compact('kelas'));
    }

    public function print_registrasi(Request $request, $instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();

        $query = PembayaranSiswa::with('tagihan_siswa', 'siswa', )->whereHas('tagihan_siswa', function($q) use ($data_instansi) {
            $q->where('jenis_tagihan', 'Registrasi')->where('instansi_id', $data_instansi->id);
        });

        if (!empty($request->filterDateStart)) {
            $query->whereDate('tanggal', '>=', $request->filterDateStart);
        }

        if (!empty($request->filterDateEnd)) {
            $query->whereDate('tanggal', '<=', $request->filterDateEnd);
        }

        if (!empty($request->filterTipe)) {
            $query->where('tipe_pembayaran', $request->filterTipe);
        }

        if (!empty($request->filterKelas)) {
            $query->whereHas('siswa', function($q) use ($request) {
                $q->where('kelas_id', $request->filterKelas);
            });
        }

        if ($request->has('export')) {
            if ($request->export == 'pdf') {
                $data = $query->get()->toArray();
                $pdf = PDF::loadView('pdf.registrasi', compact('data'));
                return $pdf->download('Registrasi.pdf');
            } elseif ($request->export == 'excel') {
                $data = $query->get();
                return Excel::download(new RegistrasiExport($data), 'Registrasi.xlsx');
            }
        }
    }

    public function index_donasi($instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        return view('laporan_data.donasi');
    }

    public function print_donasi(Request $request, $instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();

        $query = PemasukanLainnya::with('donasi')->where('jenis', 'Donasi')->where('instansi_id', $data_instansi->id);

        if (!empty($request->filterDateStart)) {
            $query->whereDate('tanggal', '>=', $request->filterDateStart);
        }

        if (!empty($request->filterDateEnd)) {
            $query->whereDate('tanggal', '<=', $request->filterDateEnd);
        }

        if ($request->has('export')) {
            if ($request->export == 'pdf') {
                $data = $query->get()->toArray();
                $pdf = PDF::loadView('pdf.donasi', compact('data'));
                return $pdf->download('Donasi.pdf');
            } elseif ($request->export == 'excel') {
                $data = $query->get();
                return Excel::download(new DonasiExport($data), 'Donasi.xlsx');
            }
        }
    }

    public function index_overtime($instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        return view('laporan_data.overtime');
    }

    public function print_overtime(Request $request, $instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();

        $query = PemasukanLainnya::where('jenis', 'Overtime')->where('instansi_id', $data_instansi->id);

        if (!empty($request->filterDateStart)) {
            $query->whereDate('tanggal', '>=', $request->filterDateStart);
        }

        if (!empty($request->filterDateEnd)) {
            $query->whereDate('tanggal', '<=', $request->filterDateEnd);
        }

        if ($request->has('export')) {
            if ($request->export == 'pdf') {
                $data = $query->get()->toArray();
                $pdf = PDF::loadView('pdf.overtime', compact('data'));
                return $pdf->download('overtime.pdf');
            } elseif ($request->export == 'excel') {
                $data = $query->get();
                return Excel::download(new OvertimeExport($data), 'overtime.xlsx');
            }
        }
    }

    public function index_sewa_kantin($instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $kelas = Kelas::where('instansi_id', $data_instansi->id)->get();
        return view('laporan_data.sewa_kantin', compact('kelas'));
    }

    public function print_sewa_kantin(Request $request, $instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();

        $query = PemasukanLainnya::where('jenis', 'Sewa Kantin')->where('instansi_id', $data_instansi->id);

        if (!empty($request->filterDateStart)) {
            $query->whereDate('tanggal', '>=', $request->filterDateStart);
        }

        if (!empty($request->filterDateEnd)) {
            $query->whereDate('tanggal', '<=', $request->filterDateEnd);
        }

        if ($request->has('export')) {
            if ($request->export == 'pdf') {
                $data = $query->get()->toArray();
                $pdf = PDF::loadView('pdf.sewa_kantin', compact('data'));
                return $pdf->download('Sewa_Kantin.pdf');
            } elseif ($request->export == 'excel') {
                $data = $query->get();
                return Excel::download(new SewaKantinExport($data), 'Sewa_Kantin.xlsx');
            }
        }
    }

    public function index_pemasukan_lainnya($instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $kelas = Kelas::where('instansi_id', $data_instansi->id)->get();
        return view('laporan_data.pemasukan_lainnya', compact('kelas'));
    }

    public function print_pemasukan_lainnya(Request $request, $instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();

        $query = PemasukanLainnya::where('jenis', 'Lainnya')->where('instansi_id', $data_instansi->id);

        if (!empty($request->filterDateStart)) {
            $query->whereDate('tanggal', '>=', $request->filterDateStart);
        }

        if (!empty($request->filterDateEnd)) {
            $query->whereDate('tanggal', '<=', $request->filterDateEnd);
        }

        if ($request->has('export')) {
            if ($request->export == 'pdf') {
                $data = $query->get()->toArray();
                $pdf = PDF::loadView('pdf.pemasukan_lainnya', compact('data'));
                return $pdf->download('Pemasukan_Lainnya.pdf');
            } elseif ($request->export == 'excel') {
                $data = $query->get();
                return Excel::download(new PemasukanLainnyaExport($data), 'Pemasukan_Lainnya.xlsx');
            }
        }
    }

    public function index_aset($instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $supplier = Supplier::where('instansi_id', $data_instansi->id)->where('jenis_supplier', 'Aset')->get();
        $aset = Aset::where('instansi_id', $data_instansi->id)->get();
        return view('laporan_data.aset', compact('supplier', 'aset'));
    }

    public function print_aset(Request $request, $instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();

        $query = PembelianAset::with('supplier', 'komponen.aset')->whereHas('supplier', function($q) use($data_instansi){
            $q->where('instansi_id', $data_instansi->id);
        });

        if (!empty($request->filterDateStart)) {
            $query->whereDate('tgl_beliaset', '>=', $request->filterDateStart);
        }

        if (!empty($request->filterDateEnd)) {
            $query->whereDate('tgl_beliaset', '<=', $request->filterDateEnd);
        }

        if (!empty($request->filterSupplier)) {
            $query->where('supplier_id', $request->filterSupplier);
        }

        if ($request->has('export')) {
            if ($request->export == 'pdf') {
                $data = $query->get()->toArray();
                $pdf = PDF::loadView('pdf.aset', compact('data'));
                return $pdf->download('Pembelian-Aset.pdf');
            } elseif ($request->export == 'excel') {
                $data = $query->get();
                return Excel::download(new PembelianAsetExport($data), 'Pembelian-Aset.xlsx');
            }
        }
    }

    public function index_atk($instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $supplier = Supplier::where('instansi_id', $data_instansi->id)->where('jenis_supplier', 'ATK')->get();
        $atk = Atk::where('instansi_id', $data_instansi->id)->get();
        return view('laporan_data.atk', compact('supplier', 'atk'));
    }

    public function print_atk(Request $request, $instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();

        $query = PembelianAtk::with('supplier', 'komponen.atk')->whereHas('supplier', function($q) use($data_instansi){
            $q->where('instansi_id', $data_instansi->id);
        });

        if (!empty($request->filterDateStart)) {
            $query->whereDate('tgl_beliatk', '>=', $request->filterDateStart);
        }

        if (!empty($request->filterDateEnd)) {
            $query->whereDate('tgl_beliatk', '<=', $request->filterDateEnd);
        }

        if (!empty($request->filterSupplier)) {
            $query->where('supplier_id', $request->filterSupplier);
        }

        // if (!empty($request->filterAtk)) {
        //     $query->where('atk_id', $request->filterAtk);
        // }

        if ($request->has('export')) {
            if ($request->export == 'pdf') {
                $data = $query->get()->toArray();
                $pdf = PDF::loadView('pdf.atk', compact('data'));
                return $pdf->download('Pembelian-Atk.pdf');
            } elseif ($request->export == 'excel') {
                $data = $query->get();
                return Excel::download(new PembelianAtkExport($data), 'Pembelian-Atk.xlsx');
            }
        }
    }

    public function index_perbaikan_aset($instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $teknisi = Teknisi::where('instansi_id', $data_instansi->id)->get();
        $aset = Aset::where('instansi_id', $data_instansi->id)->get();
        return view('laporan_data.perbaikan_aset', compact('teknisi', 'aset'));
    }

    public function print_perbaikan_aset(Request $request, $instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();

        $query = PerbaikanAset::with('teknisi', 'aset')->where('instansi_id', $data_instansi->id);

        if (!empty($request->filterDateStart)) {
            $query->whereDate('tanggal', '>=', $request->filterDateStart);
        }

        if (!empty($request->filterDateEnd)) {
            $query->whereDate('tanggal', '<=', $request->filterDateEnd);
        }

        if (!empty($request->filterTeknisi)) {
            $query->where('teknisi_id', $request->filterTeknisi);
        }

        if (!empty($request->filterAset)) {
            $query->where('aset_id', $request->filterAset);
        }

        if ($request->has('export')) {
            if ($request->export == 'pdf') {
                $data = $query->get()->toArray();
                $pdf = PDF::loadView('pdf.perbaikan_aset', compact('data'));
                return $pdf->download('Perbaikan-Aset.pdf');
            } elseif ($request->export == 'excel') {
                $data = $query->get();
                return Excel::download(new PerbaikanAsetExport($data), 'Perbaikan-Aset.xlsx');
            }
        }
    }

    public function index_operasional($instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $karyawan = Pegawai::where('instansi_id', $data_instansi->id)->get();
        return view('laporan_data.operasional', compact('karyawan'));
    }

    public function print_operasional(Request $request, $instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();

        $query = Operasional::with('pegawai')->where('instansi_id', $data_instansi->id);

        if (!empty($request->filterDateStart)) {
            $query->whereDate('tanggal_pembayaran', '>=', $request->filterDateStart);
        }

        if (!empty($request->filterDateEnd)) {
            $query->whereDate('tanggal_pembayaran', '<=', $request->filterDateEnd);
        }

        if (!empty($request->filterKaryawan)) {
            $query->where('karyawan_id', $request->filterKaryawan);
        }

        if (!empty($request->filterJenis)) {
            $query->where('jenis', $request->filterJenis);
        }

        if ($request->has('export')) {
            if ($request->export == 'pdf') {
                $data = $query->get()->toArray();
                $pdf = PDF::loadView('pdf.operasional', compact('data'));
                return $pdf->download('Operasional.pdf');
            } elseif ($request->export == 'excel') {
                $data = $query->get();
                return Excel::download(new OperasionalExport($data), 'Operasional.xlsx');
            }
        }
    }

    public function index_outbond($instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $biro = Biro::all();
        return view('laporan_data.outbond', compact('biro'));
    }

    public function print_outbond(Request $request, $instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();

        $query = Outbond::with('biro')->where('instansi_id', $data_instansi->id);

        if (!empty($request->filterDateStart)) {
            $query->whereDate('tanggal_outbond', '>=', $request->filterDateStart);
        }

        if (!empty($request->filterDateEnd)) {
            $query->whereDate('tanggal_outbond', '<=', $request->filterDateEnd);
        }

        if (!empty($request->filterBiro)) {
            $query->where('biro_id', $request->filterBiro);
        }

        if ($request->has('export')) {
            if ($request->export == 'pdf') {
                $data = $query->get()->toArray();
                $pdf = PDF::loadView('pdf.outbond', compact('data'));
                return $pdf->download('Outbond.pdf');
            } elseif ($request->export == 'excel') {
                $data = $query->get();
                return Excel::download(new OutbondExport($data), 'Outbond.xlsx');
            }
        }
    }

    public function index_gaji($instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $karyawan = Pegawai::where('instansi_id', $data_instansi->id)->get();
        return view('laporan_data.gaji', compact('karyawan'));
    }

    public function print_gaji(Request $request, $instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();

        $query = Penggajian::with('pegawai', 'jabatan')->whereHas('pegawai', function($q) use($data_instansi){
            $q->where('instansi_id', $data_instansi->id);
        });

        if (!empty($request->filterDateStart)) {
            $query->whereDate('created_at', '>=', $request->filterDateStart);
        }

        if (!empty($request->filterDateEnd)) {
            $query->whereDate('created_at', '<=', $request->filterDateEnd);
        }

        if (!empty($request->filterKaryawan)) {
            $query->where('karyawan_id', $request->filterKaryawan);
        }

        if ($request->has('export')) {
            if ($request->export == 'pdf') {
                $data = $query->get()->toArray();
                $pdf = PDF::loadView('pdf.gaji', compact('data'));
                return $pdf->download('Gaji.pdf');
            } elseif ($request->export == 'excel') {
                $data = $query->get();
                return Excel::download(new GajiExport($data), 'Gaji.xlsx');
            }
        }
    }

    public function index_pengeluaran_lainnya($instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        return view('laporan_data.pengeluaran_lainnya');
    }

    public function print_pengeluaran_lainnya(Request $request, $instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();

        $query = PengeluaranLainnya::where('instansi_id', $data_instansi->id);

        if (!empty($request->filterDateStart)) {
            $query->whereDate('tanggal', '>=', $request->filterDateStart);
        }

        if (!empty($request->filterDateEnd)) {
            $query->whereDate('tanggal', '<=', $request->filterDateEnd);
        }

        if ($request->has('export')) {
            if ($request->export == 'pdf') {
                $data = $query->get()->toArray();
                $pdf = PDF::loadView('pdf.pengeluaran_lainnya', compact('data'));
                return $pdf->download('Pengeluaran-Lainnya.pdf');
            } elseif ($request->export == 'excel') {
                $data = $query->get();
                return Excel::download(new PengeluaranLainnyaExport($data), 'pengeluaran_lainnya.xlsx');
            }
        }
    }























    // Laporan Keuangan
    public function index_komprehensif(Request $req, $instansi)
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
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $akuns = Akun::where('instansi_id', $data_instansi->id)->whereIn('tipe', ['Pendapatan', 'Beban'])->get();

        $saldoAkun = collect();
        if (isset($req->tahun) && isset($req->bulan)) {
            // Dapatkan semua akun
            $allAkun = Akun::where('instansi_id', $data_instansi->id)->whereIn('tipe', ['Pendapatan', 'Beban'])->get();

            foreach ($allAkun as $akun) {
                $akunData = Jurnal::orderBy('tanggal')
                    ->where(function($query) use ($akun) {
                        $query->where('akun_debit', $akun->id)
                            ->orWhere('akun_kredit', $akun->id);
                    })
                    ->whereYear('tanggal', $req->tahun)
                    ->whereMonth('tanggal', $req->bulan)
                    ->get();

                if ($akun) {
                    $tanggal = Carbon::createFromFormat('Y-m', $req->tahun . '-' . $req->bulan)->startOfMonth();
                    $tanggalSebelumnya = $tanggal->copy()->subMonth();
                    $tahunSebelumnya = $tanggalSebelumnya->year;
                    $bulanSebelumnya = $tanggalSebelumnya->format('m');

                    $bukubesar = BukuBesar::where('akun_id', $akun->id)
                        ->whereYear('tanggal', $tahunSebelumnya)
                        ->whereMonth('tanggal', $bulanSebelumnya)
                        ->first();
                        
                    $saldo_awal = $bukubesar ? $bukubesar->saldo_akhir : $akun->saldo_awal;

                    $temp_saldo = $saldo_awal;
                    $totalDebit = 0;
                    $totalKredit = 0;

                    foreach ($akunData as $item) {
                        if ($akun->posisi == 'DEBIT') {
                            if ($item->akun_kredit == $akun->id) {
                                $temp_saldo -= $item->nominal;
                                $totalKredit += $item->nominal;
                            } else if ($item->akun_debit == $akun->id) {
                                $temp_saldo += $item->nominal;
                                $totalDebit += $item->nominal;
                            }
                        } else {
                            if ($item->akun_kredit == $akun->id) {
                                $temp_saldo += $item->nominal;
                                $totalKredit += $item->nominal;
                            } else if ($item->akun_debit == $akun->id) {
                                $temp_saldo -= $item->nominal;
                                $totalDebit += $item->nominal;
                            }
                        }
                    }

                    $saldo_akhir = $temp_saldo;
                    $saldoBersih = $saldo_akhir;
                    
                    // Tentukan di mana saldo bersih ditempatkan berdasarkan posisi akun
                    $totalDebit = $akun->posisi == 'DEBIT' ? $saldoBersih : 0;
                    $totalKredit = $akun->posisi == 'KREDIT' ? $saldoBersih : 0;

                    // Tambahkan data ke koleksi
                    $saldoAkun->push([
                        'akun_id' => $akun->id,
                        'posisi' => $akun->posisi,
                        'nama_akun' => $akun->nama,
                        'total_debit' => $totalDebit,
                        'total_kredit' => $totalKredit,
                        'saldo_bersih' => $saldoBersih,
                    ]);
                }
            }
        }
        return view('komprehensif.index', compact('saldoAkun', 'tahun', 'bulan', 'akuns'));
    }

    public function pdf_komprehensif(Request $req, $instansi)
    {
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

        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();

        $saldoAkun = collect();

        if (isset($req->tahun) && isset($req->bulan)) {
            // Dapatkan semua akun
            $allAkun = Akun::where('instansi_id', $data_instansi->id)->whereIn('tipe', ['Pendapatan', 'Beban'])->get();

            foreach ($allAkun as $akun) {
                $akunData = Jurnal::orderBy('tanggal')
                    ->where(function($query) use ($akun) {
                        $query->where('akun_debit', $akun->id)
                            ->orWhere('akun_kredit', $akun->id);
                    })
                    ->whereYear('tanggal', $req->tahun)
                    ->whereMonth('tanggal', $req->bulan)
                    ->get();

                if ($akun) {
                    $tanggal = Carbon::createFromFormat('Y-m', $req->tahun . '-' . $req->bulan)->startOfMonth();
                    $tanggalSebelumnya = $tanggal->copy()->subMonth();
                    $tahunSebelumnya = $tanggalSebelumnya->year;
                    $bulanSebelumnya = $tanggalSebelumnya->format('m');

                    $bukubesar = BukuBesar::where('akun_id', $akun->id)
                        ->whereYear('tanggal', $tahunSebelumnya)
                        ->whereMonth('tanggal', $bulanSebelumnya)
                        ->first();
                        
                    $saldo_awal = $bukubesar ? $bukubesar->saldo_akhir : $akun->saldo_awal;

                    $temp_saldo = $saldo_awal;
                    $totalDebit = 0;
                    $totalKredit = 0;

                    foreach ($akunData as $item) {
                        if ($akun->posisi == 'DEBIT') {
                            if ($item->akun_kredit == $akun->id) {
                                $temp_saldo -= $item->nominal;
                                $totalKredit += $item->nominal;
                            } else if ($item->akun_debit == $akun->id) {
                                $temp_saldo += $item->nominal;
                                $totalDebit += $item->nominal;
                            }
                        } else {
                            if ($item->akun_kredit == $akun->id) {
                                $temp_saldo += $item->nominal;
                                $totalKredit += $item->nominal;
                            } else if ($item->akun_debit == $akun->id) {
                                $temp_saldo -= $item->nominal;
                                $totalDebit += $item->nominal;
                            }
                        }
                    }

                    $saldo_akhir = $temp_saldo;
                    $saldoBersih = $saldo_akhir;
                    
                    // Tentukan di mana saldo bersih ditempatkan berdasarkan posisi akun
                    $totalDebit = $akun->posisi == 'DEBIT' ? $saldoBersih : 0;
                    $totalKredit = $akun->posisi == 'KREDIT' ? $saldoBersih : 0;

                    // Tambahkan data ke koleksi
                    $saldoAkun->push([
                        'akun_id' => $akun->id,
                        'posisi' => $akun->posisi,
                        'nama_akun' => $akun->nama,
                        'total_debit' => $totalDebit,
                        'total_kredit' => $totalKredit,
                        'saldo_bersih' => $saldoBersih,
                    ]);
                }
            }
        }

        $bulan = $dataBulan[$req->bulan];
        $tahun = $req->tahun;
        $data = $saldoAkun->toArray();
        $akuns = Akun::where('instansi_id', $data_instansi->id)->whereIn('jenis', ['PENDAPATAN', 'BEBAN'])->get()->toArray();
        $pdf = Pdf::loadView('komprehensif.pdf', compact('data', 'bulan', 'tahun', 'data_instansi', 'akuns'));
        return $pdf->stream('Komprehensif.pdf');
    }

    public function excel_komprehensif(Request $req, $instansi)
    {
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

        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();

        $saldoAkun = collect();

        if (isset($req->tahun) && isset($req->bulan)) {
            // Dapatkan semua akun
            $allAkun = Akun::where('instansi_id', $data_instansi->id)->whereIn('tipe', ['Pendapatan', 'Beban'])->get();

            foreach ($allAkun as $akun) {
                $akunData = Jurnal::orderBy('tanggal')
                    ->where(function($query) use ($akun) {
                        $query->where('akun_debit', $akun->id)
                            ->orWhere('akun_kredit', $akun->id);
                    })
                    ->whereYear('tanggal', $req->tahun)
                    ->whereMonth('tanggal', $req->bulan)
                    ->get();

                if ($akun) {
                    $tanggal = Carbon::createFromFormat('Y-m', $req->tahun . '-' . $req->bulan)->startOfMonth();
                    $tanggalSebelumnya = $tanggal->copy()->subMonth();
                    $tahunSebelumnya = $tanggalSebelumnya->year;
                    $bulanSebelumnya = $tanggalSebelumnya->format('m');

                    $bukubesar = BukuBesar::where('akun_id', $akun->id)
                        ->whereYear('tanggal', $tahunSebelumnya)
                        ->whereMonth('tanggal', $bulanSebelumnya)
                        ->first();
                        
                    $saldo_awal = $bukubesar ? $bukubesar->saldo_akhir : $akun->saldo_awal;

                    $temp_saldo = $saldo_awal;
                    $totalDebit = 0;
                    $totalKredit = 0;

                    foreach ($akunData as $item) {
                        if ($akun->posisi == 'DEBIT') {
                            if ($item->akun_kredit == $akun->id) {
                                $temp_saldo -= $item->nominal;
                                $totalKredit += $item->nominal;
                            } else if ($item->akun_debit == $akun->id) {
                                $temp_saldo += $item->nominal;
                                $totalDebit += $item->nominal;
                            }
                        } else {
                            if ($item->akun_kredit == $akun->id) {
                                $temp_saldo += $item->nominal;
                                $totalKredit += $item->nominal;
                            } else if ($item->akun_debit == $akun->id) {
                                $temp_saldo -= $item->nominal;
                                $totalDebit += $item->nominal;
                            }
                        }
                    }

                    $saldo_akhir = $temp_saldo;
                    $saldoBersih = $saldo_akhir;
                    
                    // Tentukan di mana saldo bersih ditempatkan berdasarkan posisi akun
                    $totalDebit = $akun->posisi == 'DEBIT' ? $saldoBersih : 0;
                    $totalKredit = $akun->posisi == 'KREDIT' ? $saldoBersih : 0;

                    // Tambahkan data ke koleksi
                    $saldoAkun->push([
                        'akun_id' => $akun->id,
                        'posisi' => $akun->posisi,
                        'nama_akun' => $akun->nama,
                        'total_debit' => $totalDebit,
                        'total_kredit' => $totalKredit,
                        'saldo_bersih' => $saldoBersih,
                    ]);
                }
            }
        }

        $bulan = $dataBulan[$req->bulan];
        $tahun = $req->tahun;
        $akuns = Akun::where('instansi_id', $data_instansi->id)->whereIn('jenis', ['PENDAPATAN', 'BEBAN'])->get();
        return Excel::download(new KomprehensifExport($saldoAkun, $bulan, $tahun, $data_instansi, $akuns), 'Komprehensif.xlsx');
    }

    public function index_posisi(Request $req, $instansi)
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
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();

            $akuns = Akun::where('instansi_id', $data_instansi->id)->orderBy('kode')->get();

        $saldoAkun = collect();

        if (isset($req->tahun) && isset($req->bulan)) {
            // Dapatkan semua akun

                $allAkun = Akun::where('instansi_id', $data_instansi->id)->get();

            foreach ($allAkun as $akun) {
                $akunData = Jurnal::orderBy('tanggal')
                    ->where(function($query) use ($akun) {
                        $query->where('akun_debit', $akun->id)
                            ->orWhere('akun_kredit', $akun->id);
                    })
                    ->whereYear('tanggal', $req->tahun)
                    ->whereMonth('tanggal', $req->bulan)
                    ->get();

                if ($akun) {
                    $tanggal = Carbon::createFromFormat('Y-m', $req->tahun . '-' . $req->bulan)->startOfMonth();
                    $tanggalSebelumnya = $tanggal->copy()->subMonth();
                    $tahunSebelumnya = $tanggalSebelumnya->year;
                    $bulanSebelumnya = $tanggalSebelumnya->format('m');

                    $bukubesar = BukuBesar::where('akun_id', $akun->id)
                        ->whereYear('tanggal', $tahunSebelumnya)
                        ->whereMonth('tanggal', $bulanSebelumnya)
                        ->first();
                        
                    $saldo_awal = $bukubesar ? $bukubesar->saldo_akhir : $akun->saldo_awal;

                    $temp_saldo = $saldo_awal;
                    $totalDebit = 0;
                    $totalKredit = 0;

                    foreach ($akunData as $item) {
                        if ($akun->posisi == 'DEBIT') {
                            if ($item->akun_kredit == $akun->id) {
                                $temp_saldo -= $item->nominal;
                                $totalKredit += $item->nominal;
                            } else if ($item->akun_debit == $akun->id) {
                                $temp_saldo += $item->nominal;
                                $totalDebit += $item->nominal;
                            }
                        } else {
                            if ($item->akun_kredit == $akun->id) {
                                $temp_saldo += $item->nominal;
                                $totalKredit += $item->nominal;
                            } else if ($item->akun_debit == $akun->id) {
                                $temp_saldo -= $item->nominal;
                                $totalDebit += $item->nominal;
                            }
                        }
                    }

                    $saldo_akhir = $temp_saldo;
                    $saldoBersih = $saldo_akhir;
                    
                    // Tentukan di mana saldo bersih ditempatkan berdasarkan posisi akun
                    $totalDebit = $akun->posisi == 'DEBIT' ? $saldoBersih : 0;
                    $totalKredit = $akun->posisi == 'KREDIT' ? $saldoBersih : 0;

                    // Tambahkan data ke koleksi
                    $saldoAkun->push([
                        'akun_id' => $akun->id,
                        'posisi' => $akun->posisi,
                        'nama_akun' => $akun->nama,
                        'total_debit' => $totalDebit,
                        'total_kredit' => $totalKredit,
                        'saldo_bersih' => $saldoBersih,
                        'tipe' => $akun->tipe,
                        'jenis' => $akun->jenis,
                    ]);
                }
            }
        }
        return view('posisi.index', compact('saldoAkun', 'tahun', 'bulan', 'akuns'));
    }

    public function pdf_posisi(Request $req, $instansi)
    {
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

        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();

        $saldoAkun = collect();

        if (isset($req->tahun) && isset($req->bulan)) {
            // Dapatkan semua akun

                $allAkun = Akun::where('instansi_id', $data_instansi->id)->get();

            foreach ($allAkun as $akun) {
                $akunData = Jurnal::orderBy('tanggal')
                    ->where(function($query) use ($akun) {
                        $query->where('akun_debit', $akun->id)
                            ->orWhere('akun_kredit', $akun->id);
                    })
                    ->whereYear('tanggal', $req->tahun)
                    ->whereMonth('tanggal', $req->bulan)
                    ->get();

                if ($akun) {
                    $tanggal = Carbon::createFromFormat('Y-m', $req->tahun . '-' . $req->bulan)->startOfMonth();
                    $tanggalSebelumnya = $tanggal->copy()->subMonth();
                    $tahunSebelumnya = $tanggalSebelumnya->year;
                    $bulanSebelumnya = $tanggalSebelumnya->format('m');

                    $bukubesar = BukuBesar::where('akun_id', $akun->id)
                        ->whereYear('tanggal', $tahunSebelumnya)
                        ->whereMonth('tanggal', $bulanSebelumnya)
                        ->first();
                        
                    $saldo_awal = $bukubesar ? $bukubesar->saldo_akhir : $akun->saldo_awal;

                    $temp_saldo = $saldo_awal;
                    $totalDebit = 0;
                    $totalKredit = 0;

                    foreach ($akunData as $item) {
                        if ($akun->posisi == 'DEBIT') {
                            if ($item->akun_kredit == $akun->id) {
                                $temp_saldo -= $item->nominal;
                                $totalKredit += $item->nominal;
                            } else if ($item->akun_debit == $akun->id) {
                                $temp_saldo += $item->nominal;
                                $totalDebit += $item->nominal;
                            }
                        } else {
                            if ($item->akun_kredit == $akun->id) {
                                $temp_saldo += $item->nominal;
                                $totalKredit += $item->nominal;
                            } else if ($item->akun_debit == $akun->id) {
                                $temp_saldo -= $item->nominal;
                                $totalDebit += $item->nominal;
                            }
                        }
                    }

                    $saldo_akhir = $temp_saldo;
                    $saldoBersih = $saldo_akhir;
                    
                    // Tentukan di mana saldo bersih ditempatkan berdasarkan posisi akun
                    $totalDebit = $akun->posisi == 'DEBIT' ? $saldoBersih : 0;
                    $totalKredit = $akun->posisi == 'KREDIT' ? $saldoBersih : 0;

                    // Tambahkan data ke koleksi
                    $saldoAkun->push([
                        'akun_id' => $akun->id,
                        'posisi' => $akun->posisi,
                        'nama_akun' => $akun->nama,
                        'total_debit' => $totalDebit,
                        'total_kredit' => $totalKredit,
                        'saldo_bersih' => $saldoBersih,
                        'tipe' => $akun->tipe,
                        'jenis' => $akun->jenis,
                    ]);
                }
            }
        }

        $bulan = $dataBulan[$req->bulan];
        $tahun = $req->tahun;
        $data = $saldoAkun->toArray();
            $akuns = Akun::where('instansi_id', $data_instansi->id)->orderBy('kode')->get()->toArray();
        $pdf = Pdf::loadView('posisi.pdf', compact('data', 'bulan', 'tahun', 'data_instansi', 'akuns'));
        return $pdf->stream('posisi.pdf');
    }

    public function excel_posisi(Request $req, $instansi)
    {
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

        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();

        $saldoAkun = collect();

        if (isset($req->tahun) && isset($req->bulan)) {
            // Dapatkan semua akun
                $allAkun = Akun::where('instansi_id', $data_instansi->id)->get();

            foreach ($allAkun as $akun) {
                $akunData = Jurnal::orderBy('tanggal')
                    ->where(function($query) use ($akun) {
                        $query->where('akun_debit', $akun->id)
                            ->orWhere('akun_kredit', $akun->id);
                    })
                    ->whereYear('tanggal', $req->tahun)
                    ->whereMonth('tanggal', $req->bulan)
                    ->get();

                if ($akun) {
                    $tanggal = Carbon::createFromFormat('Y-m', $req->tahun . '-' . $req->bulan)->startOfMonth();
                    $tanggalSebelumnya = $tanggal->copy()->subMonth();
                    $tahunSebelumnya = $tanggalSebelumnya->year;
                    $bulanSebelumnya = $tanggalSebelumnya->format('m');

                    $bukubesar = BukuBesar::where('akun_id', $akun->id)
                        ->whereYear('tanggal', $tahunSebelumnya)
                        ->whereMonth('tanggal', $bulanSebelumnya)
                        ->first();
                        
                    $saldo_awal = $bukubesar ? $bukubesar->saldo_akhir : $akun->saldo_awal;

                    $temp_saldo = $saldo_awal;
                    $totalDebit = 0;
                    $totalKredit = 0;

                    foreach ($akunData as $item) {
                        if ($akun->posisi == 'DEBIT') {
                            if ($item->akun_kredit == $akun->id) {
                                $temp_saldo -= $item->nominal;
                                $totalKredit += $item->nominal;
                            } else if ($item->akun_debit == $akun->id) {
                                $temp_saldo += $item->nominal;
                                $totalDebit += $item->nominal;
                            }
                        } else {
                            if ($item->akun_kredit == $akun->id) {
                                $temp_saldo += $item->nominal;
                                $totalKredit += $item->nominal;
                            } else if ($item->akun_debit == $akun->id) {
                                $temp_saldo -= $item->nominal;
                                $totalDebit += $item->nominal;
                            }
                        }
                    }

                    $saldo_akhir = $temp_saldo;
                    $saldoBersih = $saldo_akhir;
                    
                    // Tentukan di mana saldo bersih ditempatkan berdasarkan posisi akun
                    $totalDebit = $akun->posisi == 'DEBIT' ? $saldoBersih : 0;
                    $totalKredit = $akun->posisi == 'KREDIT' ? $saldoBersih : 0;

                    // Tambahkan data ke koleksi
                    $saldoAkun->push([
                        'akun_id' => $akun->id,
                        'posisi' => $akun->posisi,
                        'nama_akun' => $akun->nama,
                        'total_debit' => $totalDebit,
                        'total_kredit' => $totalKredit,
                        'saldo_bersih' => $saldoBersih,
                        'tipe' => $akun->tipe,
                        'jenis' => $akun->jenis,
                    ]);
                }
            }
        }

        $bulan = $dataBulan[$req->bulan];
        $tahun = $req->tahun;
            $akuns = Akun::where('instansi_id', $data_instansi->id)->orderBy('kode')->get();
        return Excel::download(new PosisiExport($saldoAkun, $bulan, $tahun, $data_instansi, $akuns), 'posisi.xlsx');
    }

    public function index_aset_netto(Request $req, $instansi)
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
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();

        $akuns = Akun::where('instansi_id', $data_instansi->id)->get();

        $saldoAkun = collect();

        if (isset($req->tahun) && isset($req->bulan)) {
            // Dapatkan semua akun
            $allAkun = Akun::where('instansi_id', $data_instansi->id)->get();

            foreach ($allAkun as $akun) {
                $akunData = Jurnal::orderBy('tanggal')
                    ->where(function($query) use ($akun) {
                        $query->where('akun_debit', $akun->id)
                            ->orWhere('akun_kredit', $akun->id);
                    })
                    ->whereYear('tanggal', $req->tahun)
                    ->whereMonth('tanggal', $req->bulan)
                    ->get();

                if ($akun) {
                    $tanggal = Carbon::createFromFormat('Y-m', $req->tahun . '-' . $req->bulan)->startOfMonth();
                    $tanggalSebelumnya = $tanggal->copy()->subMonth();
                    $tahunSebelumnya = $tanggalSebelumnya->year;
                    $bulanSebelumnya = $tanggalSebelumnya->format('m');

                    $bukubesar = BukuBesar::where('akun_id', $akun->id)
                        ->whereYear('tanggal', $tahunSebelumnya)
                        ->whereMonth('tanggal', $bulanSebelumnya)
                        ->first();
                        
                    $saldo_awal = $bukubesar ? $bukubesar->saldo_akhir : $akun->saldo_awal;

                    $temp_saldo = $saldo_awal;
                    $totalDebit = 0;
                    $totalKredit = 0;

                    foreach ($akunData as $item) {
                        if ($akun->posisi == 'DEBIT') {
                            if ($item->akun_kredit == $akun->id) {
                                $temp_saldo -= $item->nominal;
                                $totalKredit += $item->nominal;
                            } else if ($item->akun_debit == $akun->id) {
                                $temp_saldo += $item->nominal;
                                $totalDebit += $item->nominal;
                            }
                        } else {
                            if ($item->akun_kredit == $akun->id) {
                                $temp_saldo += $item->nominal;
                                $totalKredit += $item->nominal;
                            } else if ($item->akun_debit == $akun->id) {
                                $temp_saldo -= $item->nominal;
                                $totalDebit += $item->nominal;
                            }
                        }
                    }

                    $saldo_akhir = $temp_saldo;
                    $saldoBersih = $saldo_akhir;
                    
                    // Tentukan di mana saldo bersih ditempatkan berdasarkan posisi akun
                    $totalDebit = $akun->posisi == 'DEBIT' ? $saldoBersih : 0;
                    $totalKredit = $akun->posisi == 'KREDIT' ? $saldoBersih : 0;

                    // Tambahkan data ke koleksi
                    $saldoAkun->push([
                        'akun_id' => $akun->id,
                        'posisi' => $akun->posisi,
                        'nama_akun' => $akun->nama,
                        'total_debit' => $totalDebit,
                        'total_kredit' => $totalKredit,
                        'saldo_bersih' => $saldoBersih,
                    ]);
                }
            }
        }
        return view('aset_netto.index', compact('saldoAkun', 'tahun', 'bulan', 'akuns'));
    }

    public function pdf_aset_netto(Request $req, $instansi)
    {
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

        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();

        $saldoAkun = collect();

        if (isset($req->tahun) && isset($req->bulan)) {
            // Dapatkan semua akun
            $allAkun = Akun::where('instansi_id', $data_instansi->id)->get();

            foreach ($allAkun as $akun) {
                $akunData = Jurnal::orderBy('tanggal')
                    ->where(function($query) use ($akun) {
                        $query->where('akun_debit', $akun->id)
                            ->orWhere('akun_kredit', $akun->id);
                    })
                    ->whereYear('tanggal', $req->tahun)
                    ->whereMonth('tanggal', $req->bulan)
                    ->get();

                if ($akun) {
                    $tanggal = Carbon::createFromFormat('Y-m', $req->tahun . '-' . $req->bulan)->startOfMonth();
                    $tanggalSebelumnya = $tanggal->copy()->subMonth();
                    $tahunSebelumnya = $tanggalSebelumnya->year;
                    $bulanSebelumnya = $tanggalSebelumnya->format('m');

                    $bukubesar = BukuBesar::where('akun_id', $akun->id)
                        ->whereYear('tanggal', $tahunSebelumnya)
                        ->whereMonth('tanggal', $bulanSebelumnya)
                        ->first();
                        
                    $saldo_awal = $bukubesar ? $bukubesar->saldo_akhir : $akun->saldo_awal;

                    $temp_saldo = $saldo_awal;
                    $totalDebit = 0;
                    $totalKredit = 0;

                    foreach ($akunData as $item) {
                        if ($akun->posisi == 'DEBIT') {
                            if ($item->akun_kredit == $akun->id) {
                                $temp_saldo -= $item->nominal;
                                $totalKredit += $item->nominal;
                            } else if ($item->akun_debit == $akun->id) {
                                $temp_saldo += $item->nominal;
                                $totalDebit += $item->nominal;
                            }
                        } else {
                            if ($item->akun_kredit == $akun->id) {
                                $temp_saldo += $item->nominal;
                                $totalKredit += $item->nominal;
                            } else if ($item->akun_debit == $akun->id) {
                                $temp_saldo -= $item->nominal;
                                $totalDebit += $item->nominal;
                            }
                        }
                    }

                    $saldo_akhir = $temp_saldo;
                    $saldoBersih = $saldo_akhir;
                    
                    // Tentukan di mana saldo bersih ditempatkan berdasarkan posisi akun
                    $totalDebit = $akun->posisi == 'DEBIT' ? $saldoBersih : 0;
                    $totalKredit = $akun->posisi == 'KREDIT' ? $saldoBersih : 0;

                    // Tambahkan data ke koleksi
                    $saldoAkun->push([
                        'akun_id' => $akun->id,
                        'posisi' => $akun->posisi,
                        'nama_akun' => $akun->nama,
                        'total_debit' => $totalDebit,
                        'total_kredit' => $totalKredit,
                        'saldo_bersih' => $saldoBersih,
                    ]);
                }
            }
        }

        $bulan = $dataBulan[$req->bulan];
        $tahun = $req->tahun;
        $data = $saldoAkun->toArray();
        $akuns = Akun::where('instansi_id', $data_instansi->id)->get()->toArray();
        $pdf = Pdf::loadView('aset_netto.pdf', compact('data', 'bulan', 'tahun', 'data_instansi', 'akuns'));
        return $pdf->stream('aset_netto.pdf');
    }

    public function excel_aset_netto(Request $req, $instansi)
    {
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

        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();

        $saldoAkun = collect();

        if (isset($req->tahun) && isset($req->bulan)) {
            // Dapatkan semua akun
            $allAkun = Akun::where('instansi_id', $data_instansi->id)->get();

            foreach ($allAkun as $akun) {
                $akunData = Jurnal::orderBy('tanggal')
                    ->where(function($query) use ($akun) {
                        $query->where('akun_debit', $akun->id)
                            ->orWhere('akun_kredit', $akun->id);
                    })
                    ->whereYear('tanggal', $req->tahun)
                    ->whereMonth('tanggal', $req->bulan)
                    ->get();

                if ($akun) {
                    $tanggal = Carbon::createFromFormat('Y-m', $req->tahun . '-' . $req->bulan)->startOfMonth();
                    $tanggalSebelumnya = $tanggal->copy()->subMonth();
                    $tahunSebelumnya = $tanggalSebelumnya->year;
                    $bulanSebelumnya = $tanggalSebelumnya->format('m');

                    $bukubesar = BukuBesar::where('akun_id', $akun->id)
                        ->whereYear('tanggal', $tahunSebelumnya)
                        ->whereMonth('tanggal', $bulanSebelumnya)
                        ->first();
                        
                    $saldo_awal = $bukubesar ? $bukubesar->saldo_akhir : $akun->saldo_awal;

                    $temp_saldo = $saldo_awal;
                    $totalDebit = 0;
                    $totalKredit = 0;

                    foreach ($akunData as $item) {
                        if ($akun->posisi == 'DEBIT') {
                            if ($item->akun_kredit == $akun->id) {
                                $temp_saldo -= $item->nominal;
                                $totalKredit += $item->nominal;
                            } else if ($item->akun_debit == $akun->id) {
                                $temp_saldo += $item->nominal;
                                $totalDebit += $item->nominal;
                            }
                        } else {
                            if ($item->akun_kredit == $akun->id) {
                                $temp_saldo += $item->nominal;
                                $totalKredit += $item->nominal;
                            } else if ($item->akun_debit == $akun->id) {
                                $temp_saldo -= $item->nominal;
                                $totalDebit += $item->nominal;
                            }
                        }
                    }

                    $saldo_akhir = $temp_saldo;
                    $saldoBersih = $saldo_akhir;
                    
                    // Tentukan di mana saldo bersih ditempatkan berdasarkan posisi akun
                    $totalDebit = $akun->posisi == 'DEBIT' ? $saldoBersih : 0;
                    $totalKredit = $akun->posisi == 'KREDIT' ? $saldoBersih : 0;

                    // Tambahkan data ke koleksi
                    $saldoAkun->push([
                        'akun_id' => $akun->id,
                        'posisi' => $akun->posisi,
                        'nama_akun' => $akun->nama,
                        'total_debit' => $totalDebit,
                        'total_kredit' => $totalKredit,
                        'saldo_bersih' => $saldoBersih,
                    ]);
                }
            }
        }

        $bulan = $dataBulan[$req->bulan];
        $tahun = $req->tahun;
        $akuns = Akun::where('instansi_id', $data_instansi->id)->get();
        return Excel::download(new AsetNettoExport($saldoAkun, $bulan, $tahun, $data_instansi, $akuns), 'Aset_Netto.xlsx');
    }

    public function index_arus_kas(Request $req, $instansi)
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
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();

        $bulanVal = date('m');
        $tahunVal = date('Y');
        $saldo = Akun::with('bukubesar')->where('instansi_id', $data_instansi->id)->whereIn('jenis', ['KAS', 'BANK'])->whereHas('bukubesar', function($q) use($bulanVal, $tahunVal){
            $q->whereMonth('tanggal', $bulanVal)->whereYear('tanggal', $tahunVal);
        })->get()->sum(function($akun) {
            return $akun->bukubesar->sum('saldo_awal');
        });
        if($saldo == 0){
            $saldo = Akun::where('instansi_id', $data_instansi->id)->whereIn('jenis', ['KAS', 'BANK'])->sum('saldo_awal');
        }
        $akuns = Akun::where('instansi_id', $data_instansi->id)->get();


        $saldoAkun = collect();

        if (isset($req->tahun) && isset($req->bulan)) {
            // Dapatkan semua akun
            $allAkun = Akun::where('instansi_id', $data_instansi->id)->get();

            foreach ($allAkun as $akun) {
                $akunData = Jurnal::orderBy('tanggal')
                    ->where(function($query) use ($akun) {
                        $query->where('akun_debit', $akun->id)
                            ->orWhere('akun_kredit', $akun->id);
                    })
                    ->whereYear('tanggal', $req->tahun)
                    ->whereMonth('tanggal', $req->bulan)
                    ->get();

                if ($akun) {
                    $tanggal = Carbon::createFromFormat('Y-m', $req->tahun . '-' . $req->bulan)->startOfMonth();
                    $tanggalSebelumnya = $tanggal->copy()->subMonth();
                    $tahunSebelumnya = $tanggalSebelumnya->year;
                    $bulanSebelumnya = $tanggalSebelumnya->format('m');

                    $bukubesar = BukuBesar::where('akun_id', $akun->id)
                        ->whereYear('tanggal', $tahunSebelumnya)
                        ->whereMonth('tanggal', $bulanSebelumnya)
                        ->first();
                        
                    $saldo_awal = $bukubesar ? $bukubesar->saldo_akhir : $akun->saldo_awal;

                    $temp_saldo = $saldo_awal;
                    $totalDebit = 0;
                    $totalKredit = 0;

                    foreach ($akunData as $item) {
                        if ($akun->posisi == 'DEBIT') {
                            if ($item->akun_kredit == $akun->id) {
                                $temp_saldo -= $item->nominal;
                                $totalKredit += $item->nominal;
                            } else if ($item->akun_debit == $akun->id) {
                                $temp_saldo += $item->nominal;
                                $totalDebit += $item->nominal;
                            }
                        } else {
                            if ($item->akun_kredit == $akun->id) {
                                $temp_saldo += $item->nominal;
                                $totalKredit += $item->nominal;
                            } else if ($item->akun_debit == $akun->id) {
                                $temp_saldo -= $item->nominal;
                                $totalDebit += $item->nominal;
                            }
                        }
                    }

                    $saldo_akhir = $temp_saldo;
                    $saldoBersih = $saldo_akhir;
                    
                    // Tentukan di mana saldo bersih ditempatkan berdasarkan posisi akun
                    // $totalDebit = $akun->posisi == 'DEBIT' ? $saldoBersih : 0;
                    // $totalKredit = $akun->posisi == 'KREDIT' ? $saldoBersih : 0;

                    // Tambahkan data ke koleksi
                    $saldoAkun->push([
                        'akun_id' => $akun->id,
                        'posisi' => $akun->posisi,
                        'nama_akun' => $akun->nama,
                        'total_debit' => $totalDebit,
                        'total_kredit' => $totalKredit,
                        'saldo_bersih' => $saldoBersih,
                    ]);
                }
            }
        }
        return view('arus_kas.index', compact('saldoAkun', 'tahun', 'bulan', 'akuns', 'saldo'));
    }

    public function pdf_arus_kas(Request $req, $instansi)
    {
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

        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();

        $bulanVal = date('m');
        $tahunVal = date('Y');
        $saldo = Akun::with('bukubesar')->where('instansi_id', $data_instansi->id)->whereIn('jenis', ['KAS', 'BANK'])->whereHas('bukubesar', function($q) use($bulanVal, $tahunVal){
            $q->whereMonth('tanggal', $bulanVal)->whereYear('tanggal', $tahunVal);
        })->get()->sum(function($akun) {
            return $akun->bukubesar->sum('saldo_awal');
        });
        if($saldo == 0){
            $saldo = Akun::where('instansi_id', $data_instansi->id)->whereIn('jenis', ['KAS', 'BANK'])->sum('saldo_awal');
        }
        $akuns = Akun::where('instansi_id', $data_instansi->id)->get();


        $saldoAkun = collect();

        if (isset($req->tahun) && isset($req->bulan)) {
            // Dapatkan semua akun
            $allAkun = Akun::where('instansi_id', $data_instansi->id)->get();

            foreach ($allAkun as $akun) {
                $akunData = Jurnal::orderBy('tanggal')
                    ->where(function($query) use ($akun) {
                        $query->where('akun_debit', $akun->id)
                            ->orWhere('akun_kredit', $akun->id);
                    })
                    ->whereYear('tanggal', $req->tahun)
                    ->whereMonth('tanggal', $req->bulan)
                    ->get();

                if ($akun) {
                    $tanggal = Carbon::createFromFormat('Y-m', $req->tahun . '-' . $req->bulan)->startOfMonth();
                    $tanggalSebelumnya = $tanggal->copy()->subMonth();
                    $tahunSebelumnya = $tanggalSebelumnya->year;
                    $bulanSebelumnya = $tanggalSebelumnya->format('m');

                    $bukubesar = BukuBesar::where('akun_id', $akun->id)
                        ->whereYear('tanggal', $tahunSebelumnya)
                        ->whereMonth('tanggal', $bulanSebelumnya)
                        ->first();
                        
                    $saldo_awal = $bukubesar ? $bukubesar->saldo_akhir : $akun->saldo_awal;

                    $temp_saldo = $saldo_awal;
                    $totalDebit = 0;
                    $totalKredit = 0;

                    foreach ($akunData as $item) {
                        if ($akun->posisi == 'DEBIT') {
                            if ($item->akun_kredit == $akun->id) {
                                $temp_saldo -= $item->nominal;
                                $totalKredit += $item->nominal;
                            } else if ($item->akun_debit == $akun->id) {
                                $temp_saldo += $item->nominal;
                                $totalDebit += $item->nominal;
                            }
                        } else {
                            if ($item->akun_kredit == $akun->id) {
                                $temp_saldo += $item->nominal;
                                $totalKredit += $item->nominal;
                            } else if ($item->akun_debit == $akun->id) {
                                $temp_saldo -= $item->nominal;
                                $totalDebit += $item->nominal;
                            }
                        }
                    }

                    $saldo_akhir = $temp_saldo;
                    $saldoBersih = $saldo_akhir;
                    
                    // Tentukan di mana saldo bersih ditempatkan berdasarkan posisi akun
                    // $totalDebit = $akun->posisi == 'DEBIT' ? $saldoBersih : 0;
                    // $totalKredit = $akun->posisi == 'KREDIT' ? $saldoBersih : 0;

                    // Tambahkan data ke koleksi
                    $saldoAkun->push([
                        'akun_id' => $akun->id,
                        'posisi' => $akun->posisi,
                        'nama_akun' => $akun->nama,
                        'total_debit' => $totalDebit,
                        'total_kredit' => $totalKredit,
                        'saldo_bersih' => $saldoBersih,
                    ]);
                }
            }
        }

        $bulan = $dataBulan[$req->bulan];
        $tahun = $req->tahun;
        $data = $saldoAkun->toArray();
        $akuns = Akun::where('instansi_id', $data_instansi->id)->get()->toArray();
        $pdf = Pdf::loadView('arus_kas.pdf', compact('data', 'bulan', 'tahun', 'data_instansi', 'akuns', 'saldo'));
        return $pdf->stream('arus_kas.pdf');
    }

    public function excel_arus_kas(Request $req, $instansi)
    {
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

        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();

        $bulanVal = date('m');
        $tahunVal = date('Y');
        $saldo = Akun::with('bukubesar')->where('instansi_id', $data_instansi->id)->whereIn('jenis', ['KAS', 'BANK'])->whereHas('bukubesar', function($q) use($bulanVal, $tahunVal){
            $q->whereMonth('tanggal', $bulanVal)->whereYear('tanggal', $tahunVal);
        })->get()->sum(function($akun) {
            return $akun->bukubesar->sum('saldo_awal');
        });
        if($saldo == 0){
            $saldo = Akun::where('instansi_id', $data_instansi->id)->whereIn('jenis', ['KAS', 'BANK'])->sum('saldo_awal');
        }
        $akuns = Akun::where('instansi_id', $data_instansi->id)->get();


        $saldoAkun = collect();

        if (isset($req->tahun) && isset($req->bulan)) {
            // Dapatkan semua akun
            $allAkun = Akun::where('instansi_id', $data_instansi->id)->get();

            foreach ($allAkun as $akun) {
                $akunData = Jurnal::orderBy('tanggal')
                    ->where(function($query) use ($akun) {
                        $query->where('akun_debit', $akun->id)
                            ->orWhere('akun_kredit', $akun->id);
                    })
                    ->whereYear('tanggal', $req->tahun)
                    ->whereMonth('tanggal', $req->bulan)
                    ->get();

                if ($akun) {
                    $tanggal = Carbon::createFromFormat('Y-m', $req->tahun . '-' . $req->bulan)->startOfMonth();
                    $tanggalSebelumnya = $tanggal->copy()->subMonth();
                    $tahunSebelumnya = $tanggalSebelumnya->year;
                    $bulanSebelumnya = $tanggalSebelumnya->format('m');

                    $bukubesar = BukuBesar::where('akun_id', $akun->id)
                        ->whereYear('tanggal', $tahunSebelumnya)
                        ->whereMonth('tanggal', $bulanSebelumnya)
                        ->first();
                        
                    $saldo_awal = $bukubesar ? $bukubesar->saldo_akhir : $akun->saldo_awal;

                    $temp_saldo = $saldo_awal;
                    $totalDebit = 0;
                    $totalKredit = 0;

                    foreach ($akunData as $item) {
                        if ($akun->posisi == 'DEBIT') {
                            if ($item->akun_kredit == $akun->id) {
                                $temp_saldo -= $item->nominal;
                                $totalKredit += $item->nominal;
                            } else if ($item->akun_debit == $akun->id) {
                                $temp_saldo += $item->nominal;
                                $totalDebit += $item->nominal;
                            }
                        } else {
                            if ($item->akun_kredit == $akun->id) {
                                $temp_saldo += $item->nominal;
                                $totalKredit += $item->nominal;
                            } else if ($item->akun_debit == $akun->id) {
                                $temp_saldo -= $item->nominal;
                                $totalDebit += $item->nominal;
                            }
                        }
                    }

                    $saldo_akhir = $temp_saldo;
                    $saldoBersih = $saldo_akhir;
                    
                    // Tentukan di mana saldo bersih ditempatkan berdasarkan posisi akun
                    // $totalDebit = $akun->posisi == 'DEBIT' ? $saldoBersih : 0;
                    // $totalKredit = $akun->posisi == 'KREDIT' ? $saldoBersih : 0;

                    // Tambahkan data ke koleksi
                    $saldoAkun->push([
                        'akun_id' => $akun->id,
                        'posisi' => $akun->posisi,
                        'nama_akun' => $akun->nama,
                        'total_debit' => $totalDebit,
                        'total_kredit' => $totalKredit,
                        'saldo_bersih' => $saldoBersih,
                    ]);
                }
            }
        }

        $bulan = $dataBulan[$req->bulan];
        $tahun = $req->tahun;
        $akuns = Akun::where('instansi_id', $data_instansi->id)->get();
        return Excel::download(new ArusKasExport($saldoAkun, $bulan, $tahun, $data_instansi, $akuns, $saldo), 'arus_kas.xlsx');
    }

    public function index_posisi_konsolidasi(Request $req, $instansi)
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
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();

        $akuns = Akun::orderBy('kode')->get()->unique('nama');

        $saldoAkun = collect();

        if (isset($req->tahun) && isset($req->bulan)) {
            // Dapatkan semua akun
            $allAkun = Akun::all();

            foreach ($allAkun as $akun) {
                $akunData = Jurnal::orderBy('tanggal')
                    ->where(function($query) use ($akun) {
                        $query->where('akun_debit', $akun->id)
                            ->orWhere('akun_kredit', $akun->id);
                    })
                    ->whereYear('tanggal', $req->tahun)
                    ->whereMonth('tanggal', $req->bulan)
                    ->get();

                if ($akun) {
                    $tanggal = Carbon::createFromFormat('Y-m', $req->tahun . '-' . $req->bulan)->startOfMonth();
                    $tanggalSebelumnya = $tanggal->copy()->subMonth();
                    $tahunSebelumnya = $tanggalSebelumnya->year;
                    $bulanSebelumnya = $tanggalSebelumnya->format('m');

                    $bukubesar = BukuBesar::where('akun_id', $akun->id)
                        ->whereYear('tanggal', $tahunSebelumnya)
                        ->whereMonth('tanggal', $bulanSebelumnya)
                        ->first();
                        
                    $saldo_awal = $bukubesar ? $bukubesar->saldo_akhir : $akun->saldo_awal;

                    $temp_saldo = $saldo_awal;
                    $totalDebit = 0;
                    $totalKredit = 0;

                    foreach ($akunData as $item) {
                        if ($akun->posisi == 'DEBIT') {
                            if ($item->akun_kredit == $akun->id) {
                                $temp_saldo -= $item->nominal;
                                $totalKredit += $item->nominal;
                            } else if ($item->akun_debit == $akun->id) {
                                $temp_saldo += $item->nominal;
                                $totalDebit += $item->nominal;
                            }
                        } else {
                            if ($item->akun_kredit == $akun->id) {
                                $temp_saldo += $item->nominal;
                                $totalKredit += $item->nominal;
                            } else if ($item->akun_debit == $akun->id) {
                                $temp_saldo -= $item->nominal;
                                $totalDebit += $item->nominal;
                            }
                        }
                    }

                    $saldo_akhir = $temp_saldo;
                    $saldoBersih = $saldo_akhir;
                    
                    // Tentukan di mana saldo bersih ditempatkan berdasarkan posisi akun
                    $totalDebit = $akun->posisi == 'DEBIT' ? $saldoBersih : 0;
                    $totalKredit = $akun->posisi == 'KREDIT' ? $saldoBersih : 0;

                    // Tambahkan data ke koleksi
                    $saldoAkun->push([
                        'akun_id' => $akun->id,
                        'posisi' => $akun->posisi,
                        'nama_akun' => $akun->nama,
                        'total_debit' => $totalDebit,
                        'total_kredit' => $totalKredit,
                        'saldo_bersih' => $saldoBersih,
                        'tipe' => $akun->tipe,
                        'jenis' => $akun->jenis,
                    ]);
                }
            }
        }
        return view('posisi_konsolidasi.index', compact('saldoAkun', 'tahun', 'bulan', 'akuns'));
    }

    public function pdf_posisi_konsolidasi(Request $req, $instansi)
    {
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

        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();

        $saldoAkun = collect();

        if (isset($req->tahun) && isset($req->bulan)) {
            // Dapatkan semua akun
            $allAkun = Akun::all();

            foreach ($allAkun as $akun) {
                $akunData = Jurnal::orderBy('tanggal')
                    ->where(function($query) use ($akun) {
                        $query->where('akun_debit', $akun->id)
                            ->orWhere('akun_kredit', $akun->id);
                    })
                    ->whereYear('tanggal', $req->tahun)
                    ->whereMonth('tanggal', $req->bulan)
                    ->get();

                if ($akun) {
                    $tanggal = Carbon::createFromFormat('Y-m', $req->tahun . '-' . $req->bulan)->startOfMonth();
                    $tanggalSebelumnya = $tanggal->copy()->subMonth();
                    $tahunSebelumnya = $tanggalSebelumnya->year;
                    $bulanSebelumnya = $tanggalSebelumnya->format('m');

                    $bukubesar = BukuBesar::where('akun_id', $akun->id)
                        ->whereYear('tanggal', $tahunSebelumnya)
                        ->whereMonth('tanggal', $bulanSebelumnya)
                        ->first();
                        
                    $saldo_awal = $bukubesar ? $bukubesar->saldo_akhir : $akun->saldo_awal;

                    $temp_saldo = $saldo_awal;
                    $totalDebit = 0;
                    $totalKredit = 0;

                    foreach ($akunData as $item) {
                        if ($akun->posisi == 'DEBIT') {
                            if ($item->akun_kredit == $akun->id) {
                                $temp_saldo -= $item->nominal;
                                $totalKredit += $item->nominal;
                            } else if ($item->akun_debit == $akun->id) {
                                $temp_saldo += $item->nominal;
                                $totalDebit += $item->nominal;
                            }
                        } else {
                            if ($item->akun_kredit == $akun->id) {
                                $temp_saldo += $item->nominal;
                                $totalKredit += $item->nominal;
                            } else if ($item->akun_debit == $akun->id) {
                                $temp_saldo -= $item->nominal;
                                $totalDebit += $item->nominal;
                            }
                        }
                    }

                    $saldo_akhir = $temp_saldo;
                    $saldoBersih = $saldo_akhir;
                    
                    // Tentukan di mana saldo bersih ditempatkan berdasarkan posisi akun
                    $totalDebit = $akun->posisi == 'DEBIT' ? $saldoBersih : 0;
                    $totalKredit = $akun->posisi == 'KREDIT' ? $saldoBersih : 0;

                    // Tambahkan data ke koleksi
                    $saldoAkun->push([
                        'akun_id' => $akun->id,
                        'posisi' => $akun->posisi,
                        'nama_akun' => $akun->nama,
                        'total_debit' => $totalDebit,
                        'total_kredit' => $totalKredit,
                        'saldo_bersih' => $saldoBersih,
                        'tipe' => $akun->tipe,
                        'jenis' => $akun->jenis,
                    ]);
                }
            }
        }

        $bulan = $dataBulan[$req->bulan];
        $tahun = $req->tahun;
        $data = $saldoAkun->toArray();
        $akuns = Akun::orderBy('kode')->get()->unique('nama')->toArray();
        $pdf = Pdf::loadView('posisi_konsolidasi.pdf', compact('data', 'bulan', 'tahun', 'data_instansi', 'akuns'));
        return $pdf->stream('posisi_konsolidasi.pdf');
    }

    public function excel_posisi_konsolidasi(Request $req, $instansi)
    {
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

        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();

        $saldoAkun = collect();

        if (isset($req->tahun) && isset($req->bulan)) {
            // Dapatkan semua akun
            $allAkun = Akun::all();

            foreach ($allAkun as $akun) {
                $akunData = Jurnal::orderBy('tanggal')
                    ->where(function($query) use ($akun) {
                        $query->where('akun_debit', $akun->id)
                            ->orWhere('akun_kredit', $akun->id);
                    })
                    ->whereYear('tanggal', $req->tahun)
                    ->whereMonth('tanggal', $req->bulan)
                    ->get();

                if ($akun) {
                    $tanggal = Carbon::createFromFormat('Y-m', $req->tahun . '-' . $req->bulan)->startOfMonth();
                    $tanggalSebelumnya = $tanggal->copy()->subMonth();
                    $tahunSebelumnya = $tanggalSebelumnya->year;
                    $bulanSebelumnya = $tanggalSebelumnya->format('m');

                    $bukubesar = BukuBesar::where('akun_id', $akun->id)
                        ->whereYear('tanggal', $tahunSebelumnya)
                        ->whereMonth('tanggal', $bulanSebelumnya)
                        ->first();
                        
                    $saldo_awal = $bukubesar ? $bukubesar->saldo_akhir : $akun->saldo_awal;

                    $temp_saldo = $saldo_awal;
                    $totalDebit = 0;
                    $totalKredit = 0;

                    foreach ($akunData as $item) {
                        if ($akun->posisi == 'DEBIT') {
                            if ($item->akun_kredit == $akun->id) {
                                $temp_saldo -= $item->nominal;
                                $totalKredit += $item->nominal;
                            } else if ($item->akun_debit == $akun->id) {
                                $temp_saldo += $item->nominal;
                                $totalDebit += $item->nominal;
                            }
                        } else {
                            if ($item->akun_kredit == $akun->id) {
                                $temp_saldo += $item->nominal;
                                $totalKredit += $item->nominal;
                            } else if ($item->akun_debit == $akun->id) {
                                $temp_saldo -= $item->nominal;
                                $totalDebit += $item->nominal;
                            }
                        }
                    }

                    $saldo_akhir = $temp_saldo;
                    $saldoBersih = $saldo_akhir;
                    
                    // Tentukan di mana saldo bersih ditempatkan berdasarkan posisi akun
                    $totalDebit = $akun->posisi == 'DEBIT' ? $saldoBersih : 0;
                    $totalKredit = $akun->posisi == 'KREDIT' ? $saldoBersih : 0;

                    // Tambahkan data ke koleksi
                    $saldoAkun->push([
                        'akun_id' => $akun->id,
                        'posisi' => $akun->posisi,
                        'nama_akun' => $akun->nama,
                        'total_debit' => $totalDebit,
                        'total_kredit' => $totalKredit,
                        'saldo_bersih' => $saldoBersih,
                        'tipe' => $akun->tipe,
                        'jenis' => $akun->jenis,
                    ]);
                }
            }
        }

        $bulan = $dataBulan[$req->bulan];
        $tahun = $req->tahun;
        $akuns = Akun::orderBy('kode')->get()->unique('nama');
        return Excel::download(new PosisiKonsolidasiExport($saldoAkun, $bulan, $tahun, $data_instansi, $akuns), 'posisi_konsolidasi.xlsx');
    }
}
