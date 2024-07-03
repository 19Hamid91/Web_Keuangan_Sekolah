<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnGajiKotorInPenggajianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('t_penggajian', function (Blueprint $table) {
            $table->renameColumn('potongan_lainnya', 'gaji_kotor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('t_penggajian', function (Blueprint $table) {
            $table->renameColumn('gaji_kotor', 'potongan_lainnya');
        });
    }
}
