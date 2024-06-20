<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Donatur extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    protected $table = 't_donatur';
    protected $guarded = ['id'];
    protected static $logAttributes = [
        'akun_id',
        'tanggal',
        'saldo_awal',
        'saldo_akhir',
        'created_at',
        'updated_at',
    ];
}
