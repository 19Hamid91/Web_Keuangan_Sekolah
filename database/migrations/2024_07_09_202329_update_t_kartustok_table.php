<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTKartustokTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('t_kartustok', function (Blueprint $table) {
            $table->integer('harga_unit_masuk')->nullable()->after('masuk');
            $table->integer('total_harga_masuk')->nullable()->after('harga_unit_masuk');
            $table->integer('harga_unit_keluar')->nullable()->after('keluar');
            $table->integer('total_harga_keluar')->nullable()->after('harga_unit_keluar');
            $table->integer('harga_rata_rata')->after('sisa');
            $table->integer('total_harga_stok')->after('harga_rata_rata');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('t_kartustok', function (Blueprint $table) {
            $table->dropColumn([
                'harga_unit_masuk',
                'total_harga_masuk',
                'harga_unit_keluar',
                'total_harga_keluar',
                'harga_rata_rata',
                'total_harga_stok',
            ]);
        });
    }
}
