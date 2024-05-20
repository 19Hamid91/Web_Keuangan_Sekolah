<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnKodeTagihaninPembayaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('pembayarans', function (Blueprint $table) {
        //     $table->dropUnique('pembayarans_kode_tagihan_unique');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('pembayarans', function (Blueprint $table) {
        //     $table->unique('kode_tagihan');
        // });
    }
}
