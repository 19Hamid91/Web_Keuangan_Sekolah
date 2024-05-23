<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Atk extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 't_atk';
    protected $guarded = ['id'];

    public function instansi()
    {
        return $this->belongsTo(Instansi::class);
    }
}
