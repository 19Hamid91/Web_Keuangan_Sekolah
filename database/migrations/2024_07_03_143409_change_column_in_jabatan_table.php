<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnInJabatanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('t_jabatan', function (Blueprint $table) {
            $table->string('status')->after('instansi_id');
            $table->unsignedBigInteger('transport')->default(0)->after('uang_lembur');
            $table->unsignedBigInteger('dana_pensiun')->default(0)->after('transport');
            $table->unsignedBigInteger('bpjs_kes_sekolah')->default(0)->after('dana_pensiun');
            $table->unsignedBigInteger('bpjs_ktk_sekolah')->default(0)->after('bpjs_kes_sekolah');
            $table->unsignedBigInteger('bpjs_kes_pribadi')->default(0)->after('bpjs_ktk_sekolah');
            $table->unsignedBigInteger('bpjs_ktk_pribadi')->default(0)->after('bpjs_kes_pribadi');
            $table->unsignedBigInteger('tunjangan_pendidikan')->default(0)->after('bpjs_ktk_pribadi');
            $table->dropColumn(['askes', 'uang_makan']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('t_jabatan', function (Blueprint $table) {
            $table->dropColumn(['status', 'dana_pensiun', 'bpjs_kes_sekolah', 'bpjs_ktk_sekolah', 'bpjs_kes_pribadi', 'bpjs_ktk_pribadi', 'tunjangan_pendidikan', 'transport']);
            $table->bigInteger('askes');
            $table->bigInteger('uang_makan');
        });
    }
}
