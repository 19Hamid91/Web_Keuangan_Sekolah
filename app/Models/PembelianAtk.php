<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class PembelianAtk extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    protected $table = 't_beliatk';
    protected $guarded = ['id'];
    protected static $logAttributes = [
        'supplier_id',
        'tgl_beliatk',
        'total',
        'created_at',
        'updated_at',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function stok(){
        return $this->hasMany(KartuStok::class, 'pembelian_atk_id');
    }

    public function journals()
    {
        return $this->morphMany(Jurnal::class, 'journable');
    }

    public function komponen()
    {
        return $this->hasMany(KomponenBeliAtk::class, 'beliatk_id');
    }
}
