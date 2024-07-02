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
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Akun Debit</th>
                <th>Akun Kredit</th>
                <th>Nominal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $jurnal)
                <tr>
                    <td>{{ formatTanggal($jurnal['tanggal']) }}</td>
                    <td>{{ $jurnal['keterangan'] }}</td>
                    <td>{{ $jurnal['debit'] ? $jurnal['debit']['kode'] . ' - ' . $jurnal['debit']['nama'] : '-' }}</td>
                    <td>{{ $jurnal['kredit'] ? $jurnal['kredit']['kode'] . ' - ' . $jurnal['kredit']['nama'] : '-' }}</td>
                    <td>{{ formatRupiah($jurnal['nominal']) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" style="text-align: right;">TOTAL</td>
                <td>{{ formatRupiah($totalNominal) }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
