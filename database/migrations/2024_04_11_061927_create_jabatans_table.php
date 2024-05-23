<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJabatansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_jabatan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jabatan');
            $table->bigInteger('gaji_pokok');
            $table->bigInteger('tunjangan_jabatan');
            $table->bigInteger('tunjangan_istrisuami');
            $table->bigInteger('tunjangan_anak');
            $table->bigInteger('uang_makan');
            $table->bigInteger('uang_lembur');
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
        Schema::dropIfExists('t_jabatan');
    }
}
