<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Jurnals</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1><center>Jurnal Periode {{ $bulan }} {{ $tahun }}</center></h1>
    <table id="example1" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Akun</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Debit</th>
                <th>Kredit</th>
            </tr>
        </thead>
        <tbody id="tableBody">
            @php
                $totalDebit = 0;
                $totalKredit = 0;
                $i = 0;
            @endphp
            @foreach ($data as $item)
            @php
                $debit = $item->akun_debit ? formatRupiah2($item->nominal) : 0;
                $kredit = $item->akun_kredit ? formatRupiah2($item->nominal) : 0;
                $totalDebit += $item->akun_debit ? $item->nominal : 0;
                $totalKredit += $item->akun_kredit ? $item->nominal : 0;
            @endphp
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $item->akun_debit ? ($item->debit->kode . ' - ' . $item->debit->nama) : ($item->kredit->kode . ' - ' . $item->kredit->nama) }}</td>
                <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $item->tanggal)->format('d-m-Y') }}</td>
                <td>{{ $item->keterangan }}</td>
                <td>{{ $debit }}</td>
                <td>{{ $kredit }}</td>
            </tr>
            @php
                $i++;
            @endphp
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" style="text-align: right;">TOTAL</td>
                <td>{{ formatRupiah($totalDebit) }}</td>
                <td>{{ formatRupiah($totalKredit) }}</td>
            </tr>
        </tfoot>
    </table>    
</body>
</html>
