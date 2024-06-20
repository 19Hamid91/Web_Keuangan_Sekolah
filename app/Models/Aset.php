<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Aset extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    protected $table = 't_aset';
    protected $guarded = ['id'];
    protected static $logAttributes = [
        'instansi_id',
        'nama_aset',
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
}
