<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;


class Kenaikan extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    protected $table = 't_kenaikan';
    protected $guarded = ['id'];
    protected static $logAttributes = [
        'instansi_id',
        'tahun_ajaran_id',
        'siswa_id',
        'kelas_awal',
        'kelas_akhir',
        'tanggal',
        'created_at',
        'updated_at',
    ];

    public function instansi(){
        return $this->belongsTo(Instansi::class);
    }
    public function tahun_ajaran(){
        return $this->belongsTo(TahunAjaran::class);
    }
    public function awal(){
        return $this->belongsTo(Kelas::class, 'kelas_awal', 'id');
    }
    public function akhir(){
        return $this->belongsTo(Kelas::class, 'kelas_akhir', 'id');
    }
    public function siswa(){
        return $this->belongsTo(Siswa::class);
    }
}
