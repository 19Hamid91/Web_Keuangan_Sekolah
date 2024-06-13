<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBukuBesarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_bukubesar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('akun_id');
            $table->date('tanggal');
            $table->bigInteger('saldo_awal');
            $table->bigInteger('saldo_akhir');
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
        Schema::dropIfExists('t_bukubesar');
    }
}
