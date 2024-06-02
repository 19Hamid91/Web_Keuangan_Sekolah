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
            $table->foreignId('instansi_id');
            $table->string('jabatan');
            $table->bigInteger('gaji_pokok')->default(0);
            $table->bigInteger('tunjangan_jabatan')->default(0);
            $table->bigInteger('tunjangan_istrisuami')->default(0);
            $table->bigInteger('tunjangan_anak')->default(0);
            $table->bigInteger('uang_makan')->default(0);
            $table->bigInteger('uang_lembur')->default(0);
            $table->bigInteger('askes')->default(0);
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
