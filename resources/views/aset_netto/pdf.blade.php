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
      .text-right {
        text-align: right;
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
                @if($data_instansi['id'] == 1)
                <th style="text-align: left;font-weight: bold;">ASET NETO TANPA PEMBATASAN</th>
                @else
                <th style="text-align: left;font-weight: bold;">ASET NETO</th>
                @endif
                <th></th>
                </tr>
                @php
                    $totalAset_Neto = 0;
                @endphp
                @foreach ($akuns as $akun)
                @if($akun['tipe'] == 'Aset Neto' && $akun['kelompok'] != 'DENGAN PEMBATASAN')
                    @php
                        $saldoItem = collect($data)->firstWhere('akun_id', $akun['id']);
                    @endphp
                    @if($saldoItem)
                        @php
                            $totalAset_Neto += ($saldoItem['saldo_bersih']);
                        @endphp
                        @endif
                    </tr>
                @endif
                @endforeach
                <tr>
                @if($data_instansi['id'] == 1)
                <td>Aset Neto Tanpa Pembatasan</td>
                @else
                <td>Aset Neto</td>
                @endif
                <td class="text-right">{{ formatRupiah($totalAset_Neto) }}</td>
                </tr>

                @php
                    $totalPendapatan = 0;
                @endphp
                @foreach ($akuns as $akun)
                @if($akun['tipe'] == 'Pendapatan' && $akun['kelompok'] != 'DENGAN PEMBATASAN')
                    @php
                        $saldoItem = collect($data)->firstWhere('akun_id', $akun['id']);
                    @endphp
                    
                    @if($saldoItem)
                        @php
                            $totalPendapatan += ($saldoItem['saldo_bersih']);
                        @endphp
                        @endif
                    </tr>
                @endif
                @endforeach

                @php
                    $totalBeban = 0;
                @endphp
                @foreach ($akuns as $akun)
                @if($akun['tipe'] == 'Beban' && $akun['kelompok'] != 'DENGAN PEMBATASAN')
                    @php
                        $saldoItem = collect($data)->firstWhere('akun_id', $akun['id']);
                    @endphp
                    
                    @if($saldoItem)
                        @php
                            $totalBeban += ($saldoItem['saldo_bersih']);
                        @endphp
                        @endif
                    </tr>
                @endif
                @endforeach
                <tr>
                <td>Surplus/Defisit Tahun Berjalan</td>
                <td class="text-right">{{ formatRupiah(($totalPendapatan - $totalBeban)) }}</td>
                </tr>
                <tr>
                <th>Saldo Akhir</th>
                <th class="text-right">{{ formatRupiah(($totalPendapatan - $totalBeban + $totalAset_Neto)) }}</th>
                </tr>
                @if($data_instansi['id'] == 1)
                <tr>
                <th style="text-align: left;font-weight: bold;">ASET NETO DENGAN PEMBATASAN</th>
                <th></th>
                </tr>
                @php
                    $totalAset_Neto = 0;
                @endphp
                @foreach ($akuns as $akun)
                @if($akun['tipe'] == 'Aset Neto' && $akun['kelompok'] == 'DENGAN PEMBATASAN')
                    @php
                        $saldoItem = collect($data)->firstWhere('akun_id', $akun['id']);
                    @endphp
                    @if($saldoItem)
                        @php
                            $totalAset_Neto += ($saldoItem['saldo_bersih']);
                        @endphp
                        @endif
                    </tr>
                @endif
                @endforeach
                <tr>
                <td>Aset Neto Dengan Pembatasan</td>
                <td class="text-right">{{ formatRupiah($totalAset_Neto) }}</td>
                </tr>

                @php
                    $totalPendapatan = 0;
                @endphp
                @foreach ($akuns as $akun)
                @if($akun['tipe'] == 'Pendapatan' && $akun['kelompok'] == 'DENGAN PEMBATASAN')
                    @php
                        $saldoItem = collect($data)->firstWhere('akun_id', $akun['id']);
                    @endphp
                    
                    @if($saldoItem)
                        @php
                            $totalPendapatan += ($saldoItem['saldo_bersih']);
                        @endphp
                        @endif
                    </tr>
                @endif
                @endforeach

                @php
                    $totalBeban = 0;
                @endphp
                @foreach ($akuns as $akun)
                @if($akun['tipe'] == 'Beban' && $akun['kelompok'] == 'DENGAN PEMBATASAN')
                    @php
                        $saldoItem = collect($data)->firstWhere('akun_id', $akun['id']);
                    @endphp
                    
                    @if($saldoItem)
                        @php
                            $totalBeban += ($saldoItem['saldo_bersih']);
                        @endphp
                        @endif
                    </tr>
                @endif
                @endforeach
                <tr>
                <td>Surplus/Defisit Tahun Berjalan</td>
                <td class="text-right">{{ formatRupiah(($totalPendapatan - $totalBeban)) }}</td>
                </tr>
                <tr>
                <th>Saldo Akhir</th>
                <th class="text-right">{{ formatRupiah(($totalPendapatan - $totalBeban + $totalAset_Neto)) }}</th>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</body>
</html>
