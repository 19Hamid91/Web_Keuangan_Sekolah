<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeGrupKelasToTingkatInKelasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('t_kelas', function (Blueprint $table) {
            $table->dropColumn('grup_kelas');
            $table->string('tingkat')->after('kelas');
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('t_kelas', function (Blueprint $table) {
            $table->dropColumn('tingkat');
            $table->integer('grup_kelas')->after('kelas');
        });
    }
}
