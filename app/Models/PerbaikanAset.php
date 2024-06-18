<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class PerbaikanAset extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    protected $table = 't_perbaikan_aset';
    protected $guarded = ['id'];
    protected static $logAttributes = [
        'instansi_id',
        'teknisi_id',
        'aset_id',
        'tanggal',
        'jenis',
        'harga',
        'created_at',
        'updated_at',
    ];

    public  function scopeLike($query, $field, $value){
        return $query->where($field, 'LIKE', "%$value%");
    }

    public  function scopeOrLike($query, $field, $value){
        return $query->orWhere($field, 'LIKE', "%$value%");
    }

    public function teknisi()
    {
        return $this->belongsTo(Teknisi::class);
    }

    public function aset()
    {
        return $this->belongsTo(Aset::class);
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
