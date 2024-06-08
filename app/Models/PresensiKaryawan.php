<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PresensiKaryawan extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 't_presensi_karyawan';
    protected $guarded = ['id'];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'karyawan_id', 'id');
    }
}
