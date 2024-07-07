<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmailWaliInTableSiswa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('t_siswa', function (Blueprint $table) {
            $table->string('email_wali_siswa')->after('nohp_wali_siswa');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('t_siswa', function (Blueprint $table) {
            $table->dropColumn('email_wali_siswa');
        });
    }
}
