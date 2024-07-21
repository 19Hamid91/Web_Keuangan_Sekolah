<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Operasional</title>
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
    <h2>Daftar Operasional</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Karyawan</th>
                <th>Jenis</th>
                <th>Tanggal Pembayaran</th>
                <th>Jumlah Tagihan</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->pegawai->nama_gurukaryawan }}</td>
                <td>{{ $item->jenis }}</td>
                <td>{{ $item->tanggal_pembayaran }}</td>
                <td>{{ $item->jumlah_tagihan }}</td>
                <td>{{ $item->keterangan }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>TOTAL</td>
                <td>{{ $data->sum('jumlah_tagihan') }}</td>
                <td>&nbsp;</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
