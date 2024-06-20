<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePrimaryKeyInSiswaAndPegawai extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('t_gurukaryawan', function (Blueprint $table) {
        //     $table->dropPrimary('id'); 
        //     $table->primary('nip')->unique()->change();
        // });

        // Schema::table('t_siswa', function (Blueprint $table) {
        //     $table->dropPrimary('id'); 
        //     $table->primary('nis')->unique()->change();
        // });
    }

    public function down()
    {
        // Schema::table('t_gurukaryawan', function (Blueprint $table) {
        //     $table->dropPrimary('nip')->change();
        //     $table->primary('id');
        // });

        // Schema::table('t_siswa', function (Blueprint $table) {
        //     $table->dropPrimary('nis')->change();
        //     $table->primary('id');
        // });
    }
}
