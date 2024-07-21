<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Neraca Saldo</title>
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
    @php
      $totalDebit = array_sum(array_column($data, 'total_debit'));
      $totalKredit = array_sum(array_column($data, 'total_kredit'));
    @endphp
    <h1><center>Neraca Saldo Periode {{ $bulan }} {{ $tahun }}</center></h1>
    <h4>Total Debit: {{ $totalDebit ? formatRupiah($totalDebit) : 0 }}</h4>
    <h4>Total Kredit: {{ $totalKredit ? formatRupiah($totalKredit) : 0 }}</h4>
    <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th width="5%">No</th>
          <th>Nama Akun</th>
          <th>Debit</th>
          <th>Kredit</th>
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
                {{ $item['total_debit'] ? formatRupiah($item['saldo_bersih']) : 0 }}
            </td>
            <td>
                {{ $item['total_kredit'] ? formatRupiah($item['saldo_bersih']) : 0 }}
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
</body>
</html>
