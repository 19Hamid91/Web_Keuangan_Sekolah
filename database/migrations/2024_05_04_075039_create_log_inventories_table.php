<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('log_inventories', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('kode_barang');
        //     $table->enum('jenis_lokasi', ['Sekolah', 'Yayasan']);
        //     $table->string('kode_lokasi');
        //     $table->string('peminjam');
        //     $table->integer('jumlah');
        //     $table->text('alasan');
        //     $table->date('tanggal_pinjam');
        //     $table->date('tanggal_kembali')->nullable();
        //     $table->string('kondisi');
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
        Schema::dropIfExists('log_inventories');
    }
}
