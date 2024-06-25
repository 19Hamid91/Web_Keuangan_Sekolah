<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Akun extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    protected $table = 't_akun';
    protected $guarded = ['id'];
    protected static $logAttributes = [
        'instansi_id',
        'kode',
        'nama',
        'tipe',
        'jenis',
        'kelompok',
        'saldo_awal',
        'created_at',
        'updated_at',
    ];

    public function bukubesar()
    {
        return $this->hasMany(BukuBesar::class);
    }
}
