<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutbondsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_outbond', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instansi_id');
            $table->foreignId('biro_id');
            $table->date('tanggal_pembayaran');
            $table->bigInteger('harga_outbond');
            $table->date('tanggal_outbond');
            $table->string('tempat_outbond');
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
        Schema::dropIfExists('t_outbond');
    }
}
