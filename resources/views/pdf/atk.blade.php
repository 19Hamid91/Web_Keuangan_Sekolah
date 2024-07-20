<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pembelian Atk</title>
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
    <h2>Daftar Pembelian Atk</h2>
    <table>
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
                <td>{{ $item['supplier']['nama_supplier'] }}</td>
                <td>{{ $item['tgl_beliatk'] }}</td>
                <td style="padding: 0;">
                    <table cellspacing="0" cellpadding="5" style="width: 100%; border: none;">
                        @foreach ($item['komponen'] as $komponen)
                        <tr>
                            <td style="border: none;">
                                {{ $komponen['atk']['nama_atk'] ?? '' }}
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </td>
                <td style="padding: 0;">
                    <table cellspacing="0" cellpadding="5" style="width: 100%; border: none;">
                        @foreach ($item['komponen'] as $komponen)
                        <tr>
                            <td style="border: none;">
                                {{ $komponen['satuan'] ?? '' }}
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </td>
                <td style="padding: 0;">
                    <table cellspacing="0" cellpadding="5" style="width: 100%; border: none;">
                        @foreach ($item['komponen'] as $komponen)
                        <tr>
                            <td style="border: none;">
                                {{ $komponen['jumlah'] ?? '' }}
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </td>
                <td style="padding: 0;">
                    <table cellspacing="0" cellpadding="5" style="width: 100%; border: none;">
                        @foreach ($item['komponen'] as $komponen)
                        <tr>
                            <td style="border: none;">
                                {{ $komponen['harga_satuan'] ? formatRupiah($komponen['harga_satuan']) : '' }}
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </td>
                <td style="padding: 0;">
                    <table cellspacing="0" cellpadding="5" style="width: 100%; border: none;">
                        @foreach ($item['komponen'] as $komponen)
                        <tr>
                            <td style="border: none;">
                                {{ $komponen['harga_total'] ? formatRupiah($komponen['harga_total']) : '' }}
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </td>
                <td>{{ $item['total'] ? formatRupiah($item['total']) : '' }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>Total</td>
                <td>{{ formatRupiah(array_sum(array_column($data, 'total'))) }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
