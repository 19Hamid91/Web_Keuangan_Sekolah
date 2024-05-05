<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KomponenGaji extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];
    public function transaksi(){
        return $this->belongsTo(Transaksi::class, 'kode_transaksi', 'kode');
    }
}
