<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKenaikansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_kenaikan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instansi_id');
            $table->foreignId('tahun_ajaran_id');
            $table->foreignId('siswa_id');
            $table->string('kelas_awal');
            $table->string('kelas_akhir');
            $table->date('tanggal');
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
        Schema::dropIfExists('t_kenaikan');
    }
}
