<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembayaranSiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_pembayaransiswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tagihan_siswa_id');
            $table->foreignId('siswa_id');
            $table->date('tanggal');
            $table->bigInteger('total');
            $table->bigInteger('sisa');
            $table->string('tipe_pembayaran');
            $table->string('status');
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
        Schema::dropIfExists('t_pembayaransiswa');
    }
}
