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
        'atk_id',
        'tgl_beliatk',
        'satuan',
        'jumlah_atk',
        'hargasatuan_atk',
        'jumlahbayar_atk',
        'created_at',
        'updated_at',
    ];

    public function atk()
    {
        return $this->belongsTo(Atk::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function journals()
    {
        return $this->morphMany(Jurnal::class, 'journable');
    }
}
