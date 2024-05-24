<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PembelianAtk extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 't_beliatk';
    protected $guarded = ['id'];

    public function atk()
    {
        return $this->belongsTo(Atk::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
