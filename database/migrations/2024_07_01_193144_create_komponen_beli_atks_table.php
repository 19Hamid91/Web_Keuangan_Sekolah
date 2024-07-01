<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKomponenBeliAtksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('komponen_beliatk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('beliatk_id');
            $table->foreignId('atk_id');
            $table->string('satuan');
            $table->integer('jumlah');
            $table->unsignedBigInteger('harga_satuan');
            $table->integer('diskon');
            $table->integer('ppn');
            $table->unsignedBigInteger('harga_total');
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
        Schema::dropIfExists('komponen_beliatk');
    }
}
