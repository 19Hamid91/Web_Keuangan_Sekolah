<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class PengeluaranLainnya extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    protected $table = 't_pengeluaranlainnya';
    protected $guarded = ['id'];
    protected static $logAttributes = [
        'instansi_id',
        'nama',
        'tanggal',
        'nominal',
        'keterangan',
        'created_at',
        'updated_at',
    ];

    public function instansi()
    {
        return $this->belongsTo(Instansi::class);
    }
    
    public function journals()
    {
        return $this->morphMany(Jurnal::class, 'journable');
    }
}
