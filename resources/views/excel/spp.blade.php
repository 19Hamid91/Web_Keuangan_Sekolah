<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar SPP</title>
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
    <h2>Daftar SPP</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tagihan Siswa</th>
                <th>NIS</th>
                <th>Siswa</th>
                <th>Tanggal</th>
                <th>Total</th>
                <th>Sisa</th>
                <th>Tipe Pembayaran</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->tagihan_siswa->jenis_tagihan }}</td>
                <td>{{ $item->siswa->nama_siswa }}</td>
                <td>{{ $item->siswa->nama_siswa }}</td>
                <td>{{ $item->tanggal }}</td>
                <td>{{ $item->total }}</td>
                <td>{{ $item->sisa }}</td>
                <td>{{ $item->tipe_pembayaran }}</td>
                <td>{{ $item->status }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>TOTAL</td>
                <td>{{$data->sum('total') }}</td>
                <td>{{$data->sum('sisa') }}</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
