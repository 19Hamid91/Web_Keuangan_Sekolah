<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\Instansi;
use App\Models\Jurnal;
use App\Models\PembelianAset;
use App\Models\PembelianAtk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JurnalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $akuns = Akun::all();
        $types = [ // list yang masuk jurnal
            PembelianAset::class,
            PembelianAtk::class,
        ];
        
        $data = collect();
        
        foreach ($types as $type) {
            $data = $data->merge(
                Jurnal::where('journable_type', $type)
                    ->whereHasMorph('journable', [$type], function($query) use ($type, $data_instansi) {
                        $query->when($type === PembelianAset::class, function($query) use ($data_instansi) { //pembelian aset
                            return $query->whereHas('aset.instansi', function($query) use ($data_instansi) {
                                $query->where('id', $data_instansi->id);
                            });
                        });
                        $query->when($type === PembelianAtk::class, function($query) use ($data_instansi) { //pembelian atk
                            return $query->whereHas('atk.instansi', function($query) use ($data_instansi) {
                                $query->where('id', $data_instansi->id);
                            });
                        });
                    })->get()
            );
        }
        return view('jurnal.index', compact('akuns', 'data'));
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
            'id.*' => 'required|integer', // Validasi setiap elemen di dalam array 'id' harus ada dan berupa integer
            'akun_debit.*' => 'nullable|integer', // Validasi setiap elemen di dalam array 'akun_debit' boleh kosong (nullable) atau berupa integer
            'akun_kredit.*' => 'nullable|integer', // Validasi setiap elemen di dalam array 'akun_kredit' boleh kosong (nullable) atau berupa integer
        ];
        
        $messages = [
            'id.*.required' => 'ID harus diisi.',
            'id.*.integer' => 'ID harus berupa bilangan bulat.',
            'akun_debit.*.integer' => 'Akun debit harus berupa bilangan bulat.',
            'akun_kredit.*.integer' => 'Akun kredit harus berupa bilangan bulat.',
        ];

        $validator = Validator::make($req->all(), $rules, $messages);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return redirect()->back()->withInput()->with('fail', $errors);
        } else {
            for ($i=0; $i < count($data['id']); $i++) { 
                $jurnal = Jurnal::find($data['id'][$i]);
                if(!$jurnal) return redirect()->back()->withInput()->with('fail', 'Jurnal tidak ditemukan');
                
                if(isset($data['akun_debit'][$i])){
                    $jurnal->akun_debit = $data['akun_debit'][$i];
                }
                if(isset($data['akun_kredit'][$i])){
                    $jurnal->akun_debit = $data['akun_kredit'][$i];
                }
                $check = $jurnal->update();
                if(!$check) return redirect()->back()->withInput()->with('fail', 'Gagal meyimpan data');
            }
            return redirect()->back()->with('success', 'Data berhasil ditambahkan');
        }
    }
}
