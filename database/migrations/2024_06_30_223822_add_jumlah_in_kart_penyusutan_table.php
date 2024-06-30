<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJumlahInKartPenyusutanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('t_kartupenyusutan', function (Blueprint $table) {
            $table->foreignId('komponen_id')->after('pembelian_aset_id');
            $table->integer('jumlah_barang')->after('nama_barang');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('t_kartupenyusutan', function (Blueprint $table) {
            $table->dropColumn('komponen_id');
            $table->dropColumn('jumlah_barang');
        });
    }
}
