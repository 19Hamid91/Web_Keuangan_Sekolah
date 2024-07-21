<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Collection;

class BukuBesarExport implements FromView
{
    private $getAkun;
    private $data;
    private $saldo_awal;
    private $saldo_akhir;

    public function __construct(Collection $getAkun, $data, $saldo_awal, $saldo_akhir)
    {
        $this->getAkun = $getAkun;
        $this->data = $data;
        $this->saldo_awal = $saldo_awal;
        $this->saldo_akhir = $saldo_akhir;
    }

    public function view(): View
    {
        return view('buku_besar.excel', [
            'getAkun' => $this->getAkun,
            'bukubesar' => $this->data,
            'saldo_awal' => $this->saldo_awal,
            'saldo_akhir' => $this->saldo_akhir
        ]);
    }
}
