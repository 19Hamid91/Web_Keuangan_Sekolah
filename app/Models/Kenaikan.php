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
        return $this->belongsTo(Sekolah::class, 'kode_sekolah', 'kode');
    }
    public function tahun_ajaran(){
        return $this->belongsTo(TahunAjaran::class, 'kode_tahun_ajaran', 'kode');
    }
    public function kelas_awal(){
        return $this->belongsTo(Kelas::class, 'kode_kelas_awal', 'kode');
    }
    public function kelas_akhir(){
        return $this->belongsTo(Kelas::class, 'kode_kelas_akhir', 'kode');
    }
    public function siswa(){
        return $this->belongsTo(Siswa::class, 'nis_siswa', 'nis');
    }
}
