<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class PemasukanYayasan extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    protected $table = 't_pemasukanyayasan';
    protected $guarded = ['id'];
    protected static $logAttributes = [
        'jenis',
        'tanggal',
        'total',
        'keterangan',
        'created_at',
        'updated_at',
    ];

    public function journals()
    {
        return $this->morphMany(Jurnal::class, 'journable');
    }
}
