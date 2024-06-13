<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BukuBesar extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 't_bukubesar';
    protected $guarded = ['id'];

    public function akun()
    {
        return $this->belongsTo(Akun::class);
    }
}
