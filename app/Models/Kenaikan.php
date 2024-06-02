<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kenaikan extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 't_kenaikan';
    protected $guarded = ['id'];
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
