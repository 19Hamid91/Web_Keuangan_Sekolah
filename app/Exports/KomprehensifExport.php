<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Collection;

class KomprehensifExport implements FromView
{
    private $data;
    private $bulan;
    private $tahun;
    private $data_instansi;
    private $akuns;

    public function __construct(Collection $data, $bulan, $tahun, $data_instansi, $akuns)
    {
        $this->data = $data;
        $this->bulan = $bulan;
        $this->tahun = $tahun;
        $this->data_instansi = $data_instansi;
        $this->akuns = $akuns;
    }

    public function view(): View
    {
        return view('komprehensif.excel', [
            'data' => $this->data,
            'bulan' => $this->bulan,
            'tahun' => $this->tahun,
            'data_instansi' => $this->data_instansi,
            'akuns' => $this->akuns,
        ]);
    }
}
