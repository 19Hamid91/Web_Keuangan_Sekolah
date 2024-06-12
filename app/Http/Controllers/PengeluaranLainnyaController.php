<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\Biro;
use App\Models\Instansi;
use App\Models\Jurnal;
use App\Models\Operasional;
use App\Models\Outbond;
use App\Models\Pegawai;
use App\Models\PerbaikanAset;
use App\Models\Teknisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $isPerbaikan = $req->has('teknisi_id');
        $isOutbond = $req->has('biro_id');
        $isOperasional = $req->has('karyawan_id');

        if (($isPerbaikan && $isOutbond) || ($isPerbaikan && $isOperasional) || ($isOutbond && $isOperasional)) {
            return redirect()->back()->withInput()->with('fail', 'Hanya satu jenis form yang boleh diisi.');
        }

        if ($isPerbaikan) {
            $validator = Validator::make($req->all(), [
                'teknisi_id' => 'required|exists:t_teknisi,id',
                'aset_id' => 'required|exists:t_aset,id',
                'tanggal' => 'required|date',
                'jenis' => 'required|string',
                'harga' => 'required|numeric',
            ]);
        } elseif ($isOutbond) {
            $validator = Validator::make($req->all(), [
                'biro_id' => 'required|exists:t_biro,id',
                'tanggal_pembayaran' => 'required|date',
                'harga_outbond' => 'required|numeric',
                'tanggal_outbond' => 'required|date',
                'tempat_outbond' => 'required|string',
            ]);
        } elseif ($isOperasional) {
            $validator = Validator::make($req->all(), [
                'karyawan_id' => 'required|exists:t_gurukaryawan,id',
                'jenis' => 'required|string',
                'tanggal_pembayaran' => 'required|date',
                'jumlah_tagihan' => 'required|numeric',
                'keterangan' => 'required',
            ]);
        } else {
            return redirect()->back()->withInput()->with('fail', 'Tidak ada jenis form yang terdeteksi.');
        }
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);

        $data = $req->except(['_method', '_token']);

        // save data
        if ($isPerbaikan) {
            $check = PerbaikanAset::create($data);
            // jurnal
            $jurnal = new Jurnal([
                'instansi_id' => $data_instansi->id,
                'keterangan' => 'Perbaikan aset: ' . $check->aset->nama_aset,
                'nominal' => $check->harga,
                'akun_debit' => null,
                'akun_kredit' => null,
            ]);
            $check->journals()->save($jurnal);
        } elseif ($isOutbond) {
            $check = Outbond::create($data);
            // jurnal
            $jurnal = new Jurnal([
                'instansi_id' => $data_instansi->id,
                'keterangan' => 'Pengeluaran Outbond ' . formatTanggal($check->tanggal_outbond),
                'nominal' => $check->harga_outbond,
                'akun_debit' => null,
                'akun_kredit' => null,
            ]);
            $check->journals()->save($jurnal);
        } elseif ($isOperasional) {
            $check = Operasional::create($data);
            // jurnal
            $jurnal = new Jurnal([
                'instansi_id' => $data_instansi->id,
                'keterangan' => 'Pengeluaran Operasional: ' . $check->jenis,
                'nominal' => $check->jumlah_tagihan,
                'akun_debit' => null,
                'akun_kredit' => null,
            ]);
            $check->journals()->save($jurnal);
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
                $teknisi = Teknisi::all();
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
                $data = Operasional::find($id);
                return view('pengeluaran_lainnya.show', compact('pengeluaran_lainnya', 'karyawan', 'data', 'data_instansi'));
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
                $teknisi = Teknisi::all();
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
                $data = Operasional::find($id);
                return view('pengeluaran_lainnya.edit', compact('pengeluaran_lainnya', 'karyawan', 'data', 'data_instansi'));
                break;
            default:
                return redirect()->back()->withInput()->with('fail', 'Jenis tidak terdaftar');
                break;
        }
    }

    public function update(Request $req, $instansi, $pengeluaran_lainnya, $id)
    {
        $isPerbaikan = $req->has('teknisi_id');
        $isOutbond = $req->has('biro_id');
        $isOperasional = $req->has('karyawan_id');

        if (($isPerbaikan && $isOutbond) || ($isPerbaikan && $isOperasional) || ($isOutbond && $isOperasional)) {
            return redirect()->back()->withInput()->with('fail', 'Hanya satu jenis form yang boleh diisi.');
        }

        if ($isPerbaikan) {
            $validator = Validator::make($req->all(), [
                'teknisi_id' => 'required|exists:t_teknisi,id',
                'aset_id' => 'required|exists:t_aset,id',
                'tanggal' => 'required|date',
                'jenis' => 'required|string',
                'harga' => 'required|numeric',
            ]);
        } elseif ($isOutbond) {
            $validator = Validator::make($req->all(), [
                'biro_id' => 'required|exists:t_biro,id',
                'tanggal_pembayaran' => 'required|date',
                'harga_outbond' => 'required|numeric',
                'tanggal_outbond' => 'required|date',
                'tempat_outbond' => 'required|string',
            ]);
        } elseif ($isOperasional) {
            $validator = Validator::make($req->all(), [
                'karyawan_id' => 'required|exists:t_gurukaryawan,id',
                'jenis' => 'required|string',
                'tanggal_pembayaran' => 'required|date',
                'jumlah_tagihan' => 'required|numeric',
                'keterangan' => 'required',
            ]);
        } else {
            return redirect()->back()->withInput()->with('fail', 'Tidak ada jenis form yang terdeteksi.');
        }
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);

        $data = $req->except(['_method', '_token']);

        // save data
        if ($isPerbaikan) {
            $check = PerbaikanAset::find($id)->update($data);
            // jurnal
            $dataJournal = [
                'keterangan' => 'Perbaikan aset: ' . PerbaikanAset::find($id)->aset->nama_aset,
                'nominal' => PerbaikanAset::find($id)->harga,
            ];
            $journal = PerbaikanAset::find($id)->journals()->first();
            $journal->update($dataJournal);
        } elseif ($isOutbond) {
            $check = Outbond::find($id)->update($data);
            // jurnal
            $dataJournal = [
                'keterangan' => 'Pengeluaran Outbond ' . formatTanggal(Outbond::find($id)->tanggal_outbond),
                'nominal' => Outbond::find($id)->harga_outbond,
            ];
            $journal = Outbond::find($id)->journals()->first();
            $journal->update($dataJournal);
        } elseif ($isOperasional) {
            $check = Operasional::find($id)->update($data);
            // jurnal
            $dataJournal = [
                'keterangan' => 'Pengeluaran Operasional: ' . Operasional::find($id)->jenis,
                'nominal' => Operasional::find($id)->jumlah_tagihan,
            ];
            $journal = Operasional::find($id)->journals()->first();
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
            case 'Outbond':
                $data = Outbond::find($id);
                break;
            case 'Operasional':
                $data = Operasional::find($id);
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
                    'teknisi_id' => $pengeluaran->teknisi->nama,
                    'aset_id' => $pengeluaran->aset->nama_aset,
                    'tanggal' => formattanggal($pengeluaran->tanggal),
                    'jenis' => $pengeluaran->jenis,
                    'harga' => formatRupiah($pengeluaran->harga),
                    'id' => $pengeluaran->id,
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
                    'biro_id' => $pengeluaran->biro->nama,
                    'tanggal_pembayaran' => formatTanggal($pengeluaran->tanggal_pembayaran),
                    'harga_outbond' => formatRupiah($pengeluaran->harga_outbond),
                    'tanggal_outbond' => formatTanggal($pengeluaran->tanggal_outbond),
                    'tempat_outbond' => $pengeluaran->tempat_outbond,
                    'id' => $pengeluaran->id,
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
                      });
            }

            $totalRecords = $query->count();
            $filteredRecords = $totalRecords;
    
            $pengeluaran_lainnya = $query->skip($req->start)
                                        ->take($req->length)
                                        ->get();
    
            foreach ($pengeluaran_lainnya as $pengeluaran) {
                $data[] = [
                    'karyawan_id' => $pengeluaran->pegawai->nama_gurukaryawan,
                    'jenis' => $pengeluaran->jenis,
                    'tanggal_pembayaran' => formatTanggal($pengeluaran->tanggal_pembayaran),
                    'jumlah_tagihan' => formatRupiah($pengeluaran->jumlah_tagihan),
                    'keterangan' => $pengeluaran->keterangan,
                    'id' => $pengeluaran->id,
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
