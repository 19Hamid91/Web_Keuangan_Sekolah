<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pembelian ATK</title>
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
        .no-border {
            border: none;
        }
    </style>
</head>
<body>
    <h2>Daftar Pembelian ATK</h2>
    <table class="main-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Supplier</th>
                <th>Tanggal Beli</th>
                <th>ATK</th>
                <th>Satuan</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
                <th>Total Harga</th>
                <th>Total Pembelian</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->supplier->nama_supplier }}</td>
                <td>{{ $item->tgl_beliatk }}</td>
                <td>
                    @foreach ($item->komponen as $komponen)
                    {{ $komponen->atk->nama_atk ?? '' }}<br>
                    @endforeach
                </td>
                <td>
                    @foreach ($item->komponen as $komponen)
                    {{ $komponen->satuan ?? '' }}<br>
                    @endforeach
                </td>
                <td>
                    @foreach ($item->komponen as $komponen)
                    {{ $komponen->jumlah ?? '' }}<br>
                    @endforeach
                </td>
                <td>
                    @foreach ($item->komponen as $komponen)
                    {{ $komponen->harga_satuan ? formatRupiah($komponen->harga_satuan) : '' }}<br>
                    @endforeach
                </td>
                <td>
                    @foreach ($item->komponen as $komponen)
                    {{ $komponen->harga_total ? formatRupiah($komponen->harga_total) : '' }}<br>
                    @endforeach
                </td>
                <td>{{ $item->total ? formatRupiah($item->total) : '' }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="7" class="no-border"></td>
                <td>Total</td>
                <td>{{ formatRupiah($data->sum('total')) }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>