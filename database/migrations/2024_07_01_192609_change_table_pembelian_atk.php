<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTablePembelianAtk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('t_beliatk', function (Blueprint $table) {
            $table->dropColumn(['atk_id', 'satuan', 'jumlah_atk', 'hargasatuan_atk', 'jumlahbayar_atk']);

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
        Schema::table('t_beliatk', function (Blueprint $table) {
            $table->dropColumn('total');
    
            $table->foreignId('atk_id'); 
            $table->string('satuan');
            $table->bigInteger('jumlah_atk');
            $table->bigInteger('hargasatuan_atk');
            $table->bigInteger('jumlahbayar_atk');
        });
    }
}
