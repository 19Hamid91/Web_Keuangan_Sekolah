<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInvoiceInPemasukanLainnya extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('t_pemasukanlainnya', function (Blueprint $table) {
            $table->string('invoice')->after('instansi_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('t_pemasukanlainnya', function (Blueprint $table) {
            $table->dropColumn('invoice');
        });
    }
}
