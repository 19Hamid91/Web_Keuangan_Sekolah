<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Gaji</title>
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
    <h2>Daftar Gaji</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Karyawan</th>
                <th>Jabatan</th>
                <th>Potongan BPJS</th>
                <th>Total Gaji</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ formatTanggal($item->created_at) }}</td>
                <td>{{ $item->pegawai->nama_gurukaryawan }}</td>
                <td>{{ $item->jabatan->jabatan }}</td>
                <td>{{ $item->potongan_bpjs }}</td>
                <td>{{ $item->total_gaji }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
