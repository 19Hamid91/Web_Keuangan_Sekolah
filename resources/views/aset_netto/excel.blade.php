<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Aset Neto</title>
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
        <h3 style="margin:1">LAPORAN ASET NETO</h3>
        <h3 style="margin:1">Periode {{ $bulan }} {{ $tahun }}</h3>
        <hr>
    </div>
    <div class="content">
        <table id="example1" class="table table-bordered table-striped">
            <tbody id="tableBody">
              <tr>
                <th colspan="2" style="text-align: left;font-weight: bold;">ASET NETTO</th>
              </tr>
              @php
                  $totalAset_Neto = 0;
              @endphp
              @foreach ($akuns as $akun)
              @if($akun->jenis == 'ASET NETO')
                    @php
                        $saldoItem = collect($saldoAkun)->firstWhere('akun_id', $akun->id);
                    @endphp
                    @if($saldoItem)
                        @php
                            $totalAset_Neto += ($saldoItem['saldo_bersih']);
                        @endphp
                      @endif
              @endif
              @endforeach
              <tr>
                <td>Aset Neto</td>
                <td>{{ formatRupiah($totalAset_Neto) }}</td>
              </tr>

              @php
                  $totalPendapatan = 0;
              @endphp
              @foreach ($akuns as $akun)
              @if($akun->jenis == 'PENDAPATAN')
                    @php
                        $saldoItem = collect($saldoAkun)->firstWhere('akun_id', $akun->id);
                    @endphp
                    
                    @if($saldoItem)
                        @php
                            $totalPendapatan += ($saldoItem['saldo_bersih'] * -1);
                        @endphp
                      @endif
              @endif
              @endforeach

              @php
                  $totalBeban = 0;
              @endphp
              @foreach ($akuns as $akun)
              @if($akun->jenis == 'BEBAN')
                    @php
                        $saldoItem = collect($saldoAkun)->firstWhere('akun_id', $akun->id);
                    @endphp
                    
                    @if($saldoItem)
                        @php
                            $totalBeban += ($saldoItem['saldo_bersih']);
                        @endphp
                      @endif
              @endif
              @endforeach
              <tr>
                <td>Surplus/Defisit Tahun Berjalan</td>
                <td>{{ formatRupiah(($totalPendapatan - $totalBeban)) }}</td>
              </tr>
              <tr>
                <td>Saldo Akhir</td>
                <td>{{ formatRupiah(($totalPendapatan - $totalBeban + $totalAset_Neto)) }}</td>
              </tr>
            </tbody>
          </table>
    </div>
</body>
</html>