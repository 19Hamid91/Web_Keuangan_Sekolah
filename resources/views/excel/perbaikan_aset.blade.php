<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Perbaikan Aset</title>
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
    <h2>Daftar Perbaikan Aset</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>teknisi</th>
                <th>Aset</th>
                <th>Tanggal</th>
                <th>Jenis</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->teknisi->nama }}</td>
                <td>{{ $item->aset->nama_aset }}</td>
                <td>{{ $item->tanggal }}</td>
                <td>{{ $item->jenis }}</td>
                <td>{{ $item->harga }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>Total</td>
                <td>{{ $data->sum('harga') }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
