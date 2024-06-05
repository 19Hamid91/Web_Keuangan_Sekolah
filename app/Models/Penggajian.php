<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penggajian extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 't_penggajian';
    protected $guarded = ['id'];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'karyawan_id');
    }

    public function presensi()
    {
        return $this->belongsTo(PresensiKaryawan::class);
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }
}
