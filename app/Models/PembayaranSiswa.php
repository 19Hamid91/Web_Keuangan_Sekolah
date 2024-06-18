<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class PembayaranSiswa extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    protected $table = 't_pembayaransiswa';
    protected $guarded = ['id'];
    protected static $logAttributes = [
        'tagihan_siswa_id',
        'siswa_id',
        'tanggal',
        'total',
        'sisa',
        'tipe_pembayaran',
        'status',
        'created_at',
        'updated_at',
    ];

    public function tagihan_siswa()
    {
        return $this->belongsTo(TagihanSiswa::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
    
    public function journals()
    {
        return $this->morphMany(Jurnal::class, 'journable');
    }
}
