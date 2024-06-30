<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTablePembelianAset extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('t_beliaset', function (Blueprint $table) {
            $table->dropColumn(['aset_id', 'satuan', 'jumlah_aset', 'hargasatuan_aset', 'jumlahbayar_aset']);

            $table->bigInteger('total');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('t_beliaset', function (Blueprint $table) {
            $table->dropColumn('total');
    
            $table->foreignId('aset_id'); 
            $table->string('satuan');
            $table->bigInteger('jumlah_aset');
            $table->bigInteger('hargasatuan_aset');
            $table->bigInteger('jumlahbayar_aset');
        });
    }
}
