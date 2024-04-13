<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaksi extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];
    public function akun(){
        return $this->belongsTo(Akun::class, 'kode_akun', 'kode');
    }
}
