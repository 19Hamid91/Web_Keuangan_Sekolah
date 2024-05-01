<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pegawai extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];
    public function sekolah(){
        return $this->belongsTo(Sekolah::class, 'kode_sekolah', 'kode');
    }

    public function kelas(){
        return $this->belongsTo(Kelas::class, 'kode_kelas', 'kode');
    }

    public function komponen_gaji(){
        return $this->belongsTo(KomponenGaji::class, 'kode_komponen_gaji', 'kode');
    }
}
