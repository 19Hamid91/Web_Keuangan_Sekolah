<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KomponenBeliAtk extends Model
{
    use HasFactory;

    protected $table = 'komponen_beliatk';
    protected $guarded = ['id'];

    public function beliatk()
    {
        return $this->belongsTo(PembelianAtk::class, 'beliatk_id');
    }

    public function atk()
    {
        return $this->BelongsTo(Atk::class);
    }

    public function kartustok()
    {
        return $this->hasOne(KartuStok::class, 'komponen_beliatk_id');
    }
}
