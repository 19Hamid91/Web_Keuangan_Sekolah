<?php

namespace App\Http\Controllers;

use App\Exports\DonasiExport;
use App\Exports\JPIExport;
use App\Exports\SPPExport;
use App\Models\Instansi;
use App\Models\Kelas;
use App\Models\PemasukanLainnya;
use App\Models\PembayaranSiswa;
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
                $pdf = PDF::loadView('pdf.spp', compact('data')); // Sesuaikan dengan nama view PDF Anda
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
                $pdf = PDF::loadView('pdf.jpi', compact('data')); // Sesuaikan dengan nama view PDF Anda
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
                $pdf = PDF::loadView('pdf.registrasi', compact('data')); // Sesuaikan dengan nama view PDF Anda
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

        $query = PemasukanLainnya::with('donatur')->where('jenis', 'Donasi');

        if (!empty($request->filterDateStart)) {
            $query->whereDate('tanggal', '>=', $request->filterDateStart);
        }

        if (!empty($request->filterDateEnd)) {
            $query->whereDate('tanggal', '<=', $request->filterDateEnd);
        }

        if ($request->has('export')) {
            if ($request->export == 'pdf') {
                $data = $query->get()->toArray();
                $pdf = PDF::loadView('pdf.donasi', compact('data')); // Sesuaikan dengan nama view PDF Anda
                return $pdf->download('Donasi.pdf');
            } elseif ($request->export == 'excel') {
                $data = $query->get();
                return Excel::download(new DonasiExport($data), 'Donasi.xlsx');
            }
        }
    }
}
