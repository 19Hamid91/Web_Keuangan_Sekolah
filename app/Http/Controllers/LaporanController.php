<?php

namespace App\Http\Controllers;

use App\Exports\DonasiExport;
use App\Exports\JPIExport;
use App\Exports\OperasionalExport;
use App\Exports\OutbondExport;
use App\Exports\PemasukanLainnyaExport;
use App\Exports\PembelianAsetExport;
use App\Exports\PembelianAtkExport;
use App\Exports\PerbaikanAsetExport;
use App\Exports\RegistrasiExport;
use App\Exports\SewaKantinExport;
use App\Exports\SPPExport;
use App\Models\Aset;
use App\Models\Atk;
use App\Models\Biro;
use App\Models\Instansi;
use App\Models\Kelas;
use App\Models\Operasional;
use App\Models\Outbond;
use App\Models\Pegawai;
use App\Models\PemasukanLainnya;
use App\Models\PembayaranSiswa;
use App\Models\PembelianAset;
use App\Models\PembelianAtk;
use App\Models\PerbaikanAset;
use App\Models\Supplier;
use App\Models\Teknisi;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

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
            $query->whereHas('tagihan_siswa', function($q) use ($request) {
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
            $query->whereHas('tagihan_siswa', function($q) use ($request) {
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
            $query->whereHas('tagihan_siswa', function($q) use ($request) {
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
        $kelas = Kelas::where('instansi_id', $data_instansi->id)->get();
        return view('laporan_data.donasi', compact('kelas'));
    }

    public function print_donasi(Request $request, $instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();

        $query = PemasukanLainnya::with('donatur')->where('jenis', 'Donasi')->where('instansi_id', $data_instansi->id);

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

        $query = PembelianAset::with('supplier', 'aset')->whereHas('aset', function($q) use($data_instansi){
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

        if (!empty($request->filterAset)) {
            $query->where('aset_id', $request->filterAset);
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

        $query = PembelianAtk::with('supplier', 'atk')->whereHas('atk', function($q) use($data_instansi){
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

        if (!empty($request->filterAtk)) {
            $query->where('atk_id', $request->filterAtk);
        }

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

    public function index_Outbond($instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $biro = Biro::all();
        return view('laporan_data.outbond', compact('biro'));
    }

    public function print_Outbond(Request $request, $instansi)
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
}
