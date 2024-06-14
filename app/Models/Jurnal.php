<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurnal extends Model
{
    use HasFactory;

    protected $table = 't_jurnal';
    protected $guarded = ['id'];

    public function journable()
    {
        return $this->morphTo();
    }

    public function kredit()
    {
        return $this->belongsTo(Akun::class, 'akun_kredit');
    }

    public function debit()
    {
        return $this->belongsTo(Akun::class, 'akun_debit');
    }
}
