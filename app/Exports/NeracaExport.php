<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Collection;

class NeracaExport implements FromView
{
    private $data;
    private $bulan;
    private $tahun;

    public function __construct(Collection $data, $bulan, $tahun)
    {
        $this->data = $data;
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function view(): View
    {
        return view('neraca.excel', [
            'data' => $this->data,
            'bulan' => $this->bulan,
            'tahun' => $this->tahun,
        ]);
    }
}
