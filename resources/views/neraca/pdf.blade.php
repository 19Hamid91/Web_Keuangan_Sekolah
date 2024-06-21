<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Neraca</title>
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
    <h1><center>Neraca Periode {{ $bulan }} {{ $tahun }}</center></h1>
    <table>
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Akun</th>
            <th>Debit</th>
            <th>Kredit</th>
            <th>Saldo</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($data as $item)
            <tr>
              <td>
                  {{ $loop->iteration }}
              </td>
              <td>
                  {{ $item['nama_akun'] }}
              </td>
              <td>
                  {{ $item['total_debit'] ? formatRupiah($item['total_debit']) : 0 }}
              </td>
              <td>
                  {{ $item['total_kredit'] ? formatRupiah($item['total_kredit']) : 0 }}
              </td>
              <td>
                  {{ $item['saldo_bersih'] ? formatRupiah($item['saldo_bersih']) : 0 }}
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
</body>
</html>
