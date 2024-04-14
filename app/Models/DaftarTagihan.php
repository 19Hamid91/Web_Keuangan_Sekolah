<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DaftarTagihan extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];
    public function sekolah(){
        return $this->belongsTo(Sekolah::class, 'kode_sekolah', 'kode');
    }
    public function kelas(){
        return $this->belongsTo(Kelas::class, 'kode_kelas', 'kode');
    }
    public function akun(){
        return $this->belongsTo(Akun::class, 'kode_akun', 'kode');
    }
    public function transaksi(){
        return $this->belongsTo(Transaksi::class, 'kode_transaksi', 'kode');
    }
    public function yayasan(){
        return $this->belongsTo(Yayasan::class, 'kode_yayasan', 'kode');
    }
}
