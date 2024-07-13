<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePembelianColumnToNullInKartupenyusutanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('t_kartupenyusutan', function (Blueprint $table) {
            $table->foreignId('pembelian_aset_id')->nullable()->change();
            $table->foreignId('komponen_id')->nullable()->change();
            $table->unsignedBigInteger('harga_beli')->nullable()->after('residu');
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
            $table->foreignId('pembelian_aset_id')->change();
            $table->foreignId('komponen_id')->change();
            $table->dropColumn('harga_beli');
        });
    }
}
