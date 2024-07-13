<!DOCTYPE html>
<html>
<head>
    <title>Tagihan Siswa</title>
</head>
<body>
    <h1>Tagihan untuk {{ $studentName }}</h1>
    
    <table border="1" cellspacing="0" cellpadding="10">
        <thead>
            <tr>
                <th>Jenis Tagihan</th>
                <th>Nominal</th>
                <th>Tanggal Jatuh Tempo</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bills as $bill)
                <tr>
                    <td>{{ $bill['type'] }}</td>
                    <td>{{ formatRupiah($bill['amount']) }}</td>
                    <td>{{ formatTanggal($bill['due_date']) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td><strong>Total</strong></td>
                <td><strong>{{ formatRupiah($totalAmount) }}</strong></td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
