<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGajiPegawaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('gaji_pegawais', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('kode');
        //     $table->string('nip');
        //     $table->string('kode_komponen_gaji');
        //     $table->integer('jumlah');
        //     $table->string('nominal');
        //     $table->string('total_gaji');
        //     $table->date('tanggal');
        //     $table->string('status');
        //     $table->timestamps();
        //     $table->softDeletes();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gaji_pegawais');
    }
}
