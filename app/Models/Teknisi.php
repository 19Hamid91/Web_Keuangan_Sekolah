<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teknisi extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 't_teknisi';
    protected $guarded = ['id'];

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
