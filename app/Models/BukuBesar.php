<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class BukuBesar extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    protected $table = 't_bukubesar';
    protected $guarded = ['id'];
    protected static $logAttributes = [
        'nama',
        'alamat',
        'telpon',
        'created_at',
        'updated_at',
    ];

    public function akun()
    {
        return $this->belongsTo(Akun::class);
    }
}
