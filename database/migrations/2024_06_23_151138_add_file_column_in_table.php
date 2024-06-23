<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFileColumnInTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('t_pengeluaranlainnya', function (Blueprint $table) {
            $table->string('file')->nullable();
        });
        Schema::table('t_outbond', function (Blueprint $table) {
            $table->string('file')->nullable();
        });
        Schema::table('t_operasional', function (Blueprint $table) {
            $table->string('file')->nullable();
        });
        Schema::table('t_perbaikan_aset', function (Blueprint $table) {
            $table->string('file')->nullable();
        });
        Schema::table('t_penggajian', function (Blueprint $table) {
            $table->string('file')->nullable();
        });
        Schema::table('t_beliaset', function (Blueprint $table) {
            $table->string('file')->nullable();
        });
        Schema::table('t_beliatk', function (Blueprint $table) {
            $table->string('file')->nullable();
        });
        Schema::table('t_pemasukanlainnya', function (Blueprint $table) {
            $table->string('file')->nullable();
        });
        Schema::table('t_pembayaransiswa', function (Blueprint $table) {
            $table->string('file')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('t_pengeluaranlainnya', function (Blueprint $table) {
            $table->dropColumn('file');
        });
        Schema::table('t_outbond', function (Blueprint $table) {
            $table->dropColumn('file');
        });
        Schema::table('t_operasional', function (Blueprint $table) {
            $table->dropColumn('file');
        });
        Schema::table('t_penggajian', function (Blueprint $table) {
            $table->dropColumn('file');
        });
        Schema::table('t_beliaset', function (Blueprint $table) {
            $table->dropColumn('file');
        });
        Schema::table('t_beliatk', function (Blueprint $table) {
            $table->dropColumn('file');
        });
        Schema::table('t_pemasukanlainnya', function (Blueprint $table) {
            $table->dropColumn('file');
        });
        Schema::table('t_pembayaransiswa', function (Blueprint $table) {
            $table->dropColumn('file');
        });
    }
}
