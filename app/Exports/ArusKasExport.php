<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Collection;

class ArusKasExport implements FromView
{
    private $saldoAkun;
    private $bulan;
    private $tahun;
    private $data_instansi;
    private $akuns;
    private $saldo;

    public function __construct(Collection $saldoAkun, $bulan, $tahun, $data_instansi, $akuns, $saldo)
    {
        $this->saldoAkun = $saldoAkun;
        $this->bulan = $bulan;
        $this->tahun = $tahun;
        $this->data_instansi = $data_instansi;
        $this->akuns = $akuns;
        $this->saldo = $saldo;
    }

    public function view(): View
    {
        return view('arus_kas.excel', [
            'data' => $this->saldoAkun,
            'bulan' => $this->bulan,
            'tahun' => $this->tahun,
            'data_instansi' => $this->data_instansi,
            'akuns' => $this->akuns,
            'saldo' => $this->saldo,
        ]);
    }
}
