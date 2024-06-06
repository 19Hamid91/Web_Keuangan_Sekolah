<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\Biro;
use App\Models\Instansi;
use App\Models\Operasional;
use App\Models\Outbond;
use App\Models\Pegawai;
use App\Models\PerbaikanAset;
use App\Models\Teknisi;
use Illuminate\Http\Request;
use PHPUnit\Framework\Constraint\Operator;
use Symfony\Component\Console\Output\Output;

class PengeluaranLainnyaController extends Controller
{
    public function index($instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        // $atk = Atk::orderByDesc('id')->where('instansi_id', $data_instansi->id)->get();
        return view('pengeluaran_lainnya.index');
    }

    public function create($instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $teknisi = Teknisi::all();
        $aset = Aset::where('instansi_id', $data_instansi->id)->get();
        $biro = Biro::all();
        $karyawan = Pegawai::where('instansi_id', $data_instansi->id)->get();

        return view('pengeluaran_lainnya.create', compact('data_instansi', 'teknisi', 'aset', 'biro', 'karyawan'));
    }

    public function store(Request $req, $instansi)
    {
        dd($req);
    }

    public function getData($instansi, Request $req)
    {
        $data = [];
        $totalRecords = 0;
        $filteredRecords = 0;
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
    
        if ($req->filterJenis == 'Perbaikan Aset') {
            $query = PerbaikanAset::where('instansi_id', $data_instansi->id);
            $totalRecords = $query->count();
            $filteredRecords = $totalRecords;
    
            $pengeluaran_lainnya = $query->skip($req->start)
                                        ->take($req->length)
                                        ->get();
    
            foreach ($pengeluaran_lainnya as $pengeluaran) {
                $data[] = [
                    'asset_name' => $pengeluaran->asset_name,
                    'repair_date' => $pengeluaran->repair_date,
                    'cost' => $pengeluaran->cost,
                    'vendor' => $pengeluaran->vendor,
                ];
            }
        } elseif ($req->filterJenis == 'Outbond') {
            $query = Outbond::where('instansi_id', $data_instansi->id);
            $totalRecords = $query->count();
            $filteredRecords = $totalRecords;
    
            $pengeluaran_lainnya = $query->skip($req->start)
                                        ->take($req->length)
                                        ->get();
    
            foreach ($pengeluaran_lainnya as $pengeluaran) {
                $data[] = [
                    'event_name' => $pengeluaran->event_name,
                    'date' => $pengeluaran->date,
                    'location' => $pengeluaran->location,
                    'participants' => $pengeluaran->participants,
                ];
            }
        } elseif ($req->filterJenis == 'Operasional') {
            $query = Operasional::where('instansi_id', $data_instansi->id);
            $totalRecords = $query->count();
            $filteredRecords = $totalRecords;
    
            $pengeluaran_lainnya = $query->skip($req->start)
                                        ->take($req->length)
                                        ->get();
    
            foreach ($pengeluaran_lainnya as $pengeluaran) {
                $data[] = [
                    'operation_type' => $pengeluaran->operation_type,
                    'date' => $pengeluaran->date,
                    'cost' => $pengeluaran->cost,
                    'department' => $pengeluaran->department,
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
}
