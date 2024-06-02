<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKartuStoksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_kartustok', function (Blueprint $table) {
            $table->id();
            $table->foreignId('atk_id');
            $table->date('tanggal');
            $table->integer('masuk');
            $table->integer('keluar');
            $table->integer('sisa');
            $table->string('pengambil');
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
        Schema::dropIfExists('t_kartustok');
    }
}
