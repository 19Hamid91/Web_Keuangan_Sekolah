<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDaftarTagihansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daftar_tagihans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_sekolah');
            $table->string('kode_kelas');
            $table->string('kode_transaksi');
            $table->string('nominal');
            $table->string('kode_yayasan');
            $table->integer('persen_yayasan');
            $table->date('awal_pembayaran')->nullable();
            $table->date('akhir_pembayaran')->nullable();
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
        Schema::dropIfExists('daftar_tagihans');
    }
}
