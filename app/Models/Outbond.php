<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Outbond extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 't_outbond';
    protected $guarded = ['id'];

    public function biro()
    {
        return $this->belongsTo(Biro::class);
    }

    public function instansi()
    {
        return $this->belongsTo(Instansi::class);
    }
}
