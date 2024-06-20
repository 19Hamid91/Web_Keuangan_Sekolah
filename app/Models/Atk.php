<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;


class Atk extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    protected $table = 't_atk';
    protected $guarded = ['id'];
    protected static $logAttributes = [
        'instansi_id',
        'nama_atk',
        'created_at',
        'updated_at',
    ];

    public function instansi()
    {
        return $this->belongsTo(Instansi::class);
    }
}
