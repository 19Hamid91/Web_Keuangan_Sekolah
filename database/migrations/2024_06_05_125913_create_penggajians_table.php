<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenggajiansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_penggajian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karyawan_id');
            $table->foreignId('jabatan_id');
            $table->foreignId('presensi_karyawan_id');
            $table->bigInteger('potongan_bpjs');
            $table->bigInteger('potongan_lainnya')->default(0);
            $table->bigInteger('total_gaji');
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
        Schema::dropIfExists('t_penggajian');
    }
}
