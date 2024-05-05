<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GajiPegawai extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];
    public function pegawai(){
        return $this->belongsTo(Pegawai::class, 'nip', 'nip');
    }
    public function komponen_gaji(){
        return $this->belongsTo(KomponenGaji::class, 'kode_komponen_gaji', 'kode');
    }
}
