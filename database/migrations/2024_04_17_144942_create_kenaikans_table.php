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
        Schema::create('kenaikans', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('kode_sekolah');
            $table->string('kode_kelas_awal');
            $table->string('kode_kelas_akhir');
            $table->string('kode_tahun_ajaran');
            $table->date('tanggal');
            $table->string('nis_siswa');
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
        Schema::dropIfExists('kenaikans');
    }
}
