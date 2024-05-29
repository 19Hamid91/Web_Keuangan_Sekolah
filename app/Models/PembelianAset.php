<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PembelianAset extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 't_beliaset';
    protected $guarded = ['id'];

    public function aset()
    {
        return $this->belongsTo(Aset::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function penyusutan(){
        return $this->hasMnay(KartuPenyusutan::class);
    }
}