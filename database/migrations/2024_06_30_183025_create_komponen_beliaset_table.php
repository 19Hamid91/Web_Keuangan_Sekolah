<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKomponenBeliasetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('komponen_beliaset', function (Blueprint $table) {
            $table->id();
            $table->foreignId('beliaset_id');
            $table->foreignId('aset_id');
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
        Schema::dropIfExists('komponen_beliaset');
    }
}
