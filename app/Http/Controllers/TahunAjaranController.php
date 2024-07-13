<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use App\Models\Kelas;
use App\Models\Kelulusan;
use App\Models\Kenaikan;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class TahunAjaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $tahun_ajaran = TahunAjaran::orderByDesc('id')->get();
        return view('master.tahun_ajaran.index', compact('tahun_ajaran', 'data_instansi'));
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
        // validation
        $validator = Validator::make($req->all(), [
            'thn_ajaran' => 'required|min:9|max:9',
            'status' => 'required',
            'instansi_id' => 'required',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);
        $isDuplicate = TahunAjaran::where('thn_ajaran', $req->thn_ajaran)->first();
        if($isDuplicate) return redirect()->back()->withInput()->with('fail', 'Tahun ajaran sudah ada');

        // deactivate all data
        if($req->status == 'AKTIF'){
            $tahun_ajaran = TahunAjaran::all();
            foreach ($tahun_ajaran as $item) {
                $item->status = 'TIDAK AKTIF';
                $item->update();
            }
        }

        // save data
        $data = $req->except(['_method', '_token']);
        $check = TahunAjaran::create($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Data gagal ditambahkan');
        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TahunAjaran  $tahunAjaran
     * @return \Illuminate\Http\Response
     */
    public function show(TahunAjaran $tahunAjaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TahunAjaran  $tahunAjaran
     * @return \Illuminate\Http\Response
     */
    public function edit(TahunAjaran $tahunAjaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TahunAjaran  $tahunAjaran
     * @return \Illuminate\Http\Response
     */

    public function update(Request $req, $instansi, $id)
    {
        // Mulai Transaksi
        DB::beginTransaction();

        try {
            // validation
            $validator = Validator::make($req->all(), [
                'thn_ajaran' => 'required|min:9|max:9',
                'status' => 'required',
                'instansi_id' => 'required',
            ]);
            if ($validator->fails()) {
                DB::rollBack();
                return redirect()->back()->withInput()->with('fail', $validator->errors()->all());
            }

            $isDuplicate = TahunAjaran::where('thn_ajaran', $req->thn_ajaran)->where('id', '!=', $id)->first();
            if($isDuplicate) {
                DB::rollBack();
                return redirect()->back()->withInput()->with('fail', 'Tahun ajaran sudah ada');
            }

            $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
            
            // cek jika semua tingkat sudah ada
            if($instansi == 'smp'){
                $tingkatan = ['1', '2', '3'];
            } else {
                $tingkatan = ['KB A', 'KB B', 'TK A', 'TK B'];
            }

            $kelasTingkatan = Kelas::where('instansi_id', $data_instansi->id)
                ->whereIn('tingkat', $tingkatan)
                ->pluck('tingkat')
                ->unique()
                ->toArray();

            // Cari tingkatan yang tidak ada dalam daftar
            $tingkatanTidakLengkap = array_diff($tingkatan, $kelasTingkatan);

            if (!empty($tingkatanTidakLengkap)) {
                DB::rollBack();
                return redirect()->back()->withInput()->with('fail', 'Tingkat kelas belum komplit');
            }

            // deactivate all data
            if($req->status == 'AKTIF'){
                $tahun_ajaran = TahunAjaran::where('instansi_id', $data_instansi->id)->get();
                foreach ($tahun_ajaran as $item) {
                    $item->status = 'TIDAK AKTIF';
                    $item->update();
                }
            }

            // save data
            $data['instansi_id'] = $data_instansi->id;
            $data = $req->except(['_method', '_token']);
            $check = TahunAjaran::find($id)->update($data);
            if(!$check) {
                DB::rollBack();
                return redirect()->back()->withInput()->with('fail', 'Data gagal diupdate');
            }

            // naik kelas dan lulus
            $tahun_ajaran = TahunAjaran::where('instansi_id', $data_instansi->id)->where('status', 'AKTIF')->first();
            if($instansi == 'smp'){
                $tingkatan = ['1', '2', '3'];
            } else {
                $tingkatan = ['KB A', 'KB B', 'TK A', 'TK B'];
            }
            
            $siswas = Siswa::where('instansi_id', $data_instansi->id)->where('status', 'AKTIF')->whereHas('kelas', function($q) use($tingkatan){
                $q->where('tingkat', '!=', 'TPA');
            })->get();
            
            foreach ($siswas as $siswa) {
                $kelasSekarang = $siswa->kelas->tingkat;
                $indexKelasSekarang = array_search($kelasSekarang, $tingkatan);

                if ($indexKelasSekarang !== false) {
                    if ($indexKelasSekarang < count($tingkatan) - 1) { // naik kelas
                        $kelasBerikutnya = $tingkatan[$indexKelasSekarang + 1];
                        $kelasBaru = Kelas::where('instansi_id', $data_instansi->id)
                        ->where('tingkat', $kelasBerikutnya)
                        ->where('kelas', $siswa->kelas->kelas)
                        ->first();
        
                        if (!$kelasBaru) {
                            $kelasBaru = Kelas::where('instansi_id', $data_instansi->id)
                                ->where('tingkat', $kelasBerikutnya)
                                ->inRandomOrder()
                                ->first();
                        }

                        Kenaikan::create([
                            'instansi_id' => $data_instansi->id,
                            'kelas_awal' => $siswa->kelas_id,
                            'kelas_akhir' => $kelasBaru->id,
                            'tahun_ajaran_id' => $tahun_ajaran->id,
                            'siswa_id' => $siswa->id,
                            'tanggal' => now(),
                        ]);

                        $siswa->kelas_id = $kelasBaru->id;
                        $siswa->save();
                    } else { // lulus
                        Kelulusan::create([
                            'instansi_id' => $data_instansi->id,
                            'tahun_ajaran_id' => $tahun_ajaran->id,
                            'kelas_id' => $siswa->kelas_id,
                            'siswa_id' => $siswa->id,
                            'tanggal' => now(),
                        ]);
                        $siswa->status = 'TIDAK AKTIF';
                        $siswa->save();
                    }
                } else {
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Gagal update data');
                }
            }
            DB::commit();
            return redirect()->back()->with('success', 'Data berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('fail', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TahunAjaran  $tahunAjaran
     * @return \Illuminate\Http\Response
     */
    public function destroy($instansi, $id)
    {
        $data = TahunAjaran::find($id);
        $isActive = $data->status == 'AKTIF' ? true : false;
        if(!$data) return response()->json(['msg' => 'Data tidak ditemukan'], 404);
        $check = $data->delete();
        if(!$check) return response()->json(['msg' => 'Gagal menghapus data'], 400);
        if($isActive){
            $latest = TahunAjaran::latest()->first();
            $latest->status = 'AKTIF';
            $latest->update();
        }
        return response()->json(['msg' => 'Data berhasil dihapus']);
    }
}
