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
            ['kode' => '1-101', 'nama' => 'Kas Tunai', 'tipe' => 'Kas', 'jenis' => 'KAS', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-201', 'nama' => 'Bank BSI satu', 'tipe' => 'Bank', 'jenis' => 'BANK', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-202', 'nama' => 'Bank BSI dua', 'tipe' => 'Bank', 'jenis' => 'BANK', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-203', 'nama' => 'Bank BSI tiga', 'tipe' => 'Bank', 'jenis' => 'BANK', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-301', 'nama' => 'Piutang Sewa Kantin', 'tipe' => 'Piutang', 'jenis' => 'PIUTANG', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-302', 'nama' => 'Piutang Anggota', 'tipe' => 'Piutang', 'jenis' => 'PIUTANG', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-303', 'nama' => 'Piutang Lainnya', 'tipe' => 'Piutang', 'jenis' => 'PIUTANG', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-401', 'nama' => 'Persediaan ATK', 'tipe' => 'Persediaan', 'jenis' => 'PERSEDIAAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-402', 'nama' => 'Persediaan Lainnya', 'tipe' => 'Persediaan', 'jenis' => 'PERSEDIAAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-501', 'nama' => 'Sewa Dibayar di Muka', 'tipe' => 'Aktiva Lancar Lainnya', 'jenis' => 'ASET LANCAR LAINNYA', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-502', 'nama' => 'Pembelian Dibayar di Muka', 'tipe' => 'Aktiva Lancar Lainnya', 'jenis' => 'ASET LANCAR LAINNYA', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-503', 'nama' => 'Beban Dibayar di Muka Lainnya', 'tipe' => 'Aktiva Lancar Lainnya', 'jenis' => 'ASET LANCAR LAINNYA', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-601', 'nama' => 'Inventaris', 'tipe' => 'Aktiva Tetap', 'jenis' => 'ASET TIDAK LANCAR', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-602', 'nama' => 'Kendaraan', 'tipe' => 'Aktiva Tetap', 'jenis' => 'ASET TIDAK LANCAR', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-603', 'nama' => 'Bangunan', 'tipe' => 'Aktiva Tetap', 'jenis' => 'ASET TIDAK LANCAR', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-604', 'nama' => 'Tanah', 'tipe' => 'Aktiva Tetap', 'jenis' => 'ASET TIDAK LANCAR', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-605', 'nama' => 'Aset Tetap Lainnya', 'tipe' => 'Aktiva Tetap', 'jenis' => 'ASET TIDAK LANCAR', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-606', 'nama' => 'Akum. Peny. Inventaris', 'tipe' => 'Akum. Penyusutan', 'jenis' => 'ASET TIDAK LANCAR', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-607', 'nama' => 'Akum. Peny. Kendaraan', 'tipe' => 'Akum. Penyusutan', 'jenis' => 'ASET TIDAK LANCAR', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-608', 'nama' => 'Akum. Peny. Bangunan', 'tipe' => 'Akum. Penyusutan', 'jenis' => 'ASET TIDAK LANCAR', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-609', 'nama' => 'Akum. Peny. Aset tetap Lainnya', 'tipe' => 'Akum. Penyusutan', 'jenis' => 'ASET TIDAK LANCAR', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '2-101', 'nama' => 'Hutang Angsuran Inventaris', 'tipe' => 'Kewajiban Jangka Panjang', 'jenis' => 'LIABILITAS', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '2-102', 'nama' => 'Hutang Angsuran Kendaraan', 'tipe' => 'Kewajiban Jangka Panjang', 'jenis' => 'LIABILITAS', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '2-103', 'nama' => 'Hutang Bank', 'tipe' => 'Kewajiban Jangka Panjang', 'jenis' => 'LIABILITAS', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
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
            ['kode' => '1-101', 'nama' => 'Kas Tunai', 'tipe' => 'Kas', 'jenis' => 'KAS', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-201', 'nama' => 'Bank BCA', 'tipe' => 'Bank', 'jenis' => 'BANK', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-202', 'nama' => 'Bank BRI', 'tipe' => 'Bank', 'jenis' => 'BANK', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-203', 'nama' => 'Bank BNI', 'tipe' => 'Bank', 'jenis' => 'BANK', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-301', 'nama' => 'Piutang Jangka Pendek', 'tipe' => 'Piutang', 'jenis' => 'PIUTANG', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-302', 'nama' => 'Piutang Jangka Panjang', 'tipe' => 'Piutang', 'jenis' => 'PIUTANG', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-303', 'nama' => 'Piutang Lainnya', 'tipe' => 'Piutang', 'jenis' => 'PIUTANG', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-401', 'nama' => 'Persediaan ATK', 'tipe' => 'Persediaan', 'jenis' => 'PERSEDIAAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-402', 'nama' => 'Persediaan Lainnya', 'tipe' => 'Persediaan', 'jenis' => 'PERSEDIAAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-501', 'nama' => 'Pembelian Dibayar di Muka', 'tipe' => 'Aktiva Lancar Lainnya', 'jenis' => 'ASET LANCAR LAINNYA', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-502', 'nama' => 'Beban Dibayar di Muka Lainnya', 'tipe' => 'Aktiva Lancar Lainnya', 'jenis' => 'ASET LANCAR LAINNYA', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-601', 'nama' => 'Inventaris', 'tipe' => 'Aktiva Tetap', 'jenis' => 'AKTIVA TETAP', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-602', 'nama' => 'Kendaraan', 'tipe' => 'Aktiva Tetap', 'jenis' => 'AKTIVA TETAP', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-603', 'nama' => 'Bangunan', 'tipe' => 'Aktiva Tetap', 'jenis' => 'AKTIVA TETAP', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-604', 'nama' => 'Aktiva Tetap Lainnya', 'tipe' => 'Aktiva Tetap', 'jenis' => 'AKTIVA TETAP', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-605', 'nama' => 'Aset Tak Berwujud', 'tipe' => '-', 'jenis' => '-', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-606', 'nama' => 'Akum. Peny. Inventaris', 'tipe' => 'Akum. Penyusutan', 'jenis' => 'AKUMULASI PENYUSUTAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-607', 'nama' => 'Akum. Peny. Kendaraan', 'tipe' => 'Akum. Penyusutan', 'jenis' => 'AKUMULASI PENYUSUTAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-608', 'nama' => 'Akum. Peny. Bangunan', 'tipe' => 'Akum. Penyusutan', 'jenis' => 'AKUMULASI PENYUSUTAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-609', 'nama' => 'Akum. Peny. Aktiva Tetap Lainnya', 'tipe' => 'Akum. Penyusutan', 'jenis' => 'AKUMULASI PENYUSUTAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-610', 'nama' => 'Akum. Peny. Aset Tak Berwujud', 'tipe' => 'Akum. Penyusutan', 'jenis' => 'AKUMULASI PENYUSUTAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '2-101', 'nama' => 'Hutang Usaha Jangka Pendek', 'tipe' => 'Kewajiban Jangka Pendek', 'jenis' => 'LIABILITAS', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '2-201', 'nama' => 'Hutang Bank', 'tipe' => 'Kewajiban Jangka Panjang', 'jenis' => 'LIABILITAS', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '2-202', 'nama' => 'Hutang Jangka panjang Lainnya', 'tipe' => 'Kewajiban Jangka Panjang', 'jenis' => 'LIABILITAS', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '3-101', 'nama' => 'Aset Neto', 'tipe' => 'Aset Neto', 'jenis' => 'ASET NETO', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '4-101', 'nama' => 'Pendapatan SPP', 'tipe' => 'Pendapatan', 'jenis' => 'PENDAPATAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '4-102', 'nama' => 'Pendapatan JPI', 'tipe' => 'Pendapatan', 'jenis' => 'PENDAPATAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '4-103', 'nama' => 'Pendapatan Biaya Registrasi', 'tipe' => 'Pendapatan', 'jenis' => 'PENDAPATAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '4-104', 'nama' => 'Pendapatan Lainnya', 'tipe' => 'Pendapatan', 'jenis' => 'PENDAPATAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-101', 'nama' => 'Biaya Listrik', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-102', 'nama' => 'Biaya Air', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-103', 'nama' => 'Biaya Telepon dan Internet', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-104', 'nama' => 'Biaya Rapat', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-105', 'nama' => 'Biaya Fotokopi dan Penjilidan', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-106', 'nama' => 'Biaya Perbaikan', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-107', 'nama' => 'Biaya Program Program Kegiatan Siswa', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-108', 'nama' => 'Biaya Transport', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-109', 'nama' => 'Biaya Gaji', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-110', 'nama' => 'Biaya BPJS', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-111', 'nama' => 'Biaya Pajak Bangunan', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-112', 'nama' => 'Biaya Pajak Kendaraan', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-113', 'nama' => 'Biaya Penyusutan Aset Tetap Lainnya', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-114', 'nama' => 'Biaya Pengembangan Kurikulum', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-115', 'nama' => 'Biaya Sosialisasi dan Promosi', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-116', 'nama' => 'Biaya Penyuluhan dan Pelatihan', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-117', 'nama' => 'Biaya Persediaan ATK', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-118', 'nama' => 'Biaya Lainnya', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
        ];

        $dataTK = [
            ['kode' => '1-101', 'nama' => 'Kas Tunai', 'tipe' => 'Kas', 'jenis' => 'KAS', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-201', 'nama' => 'Bank BCA', 'tipe' => 'Bank', 'jenis' => 'BANK', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-202', 'nama' => 'Bank BRI', 'tipe' => 'Bank', 'jenis' => 'BANK', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-203', 'nama' => 'Bank BNI', 'tipe' => 'Bank', 'jenis' => 'BANK', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-301', 'nama' => 'Piutang Jangka Pendek', 'tipe' => 'Piutang', 'jenis' => 'PIUTANG', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-302', 'nama' => 'Piutang Jangka Panjang', 'tipe' => 'Piutang', 'jenis' => 'PIUTANG', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-303', 'nama' => 'Piutang Lainnya', 'tipe' => 'Piutang', 'jenis' => 'PIUTANG', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-401', 'nama' => 'Persediaan ATK', 'tipe' => 'Persediaan', 'jenis' => 'PERSEDIAAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-402', 'nama' => 'Persediaan Lainnya', 'tipe' => 'Persediaan', 'jenis' => 'PERSEDIAAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-501', 'nama' => 'Pembelian Dibayar di Muka', 'tipe' => 'Aktiva Lancar Lainnya', 'jenis' => 'ASET LANCAR LAINNYA', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-502', 'nama' => 'Beban Dibayar di Muka Lainnya', 'tipe' => 'Aktiva Lancar Lainnya', 'jenis' => 'ASET LANCAR LAINNYA', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-601', 'nama' => 'Inventaris', 'tipe' => 'Aktiva Tetap', 'jenis' => 'ASET TIDAK LANCAR', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-602', 'nama' => 'Kendaraan', 'tipe' => 'Aktiva Tetap', 'jenis' => 'ASET TIDAK LANCAR', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-603', 'nama' => 'Bangunan', 'tipe' => 'Aktiva Tetap', 'jenis' => 'ASET TIDAK LANCAR', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-604', 'nama' => 'Aktiva Tetap Lainnya', 'tipe' => 'Aktiva Tetap', 'jenis' => 'ASET TIDAK LANCAR', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-605', 'nama' => 'Aset Tidak Berwujud', 'tipe' => 'Aktiva Tetap', 'jenis' => 'ASET TIDAK LANCAR', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-606', 'nama' => 'Akum. Peny. Inventaris', 'tipe' => 'Akum. Penyusutan', 'jenis' => 'ASET TIDAK LANCAR', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-607', 'nama' => 'Akum. Peny. Kendaraan', 'tipe' => 'Akum. Penyusutan', 'jenis' => 'ASET TIDAK LANCAR', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-608', 'nama' => 'Akum. Peny. Bangunan', 'tipe' => 'Akum. Penyusutan', 'jenis' => 'ASET TIDAK LANCAR', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-609', 'nama' => 'Akum. Peny. Aktiva Tetap Lainnya', 'tipe' => 'Akum. Penyusutan', 'jenis' => 'ASET TIDAK LANCAR', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '1-610', 'nama' => 'Akum. Peny. Aset Tidak Berwujud', 'tipe' => 'Akum. Penyusutan', 'jenis' => 'ASET TIDAK LANCAR', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '2-101', 'nama' => 'Hutang Usaha Jangka Pendek', 'tipe' => 'Kewajiban Jangka Pendek', 'jenis' => 'LIABILITAS', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '2-201', 'nama' => 'Hutang Bank', 'tipe' => 'Kewajiban Jangka Panjang', 'jenis' => 'LIABILITAS', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '2-202', 'nama' => 'Hutang Gaji', 'tipe' => 'Kewajiban Jangka Panjang', 'jenis' => 'LIABILITAS', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '2-203', 'nama' => 'Hutang BPJS', 'tipe' => 'Kewajiban Jangka Panjang', 'jenis' => 'LIABILITAS', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '2-204', 'nama' => 'Hutang Iuran Pribadi BPJS', 'tipe' => 'Kewajiban Jangka Panjang', 'jenis' => 'LIABILITAS', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '2-205', 'nama' => 'Hutang Jangka Panjang Lainnya', 'tipe' => 'Kewajiban Jangka Panjang', 'jenis' => 'LIABILITAS', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '3-101', 'nama' => 'Aset Neto', 'tipe' => 'Aset Neto', 'jenis' => 'ASET NETO', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '4-101', 'nama' => 'Pendapatan SPP', 'tipe' => 'Pendapatan', 'jenis' => 'PENDAPATAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '4-102', 'nama' => 'Pendapatan JPI', 'tipe' => 'Pendapatan', 'jenis' => 'PENDAPATAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '4-103', 'nama' => 'Pendapatan Biaya egistrasi', 'tipe' => 'Pendapatan', 'jenis' => 'PENDAPATAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '4-104', 'nama' => 'Pendapatan Outbond', 'tipe' => 'Pendapatan', 'jenis' => 'PENDAPATAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '4-105', 'nama' => 'Pendapatan Overtime', 'tipe' => 'Pendapatan', 'jenis' => 'PENDAPATAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '4-106', 'nama' => 'Pendapatan Lainnya', 'tipe' => 'Pendapatan', 'jenis' => 'PENDAPATAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-101', 'nama' => 'Biaya Listrik', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-102', 'nama' => 'Biaya Air', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-103', 'nama' => 'Biaya Telepon dan Internet', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-104', 'nama' => 'Biaya Rapat', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-105', 'nama' => 'Biaya Fotokopi dan Penjilidan', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-106', 'nama' => 'Biaya Perbaikan', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-107', 'nama' => 'Biaya Program Kegiatan Siswa', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-108', 'nama' => 'Biaya Transport', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-109', 'nama' => 'Biaya Gaji', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-110', 'nama' => 'Biaya BPJS', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-111', 'nama' => 'Biaya Pajak Bangunan', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-112', 'nama' => 'Biaya Pajak Kendaraan', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-113', 'nama' => 'Biaya Penyusutan Aset Tetap Lainnya', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-114', 'nama' => 'Biaya Pengembangan Kurikulum', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-115', 'nama' => 'Biaya Sosialisasi dan Promosi', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-116', 'nama' => 'Biaya Penyuluhan dan Pelatihan', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-117', 'nama' => 'Biaya Persediaan ATK', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-118', 'nama' => 'Biaya Outbound', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-119', 'nama' => 'Biaya Ekstrakulikuler', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ['kode' => '5-120', 'nama' => 'Biaya Lainnya', 'tipe' => 'Beban', 'jenis' => 'BEBAN', 'kelompok' => '-', 'saldo_awal' => 0, 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
        ];

        DB::table('t_akun')->truncate();

        foreach ($dataYayasan as $akun) {
            $akun['instansi_id'] = 1;
            DB::table('t_akun')->insert($akun);
        }

        foreach ($dataTK as $akun) {
            $akun['instansi_id'] = 2;
            DB::table('t_akun')->insert($akun);
        }

        foreach ($dataSMP as $akun) {
            $akun['instansi_id'] = 3;
            DB::table('t_akun')->insert($akun);
        }
    }
}
