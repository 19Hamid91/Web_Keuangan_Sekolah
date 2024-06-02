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
}
