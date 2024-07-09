<?php

if (!function_exists('formatRupiah')) {
    function formatRupiah($amount)
    {
        return 'Rp. ' . number_format($amount, 0, ',', '.');
    }
}

if (!function_exists('formatRupiah2')) {
    function formatRupiah2($amount2)
    {
        return number_format($amount2, 0, ',', '.');
    }
}

if (!function_exists('formatTanggal')) {
    function formatTanggal($date)
    {
        return \Carbon\Carbon::parse($date)->format('d/m/Y');
    }
}

if (!function_exists('formatTanggalSekarang')) {
    function formatTanggalSekarang()
    {
        $date = \Carbon\Carbon::now();
        $months = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        $day = $date->day;
        $month = $months[$date->month - 1];
        $year = $date->year;

        return "{$day} {$month} {$year}";
    }
}

if (!function_exists('terbilang')) {
    function terbilang($angka) {
        $angka = abs($angka);  // Mengubah angka menjadi nilai absolut
        $bilangan = array(
            "", "Satu", "Dua", "Tiga", "Empat", "Lima",
            "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"
        );

        $hasil = "";

        if ($angka < 12) {
            $hasil = " " . $bilangan[$angka];
        } elseif ($angka < 20) {
            $hasil = terbilang($angka - 10) . " Belas";
        } elseif ($angka < 100) {
            $hasil = terbilang(floor($angka / 10)) . " Puluh " . terbilang($angka % 10);
        } elseif ($angka < 200) {
            $hasil = " Seratus " . terbilang($angka - 100);
        } elseif ($angka < 1000) {
            $hasil = terbilang(floor($angka / 100)) . " Ratus " . terbilang($angka % 100);
        } elseif ($angka < 2000) {
            $hasil = " Seribu " . terbilang($angka - 1000);
        } elseif ($angka < 1000000) {
            $hasil = terbilang(floor($angka / 1000)) . " Ribu " . terbilang($angka % 1000);
        } elseif ($angka < 1000000000) {
            $hasil = terbilang(floor($angka / 1000000)) . " Juta " . terbilang($angka % 1000000);
        } elseif ($angka < 1000000000000) {
            $hasil = terbilang(floor($angka / 1000000000)) . " Milyar " . terbilang($angka % 1000000000);
        } elseif ($angka < 1000000000000000) {
            $hasil = terbilang(floor($angka / 1000000000000)) . " Triliun " . terbilang($angka % 1000000000000);
        }

        return trim(preg_replace('/\s+/', ' ', $hasil));
    }
}
