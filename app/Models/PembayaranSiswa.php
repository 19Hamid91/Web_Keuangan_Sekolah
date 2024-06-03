<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PembayaranSiswa extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 't_pembayaransiswa';
    protected $guarded = ['id'];

    public function tagihan_siswa()
    {
        return $this->belongsTo(TagihanSiswa::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
