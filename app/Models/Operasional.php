<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Operasional extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    protected $table = 't_operasional';
    protected $guarded = ['id'];
    protected static $logAttributes = [
        'instansi_id',
        'karyawan_id',
        'jenis',
        'tanggal_pembayaran',
        'jumlah_tagihan',
        'keterangan',
        'created_at',
        'updated_at',
    ];

    public  function scopeLike($query, $field, $value){
        return $query->where($field, 'LIKE', "%$value%");
    }

    public  function scopeOrLike($query, $field, $value){
        return $query->orWhere($field, 'LIKE', "%$value%");
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'karyawan_id');
    }

    public function instansi()
    {
        return $this->belongsTo(Instansi::class);
    }

    public function journals()
    {
        return $this->morphMany(Jurnal::class, 'journable');
    }
}
