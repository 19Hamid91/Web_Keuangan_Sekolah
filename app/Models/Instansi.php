<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Instansi extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    protected $table = 't_instansi';
    protected $guarded = ['id'];

    public function siswa(){
        return $this->hasMany(Siswa::class);
    }
    public function pegawai(){
        return $this->hasMany(Pegawai::class);
    }
    public function kelas(){
        return $this->hasMany(Kelas::class);
    }
}
