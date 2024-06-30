<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KomponenBeliAset extends Model
{
    use HasFactory;

    protected $table = 'komponen_beliaset';
    protected $guarded = ['id'];

    public function beliaset()
    {
        return $this->belongsTo(PembelianAset::class, 'beliaset_id');
    }

    public function aset()
    {
        return $this->BelongsTo(Aset::class);
    }
}
