<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Siswa extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    protected $table = 't_siswa';
    protected $guarded = ['id'];
    protected static $logAttributes = [
        'instansi_id',
        'kelas_id',
        'nama_siswa',
        'nis',
        'nohp_siswa',
        'alamat_siswa',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'nama_wali_siswa',
        'pekerjaan_wali_siswa',
        'nohp_wali_siswa',
        'status',
        'created_at',
        'updated_at',
    ];

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

    public function pembayaran(){
        return $this->hasMany(PembayaranSiswa::class);
    }
}
