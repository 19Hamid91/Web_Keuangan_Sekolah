<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeKeasIdInTagihanSiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('t_tagihan_siswa', function (Blueprint $table) {
            $table->dropColumn('kelas_id');
            $table->string('tingkat')->after('tahun_ajaran_id');
            $table->string('periode')->after('tingkat');
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
            $table->dropColumn('tingkat');
            $table->dropColumn('periode');
            $table->unsignedBigInteger('kelas_id')->after('tahun_ajaran_id');
        });
    }
}
