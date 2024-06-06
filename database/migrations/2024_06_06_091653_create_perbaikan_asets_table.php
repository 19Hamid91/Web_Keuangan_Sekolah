<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerbaikanAsetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_perbaikan_aset', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instansi_id');
            $table->foreignId('teknisi_id');
            $table->foreignId('aset_id');
            $table->date('tanggal');
            $table->string('jenis');
            $table->bigInteger('harga');
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
        Schema::dropIfExists('t_perbaikan_aset');
    }
}
