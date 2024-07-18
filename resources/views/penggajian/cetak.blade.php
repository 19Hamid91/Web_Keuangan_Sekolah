<!DOCTYPE html>
<html>
<head>
    <style>
        body { 
            font-family: Arial, sans-serif; 
        }
        .header { 
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            position: relative;
        }
        .header img {
            position: absolute;
            width: 100px;
            height: auto;
            top: 15;
            left: 70;
            height: 60px;
        }
        .header-content {
            flex: 1;
        }
        .content { 
            margin: 20px 20px 0px 20px;
            font-size: 0.9rem 
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }

        table, th, td {
            border: 1px solid black;
        }
        
        th, td {
            padding: 8px;
            text-align: left;
        }

        .header-table, 
        .header-table th, 
        .header-table td {
            border: none;
        }

        .signatures {
            width: 100%;
            border: none;
        }
        .signatures td {
            width: 33.3%;
            text-align: center;
            vertical-align: top;
            border: none;
        }
        .signatures .right {
            padding-top: 0px;
            margin-top: 0px;
            border: none;
        }
        .signatures .left {
            width: 33.3%;
            border: none;
        }
    </style>
</head>
<body>
    @php
        if($instansi_id == 1){
            $instansi = 'Yayasan Amal';
            $path = "./logo-yayasan.png";
        } elseif($instansi_id == 2){
            $instansi = 'KB-TK-TPA ISLAM';
            $path = "./logo-tk.jpg";
        } elseif($instansi_id == 3){
            $instansi = 'SMP ISLAM';
            $path = "./logo-smp.png";
        }

        if($instansi_id == 1){
            $penerima = 'Yayasan';
        } elseif($instansi_id == 2){
            $penerima = 'KB-TK-TPA';
        } elseif($instansi_id == 3){
            $penerima = 'SMP';
        }
    @endphp
    <div class="header">
        <img src="{{ $path }}" alt="Logo">
        <div class="header-content">
            <h4>{{ $instansi }} TERPADU PAPB</h4>
            <h4>JL. PANDA BARAT NO 44 SEMARANG</h4>
            <br>
            <h4>DAFTAR GAJI / HONOR GURU DAN KARYAWAN</h4>
            <table class="header-table" style="width: 100%">
                <tr>
                    <td style="width: 51%">BULAN</td>
                    <td>: {{ $presensi['bulan'] }} {{ $presensi['tahun'] }}</td>
                </tr>
                <tr>
                    <td>NAMA</td>
                    <td>: {{ $pegawai['nama_gurukaryawan'] }}</td>
                </tr>
                <tr>
                    <td>JABATAN</td>
                    <td>: {{ $jabatan['jabatan'] }}</td>
                </tr>
                <tr>
                    <td>STATUS</td>
                    <td>: {{ $jabatan['status'] }}</td>
                </tr>
            </table>
        </div>
    </div>
    <div class="content">
        <table>
            <thead>
                <tr style="background-color: rgb(191, 188, 188)">
                    <th>No</th>
                    <th>URAIAN</th>
                    <th>KETERANGAN</th>
                    <th>JUMLAH</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Gaji Pokok</td>
                    <td></td>
                    <td>{{ formatRupiah($jabatan['gaji_pokok']) }}</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Tunjangan Jabatan</td>
                    <td></td>
                    <td>{{ formatRupiah($jabatan['tunjangan_jabatan']) }}</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Tunjangan Suami/Istri</td>
                    <td></td>
                    <td>{{ formatRupiah($jabatan['tunjangan_istrisuami']) }}</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Tunjangan Anak</td>
                    <td></td>
                    <td>{{ formatRupiah($jabatan['tunjangan_anak']) }}</td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>Tunjangan Pendidikan</td>
                    <td></td>
                    <td>{{ formatRupiah($jabatan['tunjangan_pendidikan']) }}</td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>Dana Pensiun</td>
                    <td></td>
                    <td>{{ formatRupiah($jabatan['dana_pensiun']) }}</td>
                </tr>
                <tr>
                    <td>7</td>
                    <td>BPJS Kesehatan 4%</td>
                    <td></td>
                    <td>{{ formatRupiah($jabatan['bpjs_kes_sekolah']) }}</td>
                </tr>
                <tr>
                    <td>8</td>
                    <td>BPJS Ketenagakerjaan 6,24%</td>
                    <td></td>
                    <td>{{ formatRupiah($jabatan['bpjs_ktk_sekolah']) }}</td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center">JUMLAH GAJI</td>
                    <td></td>
                    <td>{{ formatRupiah($gaji_kotor) }}</td>
                </tr>
                <tr>
                    <td colspan="2">Potongan BPJS</td>
                    <td></td>
                    <td style="color: red">{{ formatRupiah($jabatan['bpjs_kes_sekolah'] + $jabatan['bpjs_ktk_sekolah']) }}</td>
                </tr>
                <tr>
                    <td colspan="2">Potongan BPJS Pribadi</td>
                    <td></td>
                    <td style="color: red">{{ formatRupiah($jabatan['bpjs_kes_pribadi'] + $jabatan['bpjs_ktk_pribadi']) }}</td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center">GAJI BERSIH</td>
                    <td></td>
                    <td>{{ formatRupiah($total_gaji) }}</td>
                </tr>
            </tbody>
        </table>
        <table class="signatures">
            <tr>
                <td class="left" style="margin: 1;">
                    <p style="visibility: hidden;">.</p>
                    <p>Penerima</p>
                    <br><br>
                    <p>(....................................)</p>
                </td>
                <td class="center"></td>
                <td class="right" style="margin: 1;">
                    <p style="text-align: left">Semarang, {{ formatTanggalSekarang() }}</p>
                    <p style="text-align: left">Bendahara {{ $instansi }} PAPB</p>
                    <br><br>
                    <p>(....................................)</p>
                </td>
            </tr>
        </table>
</body>
</html>