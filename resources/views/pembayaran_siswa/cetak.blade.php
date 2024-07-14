<!DOCTYPE html>
<html>
<head>
    <style>
        @page { 
            size: 210mm 99mm; margin: 0; 
        }
        body { 
            font-family: Arial, sans-serif; 
        }
        .header { 
            text-align: center; 
        }
        .content { 
            margin: 20px 20px 0px 20px;
            font-size: 0.9rem 
        }
        .signatures {
            width: 100%;
        }
        .signatures td {
            width: 33.3%;
            text-align: center;
            vertical-align: top;
        }
        .signatures .center, .signatures .right {
            padding-top: 0px;
            margin-top: 0px;
        }
        .signatures .left {
            width: 33.3%;
        }
        hr {
            border: none;
            border-top: 2px solid black;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    @php
        if($instansi_id == 1){
            $instansi = 'Yayasan Amal';
        } elseif($instansi_id == 2){
            $instansi = 'KB-TK-TPA ISLAM';
        } elseif($instansi_id == 3){
            $instansi = 'SMP ISLAM';
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
        <h2 style="margin:1">{{ $instansi }} TERPADU PAPB</h2>
        <p style="margin:1">Jl. Panda Barat No. 44 Semarang 50199</p>
        <hr>
        <h3 style="margin:1">KWITANSI PEMBAYARAN</h3>
    </div>
    <div class="content">
        <table>
            <tr>
                <td>Sudah terima dari</td>
                <td>: </td>
            </tr>
            <tr>
                <td>Uang Sejumlah</td>
                <td>: {{ formatRupiah($total) }}</td>
            </tr>
            <tr>
                <td>Terbilang</td>
                <td style="font-style: italic;">: {{ terbilang($total) }} Rupiah</td>
            </tr>
            <tr>
                <td>Untuk Pembayaran</td>
                <td>: {{ $keterangan }} atas nama {{ $siswa }}</td>
            </tr>
        </table>
        <table class="signatures">
            <tr>
                <td class="left"></td>
                <td class="center" style="margin: 1;">
                    <p style="visibility: hidden;">.</p>
                    <p>Diserahkan oleh,</p>
                    <br><br>
                    <p>(....................................)</p>
                </td>
                <td class="right" style="margin: 1;">
                    <p>{{ formatTanggal($tanggal) }}</p>
                    <p>Diterima oleh,</p>
                    <br><br>
                    <p>Bendahara {{ $penerima }}</p>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>