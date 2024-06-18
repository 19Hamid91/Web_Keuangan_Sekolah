<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Jabatan extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    protected $table = 't_jabatan';
    protected $guarded = ['id'];
    protected static $logAttributes = [
        'instansi_id',
        'jabatan',
        'gaji_pokok',
        'tunjangan_jabatan',
        'tunjangan_istrisuami',
        'tunjangan_anak',
        'uang_makan',
        'uang_lembur',
        'askes',
        'created_at',
        'updated_at',
    ];

    public function instansi()
    {
        return $this->belongsTo(Instansi::class);
    }
}
