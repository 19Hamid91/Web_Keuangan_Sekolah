<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPembelianAtkIdToKartustokTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('t_kartustok', function (Blueprint $table) {
            $table->foreignId('pembelian_atk_id')->after('id');
            $table->foreignId('komponen_beliatk_id')->after('pembelian_atk_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('t_kartustok', function (Blueprint $table) {
            $table->dropColumn('pembelian_atk_id');
            $table->dropColumn('komponen_beliatk_id');
        });
    }
}
