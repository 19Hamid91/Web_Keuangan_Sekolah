<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKartuPenyusutansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_kartupenyusutan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aset_id');
            $table->foreignId('pembelian_aset_id');
            $table->string('nama_barang');
            $table->date('tanggal_operasi');
            $table->integer('masa_penggunaan');
            $table->integer('residu');
            $table->string('metode');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_kartupenyusutan');
    }
}
