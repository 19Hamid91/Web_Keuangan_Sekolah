<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->string('kode_sekolah');
            $table->string('kode_kelas');
            $table->string('nama_siswa');
            $table->string('nis')->unique();
            $table->string('no_hp_siswa');
            $table->text('alamat');
            $table->string('jenis_kelamin');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('nama_wali');
            $table->string('pekerjaan_wali');
            $table->string('no_hp_wali');
            $table->string('status');
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
        Schema::dropIfExists('siswas');
    }
}
