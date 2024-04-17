<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tagihan extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];
    public function daftar_tagihan()
    {
        return $this->belongsTo(DaftarTagihan::class, 'kode_daftar_tagihan', 'kode');
    }
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'nis_siswa', 'nis');
    }
}
