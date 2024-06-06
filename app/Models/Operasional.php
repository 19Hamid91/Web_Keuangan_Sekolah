<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Operasional extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 't_operasional';
    protected $guarded = ['id'];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'karyawan_id');
    }

    public function instansi()
    {
        return $this->belongsTo(Instansi::class);
    }
}
