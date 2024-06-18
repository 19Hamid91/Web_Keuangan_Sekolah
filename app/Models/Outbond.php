<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Outbond extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    protected $table = 't_outbond';
    protected $guarded = ['id'];
    protected static $logAttributes = [
        'instansi_id',
        'biro_id',
        'tanggal_pembayaran',
        'harga_outbond',
        'tanggal_outbond',
        'tempat_outbond',
        'created_at',
        'updated_at',
    ];

    public  function scopeLike($query, $field, $value){
        return $query->where($field, 'LIKE', "%$value%");
    }

    public  function scopeOrLike($query, $field, $value){
        return $query->orWhere($field, 'LIKE', "%$value%");
    }

    public function biro()
    {
        return $this->belongsTo(Biro::class);
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
