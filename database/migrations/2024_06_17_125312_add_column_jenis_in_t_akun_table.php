<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnJenisInTAkunTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('t_akun', function (Blueprint $table) {
            // Adding new columns with specified types
            $table->string('tipe')->after('nama');
            $table->string('jenis')->after('tipe');
            $table->string('kelompok')->after('jenis');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('t_akun', function (Blueprint $table) {
            // Dropping the added columns
            $table->dropColumn('tipe');
            $table->dropColumn('jenis');
            $table->dropColumn('kelompok');
        });
    }
}
