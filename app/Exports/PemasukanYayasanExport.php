<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Collection;

class PemasukanYayasanExport implements FromView
{
    private $data;

    public function __construct(Collection $data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('excel.yayasan', [
            'data' => $this->data,
        ]);
    }
}
