<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pembelian Aset</title>
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
    <h2>Daftar Pembelian Aset</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Supplier</th>
                <th>Aset</th>
                <th>Tanggal</th>
                <th>Satuan</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
                <th>Jumlah Bayar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->supplier->nama_supplier }}</td>
                <td>{{ $item->aset->nama_aset }}</td>
                <td>{{ $item->tgl_beliaset }}</td>
                <td>{{ $item->satuan }}</td>
                <td>{{ $item->jumlah_aset }}</td>
                <td>{{ $item->hargasatuan_aset }}</td>
                <td>{{ $item->jumlahbayar_aset }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
