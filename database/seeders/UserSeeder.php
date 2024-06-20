<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'ADMIN',
            'email' => 'admin@gmail.com',
            'role' => 'ADMIN',
            'instansi_id' => 0,
            'password' => bcrypt('123'),
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'name' => 'TU2',
            'email' => 'tatausaha2@gmail.com',
            'role' => 'TU',
            'instansi_id' => 2,
            'password' => bcrypt('123'),
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'name' => 'TU2',
            'email' => 'tatausaha3@gmail.com',
            'role' => 'TU',
            'instansi_id' => 3,
            'password' => bcrypt('123'),
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'name' => 'BENDAHARA1',
            'email' => 'bendahara1@gmail.com',
            'role' => 'BENDAHARA',
            'instansi_id' => 1,
            'password' => bcrypt('123'),
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'name' => 'BENDAHARA2',
            'email' => 'bendahara2@gmail.com',
            'role' => 'BENDAHARA',
            'instansi_id' => 2,
            'password' => bcrypt('123'),
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'name' => 'BENDAHARA3',
            'email' => 'bendahara3@gmail.com',
            'role' => 'BENDAHARA',
            'instansi_id' => 3,
            'password' => bcrypt('123'),
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'name' => 'SEKRETARIS2',
            'email' => 'sekretaris2@gmail.com',
            'role' => 'SEKRETARIS',
            'instansi_id' => 2,
            'password' => bcrypt('123'),
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'name' => 'SEKRETARIS3',
            'email' => 'sekretaris3@gmail.com',
            'role' => 'SEKRETARIS',
            'instansi_id' => 3,
            'password' => bcrypt('123'),
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'name' => 'KEPALA1',
            'email' => 'kepala1@gmail.com',
            'role' => 'KEPALA YAYASAN',
            'instansi_id' => 1,
            'password' => bcrypt('123'),
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'name' => 'KEPALA2',
            'email' => 'kepala2@gmail.com',
            'role' => 'KEPALA SEKOLAH',
            'instansi_id' => 2,
            'password' => bcrypt('123'),
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'name' => 'KEPALA3',
            'email' => 'kepala3@gmail.com',
            'role' => 'KEPALA SEKOLAH',
            'instansi_id' => 3,
            'password' => bcrypt('123'),
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'name' => 'SARPRAS1',
            'email' => 'sarpras1@gmail.com',
            'role' => 'SARPRAS YAYASAN',
            'instansi_id' => 1,
            'password' => bcrypt('123'),
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'name' => 'SARPRAS2',
            'email' => 'sarpras2@gmail.com',
            'role' => 'SARPRAS SEKOLAH',
            'instansi_id' => 2,
            'password' => bcrypt('123'),
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'name' => 'SARPRAS3',
            'email' => 'sarpras3@gmail.com',
            'role' => 'SARPRAS SEKOLAH',
            'instansi_id' => 3,
            'password' => bcrypt('123'),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
