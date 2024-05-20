<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kenaikan extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];
    public function sekolah(){
        return $this->belongsTo(Sekolah::class);
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
