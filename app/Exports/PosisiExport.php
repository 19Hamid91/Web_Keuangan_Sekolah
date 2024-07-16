<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Collection;

class PosisiExport implements FromView
{
    private $saldoAkun;
    private $bulan;
    private $tahun;
    private $data_instansi;
    private $akuns;

    public function __construct(Collection $saldoAkun, $bulan, $tahun, $data_instansi, $akuns)
    {
        $this->saldoAkun = $saldoAkun;
        $this->bulan = $bulan;
        $this->tahun = $tahun;
        $this->data_instansi = $data_instansi;
        $this->akuns = $akuns;
    }

    public function view(): View
    {
        return view('posisi.excel', [
            'data' => $this->saldoAkun,
            'bulan' => $this->bulan,
            'tahun' => $this->tahun,
            'data_instansi' => $this->data_instansi,
            'akuns' => $this->akuns,
        ]);
    }
}
