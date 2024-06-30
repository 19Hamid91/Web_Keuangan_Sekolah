<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class HonorDokter extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    protected $table = 't_honor_dokter';
    protected $guarded = ['id'];
    protected static $logAttributes = [
        'instansi_id',
        'pengurus_id',
        'tanggal',
        'total_jam_kerja',
        'honor_harian',
        'total_honor',
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

    public function instansi()
    {
        return $this->belongsTo(Instansi::class);
    }

    public function journals()
    {
        return $this->morphMany(Jurnal::class, 'journable');
    }

    public function pengurus()
    {
        return $this->belongsTo(Pengurus::class);
    }
}
