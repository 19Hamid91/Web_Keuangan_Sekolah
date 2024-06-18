<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Jurnal extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 't_jurnal';
    protected $guarded = ['id'];
    protected static $logAttributes = [
        'instansi_id',
        'journable_type',
        'journable_id',
        'keterangan',
        'akun_debit',
        'akun_kredit',
        'nominal',
        'tanggal',
        'created_at',
        'updated_at',
    ];

    public function journable()
    {
        return $this->morphTo();
    }

    public function kredit()
    {
        return $this->belongsTo(Akun::class, 'akun_kredit');
    }

    public function debit()
    {
        return $this->belongsTo(Akun::class, 'akun_debit');
    }
}
