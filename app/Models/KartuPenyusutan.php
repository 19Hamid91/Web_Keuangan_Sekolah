<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class KartuPenyusutan extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    protected $table = 't_kartupenyusutan';
    protected $guarded = ['id'];
    protected static $logAttributes = [
        'aset_id',
        'pembelian_aset_id',
        'nama_barang',
        'tanggal_operasi',
        'masa_penggunaan',
        'residu',
        'metode',
        'created_at',
        'updated_at',
    ];

    public function aset()
    {
        return $this->belongsTo(Aset::class);
    }

    public function pembelian_aset()
    {
        return $this->belongsTo(PembelianAset::class);
    }

    public function komponen()
    {
        return $this->belongsTo(KomponenBeliAset::class, 'komponen_id');
    }
}
