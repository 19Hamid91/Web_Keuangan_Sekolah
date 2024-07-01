<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class KartuStok extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    protected $table = 't_kartustok';
    protected $guarded = ['id'];
    protected static $logAttributes = [
        'atk_id',
        'tanggal',
        'masuk',
        'keluar',
        'sisa',
        'pengambil',
        'created_at',
        'updated_at',
    ];

    public function atk()
    {
        return $this->belongsTo(Atk::class);
    }

    public function pembelian_atk()
    {
        return $this->belongsTo(PembelianAtk::class);
    }

    public function komponen_beliatk()
    {
        return $this->belongsTo(KomponenBeliAtk::class, 'komponen_beliatk_id');
    }
}
