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
        return $this->hasMany(Pegawai::class, 'nip', 'nip');
    }
}
