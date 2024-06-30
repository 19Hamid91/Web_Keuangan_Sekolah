<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class PemasukanLainnya extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    protected $table = 't_pemasukanlainnya';
    protected $guarded = ['id'];
    protected static $logAttributes = [
        'instansi_id',
        'donatur_id',
        'donatur',
        'jenis',
        'tanggal',
        'total',
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

    public function donasi()
    {
        return $this->belongsTo(Donatur::class);
    }

    public function penyewa()
    {
        return $this->belongsTo(PenyewaKantin::class, 'penyewa_id');
    }
}
