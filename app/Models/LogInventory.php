<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LogInventory extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];
    public function barang(){
        return $this->belongsTo(Barang::class, 'kode_barang', 'kode');
    }
    public function sekolah(){
        return $this->belongsTo(Sekolah::class, 'kode_lokasi', 'kode');
    }
    public function yayasan(){
        return $this->belongsTo(Yayasan::class, 'kode_lokasi', 'kode');
    }
}
