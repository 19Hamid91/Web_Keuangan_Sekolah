<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKelulusansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelulusans', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('kode_sekolah');
            $table->string('kode_kelas');
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
        Schema::dropIfExists('kelulusans');
    }
}
