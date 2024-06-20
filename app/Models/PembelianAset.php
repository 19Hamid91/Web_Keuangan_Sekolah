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
        'aset_id',
        'tgl_beliaset',
        'satuan',
        'jumlah_aset',
        'hargasatuan_aset',
        'jumlahbayar_aset',
        'created_at',
        'updated_at',
    ];

    public function aset()
    {
        return $this->belongsTo(Aset::class);
    }

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
}
