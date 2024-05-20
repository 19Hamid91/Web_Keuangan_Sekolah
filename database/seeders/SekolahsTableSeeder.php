<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SekolahsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sekolahs')->truncate();
        DB::table('sekolahs')->insert([
            [
            'nama' => 'Yayasan',
            'jenis' => 'yayasan',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            [
            'nama' => 'SD',
            'jenis' => 'sekolah',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            [
            'nama' => 'SMP',
            'jenis' => 'sekolah',
            'created_at' => now(),
            'updated_at' => now(),
            ],
        ]);
    }
}
