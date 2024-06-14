<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Buku Besar</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <td>Saldo Awal</td>
                <td>{{ $saldo_awal }}</td>
                <td></td>
                <td>Saldo Akhir</td>
                <td>{{ $saldo_akhir }}</td>
            </tr>
            <tr></tr>
            <tr></tr>
            <tr>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Debit</th>
                <th>Kredit</th>
                <th>Saldo</th>
            </tr>
        </thead>
        <tbody>
            @php
                $i = 0;
                $temp_saldo = $saldo_awal;
            @endphp
            @foreach ($bukubesar as $item)
                <tr>
                    <td>
                        {{ \Carbon\Carbon::createFromFormat('Y-m-d', $item->tanggal)->format('Y-m-d') }}
                    </td>
                    <td>
                        {{ $item->keterangan }}
                    </td>
                    <td>
                        {{ $item->akun_debit ? $item->nominal : 0 }}
                    </td>
                    <td>
                        {{ $item->akun_kredit ? $item->nominal : 0 }}
                    </td>
                    <td>
                        {{ $item->akun_debit ? $temp_saldo += $item->nominal : $temp_saldo -= $item->nominal }}
                    </td>
                </tr>
                @php
                    $i++;
                @endphp
            @endforeach
        </tbody>
    </table>
</body>
</html>
