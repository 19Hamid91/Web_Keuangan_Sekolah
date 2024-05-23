<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Siswa extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 't_siswa';
    protected $guarded = ['id'];

    public function instansi(){
        return $this->belongsTo(Instansi::class);
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
