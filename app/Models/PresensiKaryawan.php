<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class PresensiKaryawan extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    protected $table = 't_presensi_karyawan';
    protected $guarded = ['id'];
    protected static $logAttributes = [
        'karyawan_id',
        'tahun',
        'bulan',
        'hadir',
        'sakit',
        'izin',
        'alpha',
        'lembur',
        'created_at',
        'updated_at',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'karyawan_id', 'id');
    }
}
