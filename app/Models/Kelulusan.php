<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kelulusan extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 't_kelulusan';
    protected $guarded = ['id'];
    public function instansi(){
        return $this->belongsTo(Instansi::class);
    }
    public function tahun_ajaran(){
        return $this->belongsTo(TahunAjaran::class);
    }
    public function kelas(){
        return $this->belongsTo(Kelas::class);
    }
    public function siswa(){
        return $this->belongsTo(Siswa::class);
    }
}
