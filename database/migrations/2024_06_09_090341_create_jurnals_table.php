<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJurnalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_jurnal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instansi_id');
            $table->morphs('journable');
            $table->string('keterangan');
            $table->foreignId('akun_debit')->nullable();
            $table->foreignId('akun_kredit')->nullable();
            $table->integer('nominal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_jurnal');
    }
}
