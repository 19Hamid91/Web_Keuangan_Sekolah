<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Supplier extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    protected $table = 't_supplier';
    protected $guarded = ['id'];
    protected static $logAttributes = [
        'instansi_id',
        'jenis_supplier',
        'nama_supplier',
        'alamat_supplier',
        'notelp_supplier',
        'created_at',
        'updated_at',
    ];
    
    public function instansi()
    {
        return $this->belongsTo(Instansi::class);
    }
}
