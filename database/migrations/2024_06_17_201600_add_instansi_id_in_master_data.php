<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInstansiIdInMasterData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('t_supplier', function (Blueprint $table) {
            $table->string('instansi_id')->after('id');
        });
        Schema::table('t_teknisi', function (Blueprint $table) {
            $table->string('instansi_id')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('t_supplier', function (Blueprint $table) {
            $table->dropColumn('instansi_id');
        });
        Schema::table('t_teknisi', function (Blueprint $table) {
            $table->dropColumn('instansi_id');
        });
    }
}
