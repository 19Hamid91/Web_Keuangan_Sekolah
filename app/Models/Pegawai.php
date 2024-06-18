<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Pegawai extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    protected $table = 't_gurukaryawan';
    protected $guarded = ['id'];
    protected static $logAttributes = [
        'user_id',
        'instansi_id',
        'jabatan_id',
        'nip',
        'nama_gurukaryawan',
        'alamat_gurukaryawan',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'no_hp_gurukaryawan',
        'status_kawin',
        'status',
        'jumlah_anak',
        'created_at',
        'updated_at',
    ];

    public  function scopeLike($query, $field, $value){
        return $query->where($field, 'LIKE', "%$value%");
    }

    public  function scopeOrLike($query, $field, $value){
        return $query->orWhere($field, 'LIKE', "%$value%");
    }
    
    public function instansi(){
        return $this->belongsTo(Instansi::class);
    }

    public function kelas(){
        return $this->belongsTo(Kelas::class);
    }

    public function jabatan(){
        return $this->belongsTo(Jabatan::class);
    }

    public function presensi(){
        return $this->hasMany(PresensiKaryawan::class, 'karyawan_id');
    }
}
