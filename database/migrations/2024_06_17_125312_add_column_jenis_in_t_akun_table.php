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
            $table->dropUnique(['kode']);
            $table->string('tipe')->after('nama');
            $table->string('jenis')->after('tipe');
            $table->string('kelompok')->after('jenis');
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
        Schema::table('t_akun', function (Blueprint $table) {
            $table->dropUnique(['kode', 'instansi_id']);
            $table->dropColumn('tipe');
            $table->dropColumn('jenis');
            $table->dropColumn('kelompok');
            $table->dropColumn('instansi_id');
            $table->unique('kode');
        });
    }
}
