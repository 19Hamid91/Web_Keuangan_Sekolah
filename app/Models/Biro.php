<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Biro extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    protected $table = 't_biro';
    protected $guarded = ['id'];
    protected static $logAttributes = [
        'akun_id',
        'tanggal',
        'saldo_awal',
        'saldo_akhir',
        'created_at',
        'updated_at',
    ];

    public  function scopeLike($query, $field, $value){
        return $query->where($field, 'LIKE', "%$value%");
    }

    public  function scopeOrLike($query, $field, $value){
        return $query->orWhere($field, 'LIKE', "%$value%");
    }
}
