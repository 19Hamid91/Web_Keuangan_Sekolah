<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Penggajian extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    protected $table = 't_penggajian';
    protected $guarded = ['id'];
    protected static $logAttributes = [
        'karyawan_id',
        'jabatan_id',
        'presensi_karyawan_id',
        'potongan_bpjs',
        'potongan_lainnya',
        'total_gaji',
        'created_at',
        'updated_at',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'karyawan_id');
    }

    public function presensi()
    {
        return $this->belongsTo(PresensiKaryawan::class, 'presensi_karyawan_id');
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }

    public function journals()
    {
        return $this->morphMany(Jurnal::class, 'journable');
    }
}
