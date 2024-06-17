<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AkunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currentTimestamp = Carbon::now();
        $baseAkunData = [
            ['kode' => '1-101', 'nama' => 'Kas Tunai', 'tipe' => 'Kas', 'jenis' => 'KAS', 'kelompok' => '-', 'saldo_awal' => 100000000, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-102', 'nama' => 'Kas Lainnya', 'tipe' => 'Kas', 'jenis' => 'KAS', 'kelompok' => '-', 'saldo_awal' => 100000000, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-201', 'nama' => 'Bank BSI satu', 'tipe' => 'Bank', 'jenis' => 'BANK', 'kelompok' => '-', 'saldo_awal' => 100000000, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-202', 'nama' => 'Bank BSI dua', 'tipe' => 'Bank', 'jenis' => 'BANK', 'kelompok' => '-', 'saldo_awal' => 100000000, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-203', 'nama' => 'Bank BSI tiga', 'tipe' => 'Bank', 'jenis' => 'BANK', 'kelompok' => '-', 'saldo_awal' => 100000000, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-301', 'nama' => 'Persediaan ATK', 'tipe' => 'Persediaan', 'jenis' => 'PERSEDIAAN', 'kelompok' => '-', 'saldo_awal' => 100000000, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-302', 'nama' => 'Persediaan Lainnya', 'tipe' => 'Persediaan', 'jenis' => 'PERSEDIAAN', 'kelompok' => '-', 'saldo_awal' => 100000000, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-401', 'nama' => 'Piutang Jangka Pendek', 'tipe' => 'Piutang', 'jenis' => 'PIUTANG', 'kelompok' => '-', 'saldo_awal' => 100000000, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-402', 'nama' => 'Piutang Jangka Panjang', 'tipe' => 'Piutang', 'jenis' => 'PIUTANG', 'kelompok' => '-', 'saldo_awal' => 100000000, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-403', 'nama' => 'Piutang Lainnya', 'tipe' => 'Piutang', 'jenis' => 'PIUTANG', 'kelompok' => '-', 'saldo_awal' => 100000000, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-501', 'nama' => 'Sewa Dibayar di Muka', 'tipe' => 'Aktiva Lancar Lainnya', 'jenis' => 'ASET LANCAR LAINNYA', 'kelompok' => '-', 'saldo_awal' => 100000000, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-502', 'nama' => 'Pembelian Dibayar di Muka', 'tipe' => 'Aktiva Lancar Lainnya', 'jenis' => 'ASET LANCAR LAINNYA', 'kelompok' => '-', 'saldo_awal' => 100000000, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-503', 'nama' => 'Beban Dibayar di Muka Lainnya', 'tipe' => 'Aktiva Lancar Lainnya', 'jenis' => 'ASET LANCAR LAINNYA', 'kelompok' => '-', 'saldo_awal' => 100000000, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-601', 'nama' => 'Inventaris Yayasan', 'tipe' => 'Aktiva Tetap', 'jenis' => 'ASET TIDAK LANCAR', 'kelompok' => '-', 'saldo_awal' => 100000000, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-602', 'nama' => 'Perlengkapan dan Peralatan', 'tipe' => 'Aktiva Tetap', 'jenis' => 'ASET TIDAK LANCAR', 'kelompok' => '-', 'saldo_awal' => 100000000, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-603', 'nama' => 'Kendaraan', 'tipe' => 'Aktiva Tetap', 'jenis' => 'ASET TIDAK LANCAR', 'kelompok' => '-', 'saldo_awal' => 100000000, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-604', 'nama' => 'Bangunan', 'tipe' => 'Aktiva Tetap', 'jenis' => 'ASET TIDAK LANCAR', 'kelompok' => '-', 'saldo_awal' => 100000000, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-605', 'nama' => 'Aktiva Tetap Lainnya', 'tipe' => 'Aktiva Tetap', 'jenis' => 'ASET TIDAK LANCAR', 'kelompok' => '-', 'saldo_awal' => 100000000, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-606', 'nama' => 'Akum. Peny. Inventaris Lembaga', 'tipe' => 'Akum. Penyusutan', 'jenis' => 'ASET TIDAK LANCAR', 'kelompok' => '-', 'saldo_awal' => 100000000, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-607', 'nama' => 'Akum. Peny. Perlengkapan dan Peralatan', 'tipe' => 'Akum. Penyusutan', 'jenis' => 'ASET TIDAK LANCAR', 'kelompok' => '-', 'saldo_awal' => 100000000, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-608', 'nama' => 'Akum. Peny. Kendaraan', 'tipe' => 'Akum. Penyusutan', 'jenis' => 'ASET TIDAK LANCAR', 'kelompok' => '-', 'saldo_awal' => 100000000, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-609', 'nama' => 'Akum. Peny. Bangunan', 'tipe' => 'Akum. Penyusutan', 'jenis' => 'ASET TIDAK LANCAR', 'kelompok' => '-', 'saldo_awal' => 100000000, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-610', 'nama' => 'Akum. Peny. Aktiva Tetap Lainnya', 'tipe' => 'Akum. Penyusutan', 'jenis' => 'ASET TIDAK LANCAR', 'kelompok' => '-', 'saldo_awal' => 100000000, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '2-101', 'nama' => 'Hutang Usaha Jangka Pendek', 'tipe' => 'Kewajiban Jangka Pendek', 'jenis' => 'LIABILITAS JANGKA PENDEK', 'kelompok' => '-', 'saldo_awal' => 100000000, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '2-102', 'nama' => 'Hutang Rekanan', 'tipe' => 'Kewajiban Jangka Pendek', 'jenis' => 'LIABILITAS JANGKA PENDEK', 'kelompok' => '-', 'saldo_awal' => 100000000, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '2-103', 'nama' => 'Hutang Kegiatan', 'tipe' => 'Kewajiban Jangka Pendek', 'jenis' => 'LIABILITAS JANGKA PENDEK', 'kelompok' => '-', 'saldo_awal' => 100000000, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '2-201', 'nama' => 'Hutang Bank', 'tipe' => 'Kewajiban Jangka Panjang', 'jenis' => 'LIABILITAS JANGKA PANJANG', 'kelompok' => '-', 'saldo_awal' => 100000000, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '2-202', 'nama' => 'Hutang Jangka panjang Lainnya', 'tipe' => 'Kewajiban Jangka Panjang', 'jenis' => 'LIABILITAS JANGKA PANJANG', 'kelompok' => '-', 'saldo_awal' => 100000000, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '3-101', 'nama' => 'Tanpa Pembatasan', 'tipe' => 'Aset Neto', 'jenis' => 'ASET NETO', 'kelompok' => '-', 'saldo_awal' => 100000000, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '3-102', 'nama' => 'Dengan Pembatasan', 'tipe' => 'Aset Neto', 'jenis' => 'ASET NETO', 'kelompok' => '-', 'saldo_awal' => 100000000, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '4-101', 'nama' => 'Pendapatan JPI', 'tipe' => 'Pendapatan', 'jenis' => 'PENDAPATAN', 'kelompok' => '-', 'saldo_awal' => 100000000, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '4-102', 'nama' => 'Pendapatan SPP Yayasan', 'tipe' => 'Pendapatan', 'jenis' => 'PENDAPATAN', 'kelompok' => '-', 'saldo_awal' => 100000000, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '4-103', 'nama' => 'Pendapatan Donasi', 'tipe' => 'Pendapatan', 'jenis' => 'PENDAPATAN', 'kelompok' => '-', 'saldo_awal' => 100000000, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '4-104', 'nama' => 'Pendapatan Sewa Kantin', 'tipe' => 'Pendapatan', 'jenis' => 'PENDAPATAN', 'kelompok' => '-', 'saldo_awal' => 100000000, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '4-105', 'nama' => 'Pendapatan Lainnya', 'tipe' => 'Pendapatan', 'jenis' => 'PENDAPATAN', 'kelompok' => '-', 'saldo_awal' => 100000000, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-101', 'nama' => 'Biaya Listrik', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 100000000, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-102', 'nama' => 'Biaya Air', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 100000000, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-103', 'nama' => 'Biaya Telepon dan Internet', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 100000000, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-104', 'nama' => 'Biaya Perbaikan', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 100000000, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-105', 'nama' => 'Biaya ATK', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 100000000, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-106', 'nama' => 'Biaya Inventaris', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 100000000, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-107', 'nama' => 'Biaya Transport Pengurus', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 100000000, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-108', 'nama' => 'Biaya Honor Dokter', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 100000000, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-109', 'nama' => 'Biaya Penyusutan', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 100000000, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-110', 'nama' => 'Biaya Lainnya', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 100000000, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
        ];

        DB::table('t_akun')->truncate();
        $instansiIds = [1, 2, 3];

        foreach ($instansiIds as $instansiId) {
            foreach ($baseAkunData as $akun) {
                $akun['instansi_id'] = $instansiId;
                DB::table('t_akun')->insert($akun);
            }
        }
    }
}
