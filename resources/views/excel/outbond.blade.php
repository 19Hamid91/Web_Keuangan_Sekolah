<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Outbond</title>
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
    <h2>Daftar Outbond</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Biro</th>
                <th>Tanggal Pembayaran</th>
                <th>Tanggal Outbond</th>
                <th>Tempat Outbond</th>
                <th>Harga Outbond</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->biro->nama }}</td>
                <td>{{ $item->tanggal_pembayaran }}</td>
                <td>{{ $item->tanggal_outbond }}</td>
                <td>{{ $item->tempat_outbond }}</td>
                <td>{{ $item->harga_outbond }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>TOTAL</td>
                <td>{{ $data->sum('harga_outbond') }}</td>
                <td>&nbsp;</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
