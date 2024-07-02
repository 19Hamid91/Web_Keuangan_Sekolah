<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeJournalColumnInJournalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('t_jurnal', function (Blueprint $table) {
            $table->unsignedBigInteger('journable_id')->nullable()->change();
            $table->string('journable_type')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('t_jurnal', function (Blueprint $table) {
            $table->unsignedBigInteger('journable_id')->nullable(false)->change();
            $table->string('journable_type')->nullable(false)->change();
        });
    }
}
