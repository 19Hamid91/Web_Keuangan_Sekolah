<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeJabatanInPengurusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('t_pengurus', function (Blueprint $table) {
            $table->renameColumn('jabatan_id', 'jabatan');
        });

        Schema::table('t_pengurus', function (Blueprint $table) {
            $table->string('jabatan')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('t_pengurus', function (Blueprint $table) {
            $table->foreignId('jabatan')->change();
        });

        Schema::table('t_pengurus', function (Blueprint $table) {
            $table->renameColumn('jabatan', 'jabatan_id');
        });

    }
}
