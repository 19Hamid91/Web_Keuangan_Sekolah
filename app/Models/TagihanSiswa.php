<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class TagihanSiswa extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    protected $table = 't_tagihan_siswa';
    protected $guarded = ['id'];
    protected static $logAttributes = [
        'instansi_id',
        'tahun_ajaran_id',
        'kelas_id',
        'jenis_tagihan',
        'mulai_bayar',
        'akhir_bayar',
        'jumlah_pembayaran',
        'nominal',
        'created_at',
        'updated_at',
    ];

    public function instansi()
    {
        return $this->belongsTo(Instansi::class);
    }

    public function tahun_ajaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}
