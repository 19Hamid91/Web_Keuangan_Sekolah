<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pembayaran extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];
    public function tagihan(){
        return $this->belongsTo(Tagihan::class, 'kode_tagihan', 'kode');
    }
}
