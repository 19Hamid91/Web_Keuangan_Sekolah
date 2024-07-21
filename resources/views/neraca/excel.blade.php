<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Neraca Saldo</title>
</head>
<body>
  @php
  $totalDebit = $data->sum('total_debit');
  $totalKredit = $data->sum('total_kredit');
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
