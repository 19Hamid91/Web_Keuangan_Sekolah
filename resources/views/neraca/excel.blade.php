<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Neraca Saldo</title>
</head>
<body>
    <h1>Neraca Saldo Periode {{ $bulan }} {{ $tahun }}</h1>
    <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Akun</th>
            <th>Debit</th>
            <th>Kredit</th>
            <th>Saldo</th>
          </tr>
        </thead>
        <tbody id="tableBody">
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
