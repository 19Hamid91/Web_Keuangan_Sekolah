<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstansisTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('t_instansi')->truncate();
        DB::table('t_instansi')->insert([
            [
            'nama_instansi' => 'Yayasan',
            'deskripsi_instansi' => 'Yayasan PAPB',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            [
            'nama_instansi' => 'TK',
            'deskripsi_instansi' => 'TK PPB',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            [
            'nama_instansi' => 'SMP',
            'deskripsi_instansi' => 'SMP PAPB',
            'created_at' => now(),
            'updated_at' => now(),
            ],
        ]);
    }
}
