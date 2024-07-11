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
        $dataYayasan = [
            ['kode' => '1-101', 'nama' => 'Kas Tunai', 'tipe' => 'Aktiva Lancar', 'jenis' => 'KAS', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-201', 'nama' => 'Bank BSI satu', 'tipe' => 'Aktiva Lancar', 'jenis' => 'BANK', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-202', 'nama' => 'Bank BSI dua', 'tipe' => 'Aktiva Lancar', 'jenis' => 'BANK', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-203', 'nama' => 'Bank BSI tiga', 'tipe' => 'Aktiva Lancar', 'jenis' => 'BANK', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-301', 'nama' => 'Piutang Sewa Kantin', 'tipe' => 'Aktiva Lancar', 'jenis' => 'PIUTANG', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-302', 'nama' => 'Piutang Anggota', 'tipe' => 'Aktiva Lancar', 'jenis' => 'PIUTANG', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-303', 'nama' => 'Piutang JPI Tanpa Pembatasan', 'tipe' => 'Aktiva Lancar', 'jenis' => 'PIUTANG', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-304', 'nama' => 'Piutang Lainnya', 'tipe' => 'Aktiva Lancar', 'jenis' => 'PIUTANG', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-401', 'nama' => 'Persediaan ATK', 'tipe' => 'Aktiva Lancar', 'jenis' => 'PERSEDIAAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-402', 'nama' => 'Persediaan Lainnya', 'tipe' => 'Aktiva Lancar', 'jenis' => 'PERSEDIAAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-501', 'nama' => 'Inventaris', 'tipe' => 'Aktiva Tetap', 'jenis' => 'ASET TIDAK LANCAR', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-502', 'nama' => 'Bangunan', 'tipe' => 'Aktiva Tetap', 'jenis' => 'ASET TIDAK LANCAR', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-503', 'nama' => 'Tanah', 'tipe' => 'Aktiva Tetap', 'jenis' => 'ASET TIDAK LANCAR', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-504', 'nama' => 'Aktiva Tetap Lainnya', 'tipe' => 'Aktiva Tetap', 'jenis' => 'ASET TIDAK LANCAR', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-505', 'nama' => 'Akum. Peny. Inventaris', 'tipe' => 'Akum. Penyusutan', 'jenis' => 'ASET TIDAK LANCAR', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-506', 'nama' => 'Akum. Peny. Bangunan', 'tipe' => 'Akum. Penyusutan', 'jenis' => 'ASET TIDAK LANCAR', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-507', 'nama' => 'Akum. Peny. Aktiva tetap Lainnya', 'tipe' => 'Akum. Penyusutan', 'jenis' => 'ASET TIDAK LANCAR', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '2-101', 'nama' => 'Hutang Bank', 'tipe' => 'Hutang', 'jenis' => 'LIABILITAS', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '2-102', 'nama' => 'Hutang Lainnya', 'tipe' => 'Hutang', 'jenis' => 'LIABILITAS', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '3-101', 'nama' => 'Aset Neto Tanpa Pembatasan', 'tipe' => 'Aset Neto', 'jenis' => 'ASET NETO', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '3-102', 'nama' => 'Aset Neto Dengan Pembatasan', 'tipe' => 'Aset Neto', 'jenis' => 'ASET NETO', 'kelompok' => 'DENGAN PEMBATASAN', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '4-101', 'nama' => 'Pendapatan JPI Tanpa Pembatasan', 'tipe' => 'Pendapatan', 'jenis' => 'PENDAPATAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '4-102', 'nama' => 'Pendapatan JPI Dengan Pembatasan', 'tipe' => 'Pendapatan', 'jenis' => 'PENDAPATAN', 'kelompok' => 'DENGAN PEMBATASAN', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '4-103', 'nama' => 'Pendapatan SPP Yayasan', 'tipe' => 'Pendapatan', 'jenis' => 'PENDAPATAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '4-104', 'nama' => 'Pendapatan Donasi', 'tipe' => 'Pendapatan', 'jenis' => 'PENDAPATAN', 'kelompok' => 'DENGAN PEMBATASAN', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '4-105', 'nama' => 'Pendapatan Sewa Kantin', 'tipe' => 'Pendapatan', 'jenis' => 'PENDAPATAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '4-106', 'nama' => 'Pendapatan Lainnya', 'tipe' => 'Pendapatan', 'jenis' => 'PENDAPATAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-101', 'nama' => 'Biaya Listrik', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-102', 'nama' => 'Biaya Air', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-103', 'nama' => 'Biaya Telepon', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-104', 'nama' => 'Biaya Internet', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-105', 'nama' => 'Biaya Perbaikan', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-106', 'nama' => 'Biaya Transport Pengurus', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-107', 'nama' => 'Biaya Honor Dokter', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-108', 'nama' => 'Biaya Pajak Bangunan', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-109', 'nama' => 'Biaya Pajak Kendaraan', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-110', 'nama' => 'Biaya Penyusutan Inventaris', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-111', 'nama' => 'Biaya Penyusutan Kendaraan', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-112', 'nama' => 'Biaya Penyusutan Bangunan', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-113', 'nama' => 'Biaya Penyusutan Aset Tetap Lainnya', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-114', 'nama' => 'Biaya Persediaan ATK', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-115', 'nama' => 'Biaya Rapat', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-116', 'nama' => 'Biaya Administrasi dan Umum', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-117', 'nama' => 'Biaya Pembangunan', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => 'DENGAN PEMBATASAN', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-118', 'nama' => 'Biaya Pembelian Tanah', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => 'DENGAN PEMBATASAN', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-119', 'nama' => 'Biaya Lainnya', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
        ];

        $dataSMP = [
            ['kode' => '1-101', 'nama' => 'Kas Tunai', 'tipe' => 'Aktiva Lancar', 'jenis' => 'KAS', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-201', 'nama' => 'Bank BCA', 'tipe' => 'Aktiva Lancar', 'jenis' => 'BANK', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-202', 'nama' => 'Bank BRI', 'tipe' => 'Aktiva Lancar', 'jenis' => 'BANK', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-203', 'nama' => 'Bank BNI', 'tipe' => 'Aktiva Lancar', 'jenis' => 'BANK', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-301', 'nama' => 'Piutang Jangka Pendek', 'tipe' => 'Aktiva Lancar', 'jenis' => 'PIUTANG', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-302', 'nama' => 'Piutang Jangka Panjang', 'tipe' => 'Aktiva Lancar', 'jenis' => 'PIUTANG', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-303', 'nama' => 'Piutang Lainnya', 'tipe' => 'Aktiva Lancar', 'jenis' => 'PIUTANG', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-401', 'nama' => 'Persediaan ATK', 'tipe' => 'Aktiva Lancar', 'jenis' => 'PERSEDIAAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-402', 'nama' => 'Persediaan Lainnya', 'tipe' => 'Aktiva Lancar', 'jenis' => 'PERSEDIAAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-501', 'nama' => 'Inventaris', 'tipe' => 'Aktiva Tetap', 'jenis' => 'AKTIVA TETAP', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-502', 'nama' => 'Kendaraan', 'tipe' => 'Aktiva Tetap', 'jenis' => 'AKTIVA TETAP', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-503', 'nama' => 'Bangunan', 'tipe' => 'Aktiva Tetap', 'jenis' => 'AKTIVA TETAP', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-504', 'nama' => 'Aktiva Tetap Lainnya', 'tipe' => 'Aktiva Tetap', 'jenis' => 'AKTIVA TETAP', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-505', 'nama' => 'Akum. Peny. Inventaris', 'tipe' => 'Akum. Penyusutan', 'jenis' => 'AKUMULASI PENYUSUTAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-506', 'nama' => 'Akum. Peny. Kendaraan', 'tipe' => 'Akum. Penyusutan', 'jenis' => 'AKUMULASI PENYUSUTAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-507', 'nama' => 'Akum. Peny. Bangunan', 'tipe' => 'Akum. Penyusutan', 'jenis' => 'AKUMULASI PENYUSUTAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-508', 'nama' => 'Akum. Peny. Aktiva Tetap Lainnya', 'tipe' => 'Akum. Penyusutan', 'jenis' => 'AKUMULASI PENYUSUTAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '2-101', 'nama' => 'Hutang Usaha Jangka Pendek', 'tipe' => 'Hutang', 'jenis' => 'LIABILITAS', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '2-201', 'nama' => 'Hutang Bank', 'tipe' => 'Hutang', 'jenis' => 'LIABILITAS', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '2-202', 'nama' => 'Hutang Jangka panjang Lainnya', 'tipe' => 'Hutang', 'jenis' => 'LIABILITAS', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '3-101', 'nama' => 'Aset Neto', 'tipe' => 'Aset Neto', 'jenis' => 'ASET NETO', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '4-101', 'nama' => 'Pendapatan SPP', 'tipe' => 'Pendapatan', 'jenis' => 'PENDAPATAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '4-102', 'nama' => 'Pendapatan JPI', 'tipe' => 'Pendapatan', 'jenis' => 'PENDAPATAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '4-103', 'nama' => 'Pendapatan Biaya Registrasi', 'tipe' => 'Pendapatan', 'jenis' => 'PENDAPATAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '4-104', 'nama' => 'Pendapatan Lainnya', 'tipe' => 'Pendapatan', 'jenis' => 'PENDAPATAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-101', 'nama' => 'Biaya Listrik', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-102', 'nama' => 'Biaya Air', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-103', 'nama' => 'Biaya Telepon', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-104', 'nama' => 'Biaya Internet', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-105', 'nama' => 'Biaya Rapat', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-106', 'nama' => 'Biaya Fotokopi dan Penjilidan', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-107', 'nama' => 'Biaya Perbaikan', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-108', 'nama' => 'Biaya Program Program Kegiatan Siswa', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-109', 'nama' => 'Biaya Transport', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-110', 'nama' => 'Biaya Gaji', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-111', 'nama' => 'Biaya BPJS', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-112', 'nama' => 'Biaya Iuran Pribadi BPJS', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-113', 'nama' => 'Biaya Pajak Bangunan', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-114', 'nama' => 'Biaya Pajak Kendaraan', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-115', 'nama' => 'Biaya Penyusutan Inventaris', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-116', 'nama' => 'Biaya Penyusutan Kendaraan', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-117', 'nama' => 'Biaya Penyusutan Bangunan', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-118', 'nama' => 'Biaya Penyusutan Aktiva Tetap Lainnya', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-119', 'nama' => 'Biaya Pengembangan Kurikulum', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-120', 'nama' => 'Biaya Sosialisasi dan Promosi', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-121', 'nama' => 'Biaya Penyuluhan dan Pelatihan', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-122', 'nama' => 'Biaya Persediaan ATK', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-123', 'nama' => 'Biaya Lainnya', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
        ];

        $dataTK = [
            ['kode' => '1-101', 'nama' => 'Kas Tunai', 'tipe' => 'Aktiva Lancar', 'jenis' => 'KAS', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-201', 'nama' => 'Bank BCA', 'tipe' => 'Aktiva Lancar', 'jenis' => 'BANK', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-202', 'nama' => 'Bank BRI', 'tipe' => 'Aktiva Lancar', 'jenis' => 'BANK', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-203', 'nama' => 'Bank BNI', 'tipe' => 'Aktiva Lancar', 'jenis' => 'BANK', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-301', 'nama' => 'Piutang SPP', 'tipe' => 'Aktiva Lancar', 'jenis' => 'PIUTANG', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-302', 'nama' => 'Piutang Outbond', 'tipe' => 'Aktiva Lancar', 'jenis' => 'PIUTANG', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-303', 'nama' => 'Piutang Jangka Panjang', 'tipe' => 'Aktiva Lancar', 'jenis' => 'PIUTANG', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-304', 'nama' => 'Piutang Lainnya', 'tipe' => 'Aktiva Lancar', 'jenis' => 'PIUTANG', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-401', 'nama' => 'Persediaan ATK', 'tipe' => 'Aktiva Lancar', 'jenis' => 'PERSEDIAAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-402', 'nama' => 'Persediaan Lainnya', 'tipe' => 'Aktiva Lancar', 'jenis' => 'PERSEDIAAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-501', 'nama' => 'Inventaris', 'tipe' => 'Aktiva Tetap', 'jenis' => 'ASET TIDAK LANCAR', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-502', 'nama' => 'Kendaraan', 'tipe' => 'Aktiva Tetap', 'jenis' => 'ASET TIDAK LANCAR', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-503', 'nama' => 'Bangunan', 'tipe' => 'Aktiva Tetap', 'jenis' => 'ASET TIDAK LANCAR', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-504', 'nama' => 'Aktiva Tetap Lainnya', 'tipe' => 'Aktiva Tetap', 'jenis' => 'ASET TIDAK LANCAR', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-505', 'nama' => 'Akum. Peny. Inventaris', 'tipe' => 'Akum. Penyusutan', 'jenis' => 'ASET TIDAK LANCAR', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-506', 'nama' => 'Akum. Peny. Kendaraan', 'tipe' => 'Akum. Penyusutan', 'jenis' => 'ASET TIDAK LANCAR', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-507', 'nama' => 'Akum. Peny. Bangunan', 'tipe' => 'Akum. Penyusutan', 'jenis' => 'ASET TIDAK LANCAR', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-508', 'nama' => 'Akum. Peny. Aktiva Tetap Lainnya', 'tipe' => 'Akum. Penyusutan', 'jenis' => 'ASET TIDAK LANCAR', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '2-101', 'nama' => 'Hutang Jangka Pendek', 'tipe' => 'Hutang', 'jenis' => 'LIABILITAS', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '2-201', 'nama' => 'Hutang Bank', 'tipe' => 'Hutang', 'jenis' => 'LIABILITAS', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '2-205', 'nama' => 'Hutang Jangka Panjang Lainnya', 'tipe' => 'Hutang', 'jenis' => 'LIABILITAS', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '3-101', 'nama' => 'Aset Neto', 'tipe' => 'Aset Neto', 'jenis' => 'ASET NETO', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '4-101', 'nama' => 'Pendapatan SPP', 'tipe' => 'Pendapatan', 'jenis' => 'PENDAPATAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '4-102', 'nama' => 'Pendapatan JPI', 'tipe' => 'Pendapatan', 'jenis' => 'PENDAPATAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '4-103', 'nama' => 'Pendapatan Biaya egistrasi', 'tipe' => 'Pendapatan', 'jenis' => 'PENDAPATAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '4-104', 'nama' => 'Pendapatan Outbond', 'tipe' => 'Pendapatan', 'jenis' => 'PENDAPATAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '4-105', 'nama' => 'Pendapatan Overtime', 'tipe' => 'Pendapatan', 'jenis' => 'PENDAPATAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '4-106', 'nama' => 'Pendapatan Lainnya', 'tipe' => 'Pendapatan', 'jenis' => 'PENDAPATAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-101', 'nama' => 'Biaya Listrik', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-102', 'nama' => 'Biaya Air', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-103', 'nama' => 'Biaya Telepon', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-104', 'nama' => 'Biaya Internet', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-105', 'nama' => 'Biaya Rapat', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-106', 'nama' => 'Biaya Fotokopi dan Penjilidan', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-107', 'nama' => 'Biaya Perbaikan', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-108', 'nama' => 'Biaya Program Kegiatan Siswa', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-109', 'nama' => 'Biaya Transport', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-110', 'nama' => 'Biaya Gaji', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-111', 'nama' => 'Biaya BPJS', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-112', 'nama' => 'Biaya Iuran Pribadi BPJS', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-113', 'nama' => 'Biaya Pajak Bangunan', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-114', 'nama' => 'Biaya Pajak Kendaraan', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-115', 'nama' => 'Biaya Penyusutan Inventaris', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-116', 'nama' => 'Biaya Penyusutan Kendaraan', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-117', 'nama' => 'Biaya Penyusutan Bangunan', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-118', 'nama' => 'Biaya Penyusutan Aktiva Tetap Lainnya', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-119', 'nama' => 'Biaya Pengembangan Kurikulum', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-120', 'nama' => 'Biaya Sosialisasi dan Promosi', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-121', 'nama' => 'Biaya Penyuluhan dan Pelatihan', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-122', 'nama' => 'Biaya Persediaan ATK', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-123', 'nama' => 'Biaya Outbound', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-124', 'nama' => 'Biaya Ekstrakulikuler', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-125', 'nama' => 'Biaya Lainnya', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
        ];

        DB::table('t_akun')->truncate();

        foreach ($dataYayasan as $akun) {
            $akun['instansi_id'] = 1;
            if ($akun['jenis'] === 'KAS' || $akun['jenis'] === 'BANK' || $akun['jenis'] === 'PIUTANG' || $akun['jenis'] === 'PERSEDIAAN') {
                $akun['posisi'] = 'DEBIT';
            } else {
                $akun['posisi'] = 'KREDIT';
            }
            DB::table('t_akun')->insert($akun);
        }

        foreach ($dataTK as $akun) {
            $akun['instansi_id'] = 2;
            if ($akun['jenis'] === 'KAS' || $akun['jenis'] === 'BANK' || $akun['jenis'] === 'PIUTANG' || $akun['jenis'] === 'PERSEDIAAN') {
                $akun['posisi'] = 'DEBIT';
            } else {
                $akun['posisi'] = 'KREDIT';
            }
            DB::table('t_akun')->insert($akun);
        }

        foreach ($dataSMP as $akun) {
            $akun['instansi_id'] = 3;
            if ($akun['jenis'] === 'KAS' || $akun['jenis'] === 'BANK' || $akun['jenis'] === 'PIUTANG' || $akun['jenis'] === 'PERSEDIAAN') {
                $akun['posisi'] = 'DEBIT';
            } else {
                $akun['posisi'] = 'KREDIT';
            }
            DB::table('t_akun')->insert($akun);
        }
    }
}
