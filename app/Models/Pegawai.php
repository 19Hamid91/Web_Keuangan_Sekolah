<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pegawai extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 't_gurukaryawan';
    protected $guarded = ['id'];
    public function instansi(){
        return $this->belongsTo(Instansi::class);
    }

    public function kelas(){
        return $this->belongsTo(Kelas::class,);
    }
}
