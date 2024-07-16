<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Komprehensif</title>
    <style>
      body {
          font-family: Arial, sans-serif;
      }
      .header { 
          text-align: center; 
      }
      .content { 
          margin: 20px 20px 0px 20px;
          font-size: 0.9rem 
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
        if($data_instansi['id'] == 1){
            $instansi = 'Yayasan Amal';
        } elseif($data_instansi['id'] == 2){
            $instansi = 'KB-TK-TPA ISLAM';
        } elseif($data_instansi['id'] == 3){
            $instansi = 'SMP ISLAM';
        }
    @endphp
    <div class="header">
        <h2 style="margin:1">{{ $instansi }} PAPB SEMARANG</h2>
        <h3 style="margin:1">LAPORAN PENGHASILAN KOMPREHENSIF</h3>
        <h3 style="margin:1">Periode {{ $bulan }} {{ $tahun }}</h3>
        <hr>
    </div>
    <div class="content">
        <table id="example1" class="table table-bordered table-striped">
            <tbody id="tableBody">
              @if($data_instansi['id'] == 1)
              <tr>
                <th colspan="2" style="text-align: center">TANPA PEMBATASAN</th>
              </tr>
              @endif
              <tr>
                <th colspan="2" style="text-align: start">Pendapatan</th>
              </tr>
              @php
                  $totalPendapatan = 0;
              @endphp
              @foreach ($akuns as $akun)
              @if($akun['tipe'] == 'Pendapatan' && $akun['kelompok'] != 'DENGAN PEMBATASAN')
                  <tr>
                    <td>{{ $akun['nama'] }}</td>
                    @php
                        $saldoItem = collect($data)->firstWhere('akun_id', $akun['id']);
                    @endphp
                    
                    @if($saldoItem)
                        <td>
                            {{ $saldoItem['saldo_bersih'] ? formatRupiah(($saldoItem['saldo_bersih'])) : 0 }}
                        </td>
                        @php
                            $totalPendapatan += ($saldoItem['saldo_bersih']);
                        @endphp
                      @else
                          <td>0</td>
                      @endif
                  </tr>
              @endif
              @endforeach
              <tr>
                <th>Total Pendapatan</th>
                <th>{{ formatRupiah($totalPendapatan) }}</th>
              </tr>

              <tr>
                <th colspan="2" style="text-align: cestartnter">Beban</th>
              </tr>
              @php
                  $totalBeban = 0;
              @endphp
              @foreach ($akuns as $akun)
              @if($akun['tipe'] == 'Beban' && $akun['kelompok'] != 'DENGAN PEMBATASAN')
                  <tr>
                    <td>{{ $akun['nama'] }}</td>
                    @php
                        $saldoItem = collect($data)->firstWhere('akun_id', $akun['id']);
                    @endphp
                    
                    @if($saldoItem)
                        <td>
                            {{ $saldoItem['saldo_bersih'] ? formatRupiah($saldoItem['saldo_bersih']) : 0 }}
                        </td>
                        @php
                            $totalBeban += $saldoItem['saldo_bersih'];
                        @endphp
                      @else
                          <td>0</td>
                      @endif
                  </tr>
              @endif
              @endforeach
              <tr>
                <th>Total Beban</th>
                <th>{{ formatRupiah($totalBeban) }}</th>
              </tr>
              <tr>
                @if($data_instansi['id'] == 1)
                <th>Total Penghasilan Komprehensif Tanpa Pembatasan</th>
                @else
                <th>Total Penghasilan Komprehensif</th>
                @endif
                <th>{{ formatRupiah(($totalPendapatan - $totalBeban)) }}</th>
              </tr>
              @if($data_instansi['id'] == 1)
              <tr>
                <th colspan="2" style="text-align: center">DENGAN PEMBATASAN</th>
              </tr>
              <tr>
                <th colspan="2" style="text-align: start">Pendapatan</th>
              </tr>
              @php
                  $totalPendapatan2 = 0;
              @endphp
              @foreach ($akuns as $akun)
              @if($akun['tipe'] == 'Pendapatan' && $akun['kelompok'] == 'DENGAN PEMBATASAN')
                  <tr>
                    <td>{{ $akun['nama'] }}</td>
                    @php
                        $saldoItem = collect($data)->firstWhere('akun_id', $akun['id']);
                    @endphp
                    
                    @if($saldoItem)
                        <td>
                            {{ $saldoItem['saldo_bersih'] ? formatRupiah(($saldoItem['saldo_bersih'])) : 0 }}
                        </td>
                        @php
                            $totalPendapatan2 += ($saldoItem['saldo_bersih']);
                        @endphp
                      @else
                          <td>0</td>
                      @endif
                  </tr>
              @endif
              @endforeach
              <tr>
                <th>Total Pendapatan</th>
                <th>{{ formatRupiah($totalPendapatan2) }}</th>
              </tr>

              <tr>
                <th colspan="2" style="text-align: cestartnter">Beban</th>
              </tr>
              @php
                  $totalBeban2 = 0;
              @endphp
              @foreach ($akuns as $akun)
              @if($akun['tipe'] == 'Beban' && $akun['kelompok'] == 'DENGAN PEMBATASAN')
                  <tr>
                    <td>{{ $akun['nama'] }}</td>
                    @php
                        $saldoItem = collect($data)->firstWhere('akun_id', $akun['id']);
                    @endphp
                    
                    @if($saldoItem)
                        <td>
                            {{ $saldoItem['saldo_bersih'] ? formatRupiah($saldoItem['saldo_bersih']) : 0 }}
                        </td>
                        @php
                            $totalBeban2 += $saldoItem['saldo_bersih'];
                        @endphp
                      @else
                          <td>0</td>
                      @endif
                  </tr>
              @endif
              @endforeach
              <tr>
                <th>Total Beban</th>
                <th>{{ formatRupiah($totalBeban2) }}</th>
              </tr>
              <tr>
                <th>Total Penghasilan Komprehensif Dengan Pembatasan</th>
                <th>{{ formatRupiah(($totalPendapatan2 - $totalBeban2)) }}</th>
              </tr>
              @endif
            </tbody>
          </table>
    </div>
</body>
</html>