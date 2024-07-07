<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Kelas extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    protected $table = 't_kelas';
    protected $guarded = ['id'];
    protected static $logAttributes = [
        'instansi_id',
        'kelas',
        'tingkat',
        'created_at',
        'updated_at',
    ];

    public function instansi(){
        return $this->belongsTo(Instansi::class);
    }

    public function siswa(){
        return $this->hasMany(Siswa::class);
    }

    public function tagihan(){
        return $this->hasMany(TagihanSiswa::class, 'tingkat', 'tingkat');
    }
}
