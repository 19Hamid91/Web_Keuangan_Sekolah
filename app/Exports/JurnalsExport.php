<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Collection;

class JurnalsExport implements FromView
{
    private $data;
    private $totalNominal;

    public function __construct(Collection $data)
    {
        $this->data = $data;
        $this->totalNominal = $data->sum('nominal');
    }

    public function view(): View
    {
        return view('jurnal.excel', [
            'jurnals' => $this->data,
            'totalNominal' => $this->totalNominal
        ]);
    }
}

