<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Jurnals</title>
</head>
<body>
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
            @foreach($jurnals as $jurnal)
                <tr>
                    <td>{{ $jurnal->tanggal }}</td>
                    <td>{{ $jurnal->keterangan }}</td>
                    <td>{{ $jurnal->debit ? $jurnal->debit->kode . ' - ' . $jurnal->debit->nama : '-' }}</td>
                    <td>{{ $jurnal->kredit ? $jurnal->kredit->kode . ' - ' . $jurnal->kredit->nama : '-' }}</td>
                    <td>{{ $jurnal->nominal }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>TOTAL</td>
                <td>{{ $totalNominal }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
