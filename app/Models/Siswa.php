<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Siswa extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];

    public function sekolah(){
        return $this->belongsTo(Sekolah::class);
    }

    public function kelas(){
        return $this->belongsTo(Kelas::class);
    }

    public function kenaikan(){
        return $this->hasMany(Kenaikan::class);
    }

    public function kelulusan(){
        return $this->hasOne(Kelulusan::class);
    }
}
