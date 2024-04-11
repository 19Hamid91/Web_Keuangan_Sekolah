<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sekolah extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];

    public function siswa(){
        return $this->hasMany(Siswa::class, 'kode', 'kode_sekolah');
    }
}
