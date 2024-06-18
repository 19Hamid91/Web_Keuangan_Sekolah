<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class TahunAjaran extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    protected $table = 't_thnajaran';
    protected $guarded = ['id'];
    protected static $logAttributes = [
        'thn_ajaran',
        'status',
        'created_at',
        'updated_at',
    ];
}
