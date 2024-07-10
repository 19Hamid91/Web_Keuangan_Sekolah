<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDateInTagihanSiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('t_tagihan_siswa', function (Blueprint $table) {
            $table->date('mulai_bayar')->change();
            $table->date('akhir_bayar')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('t_tagihan_siswa', function (Blueprint $table) {
            $table->string('mulai_bayar')->change();
            $table->string('akhir_bayar')->change();
        });
    }
}
