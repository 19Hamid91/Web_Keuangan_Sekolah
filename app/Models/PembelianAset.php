<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class PembelianAset extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    protected $table = 't_beliaset';
    protected $guarded = ['id'];
    protected static $logAttributes = [
        'supplier_id',
        'tgl_beliaset',
        'total',
        'created_at',
        'updated_at',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function penyusutan(){
        return $this->hasMnay(KartuPenyusutan::class);
    }

    public function journals()
    {
        return $this->morphMany(Jurnal::class, 'journable');
    }

    public function komponen()
    {
        return $this->hasMany(KomponenBeliAset::class, 'beliaset_id');
    }
}
