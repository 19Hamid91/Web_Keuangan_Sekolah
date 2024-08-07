<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Buku Besar</title>
</head>
<body>
    <h2><center>Buku Besar {{ $bulan }} {{  $tahun }}</center></h2>
    <h4>Akun: {{ $getAkun->first()->kode }} {{ $getAkun->first()->nama }}</h4>
    <h4>Saldo Awal: {{ formatRupiah($saldo_awal) }}</h4>
    <h4>Saldo Akhir: {{ formatRupiah($saldo_akhir) }}</h4>
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Debit</th>
                <th>Kredit</th>
                <th>Saldo</th>
            </tr>
        </thead>
        <tbody>
            @php
                $i = 0;
                $temp_saldo = $saldo_awal;
                $total_debit = 0;
                $total_kredit = 0;
            @endphp
            @foreach ($bukubesar as $item)
            @php
                $debit = $item->akun_debit ? $item->nominal : 0;
                $kredit = $item->akun_kredit ? $item->nominal : 0;
                $total_debit += $debit;
                $total_kredit += $kredit;
                if ($getAkun->first()->posisi == 'DEBIT' && $item->akun_debit) {
                    $temp_saldo += $item->nominal;
                } elseif ($getAkun->first()->posisi == 'DEBIT' && $item->akun_kredit) {
                    $temp_saldo -= $item->nominal;
                } elseif ($getAkun->first()->posisi == 'KREDIT' && $item->akun_kredit) {
                    $temp_saldo += $item->nominal;
                } elseif ($getAkun->first()->posisi == 'KREDIT' && $item->akun_debit) {
                    $temp_saldo -= $item->nominal;
                }
            @endphp
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $item->tanggal)->format('d-m-Y') }}</td>
                <td>{{ $item->keterangan }}</td>
                <td>{{ formatRupiah($debit) }}</td>
                <td>{{ formatRupiah($kredit) }}</td>
                <td>{{ formatRupiah($temp_saldo) }}</td>
            </tr>
            @php
                $i++;
            @endphp
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" style="text-align: right;"><strong>TOTAL</strong></td>
                <td>{{ formatRupiah($total_debit) }}</td>
                <td>{{ formatRupiah($total_kredit) }}</td>
                <td></td>
            </tr>
        </tfoot>
    </table>    
</body>
</html>
