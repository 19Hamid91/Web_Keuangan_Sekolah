<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TagihanSiswaEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $studentName;
    public $bills;
    public $totalAmount;

    public function __construct($studentName, $bills, $totalAmount)
    {
        $this->studentName = $studentName;
        $this->bills = $bills;
        $this->totalAmount = $totalAmount;
    }

    public function build()
    {
        return $this->view('tagihan_siswa.email')
                    ->with([
                        'studentName' => $this->studentName,
                        'bills' => $this->bills,
                        'totalAmount' => $this->totalAmount,
                    ]);
    }
}
