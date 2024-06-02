<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagihanSiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_tagihan_siswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instansi_id');
            $table->foreignId('tahun_ajaran_id');
            $table->foreignId('kelas_id');
            $table->string('jenis_tagihan');
            $table->string('mulai_bayar');
            $table->string('akhir_bayar');
            $table->string('jumlah_pembayaran')->default(1);
            $table->bigInteger('nominal')->default(0);
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
        Schema::dropIfExists('t_tagihan_siswa');
    }
}
