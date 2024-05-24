<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembelianAtksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_beliatk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id');
            $table->foreignId('atk_id');
            $table->date('tgl_beliatk');
            $table->string('satuan');
            $table->bigInteger('jumlah_atk');
            $table->bigInteger('hargasatuan_atk');
            $table->bigInteger('jumlahbayar_atk');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_beliatk');
    }
}
