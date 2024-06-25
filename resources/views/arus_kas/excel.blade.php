<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Arus Kas</title>
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
        <h3 style="margin:1">LAPORAN ARUS KAS</h3>
        <h3 style="margin:1">Periode {{ $bulan }} {{ $tahun }}</h3>
        <hr>
    </div>
    <div class="content">
        <table id="example1" class="table table-bordered table-striped">
            <tbody id="tableBody">
              <tr>
                <th colspan="2" style="text-align: left">AKTIVITAS OPERASI</th>
              </tr>
              <tr>
                <th colspan="2" style="text-align: left">Pendapatan</th>
              </tr>
              @php
                  $totalPendapatan = 0;
              @endphp
              @foreach ($akuns as $akun)
              @if($akun->jenis == 'PENDAPATAN')
                  <tr>
                    <td>{{ $akun->nama }}</td>
                    @php
                        $saldoItem = collect($saldoAkun)->firstWhere('akun_id', $akun->id);
                    @endphp
                    
                    @if($saldoItem)
                        <td>
                            {{ $saldoItem['saldo_bersih'] ? formatRupiah(($saldoItem['saldo_bersih'] * -1)) : 0 }}
                        </td>
                        @php
                            $totalPendapatan += ($saldoItem['saldo_bersih'] * -1);
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
                <th colspan="2" style="text-align: left">Beban</th>
              </tr>
              @php
                  $totalBeban = 0;
              @endphp
              @foreach ($akuns as $akun)
              @if($akun->jenis == 'BEBAN')
                  <tr>
                    <td>{{ $akun->nama }}</td>
                    @php
                        $saldoItem = collect($saldoAkun)->firstWhere('akun_id', $akun->id);
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
                <th>Total Biaya</th>
                <th>{{ formatRupiah($totalBeban) }}</th>
              </tr>
              <tr>
                <th>Arus Kas Bersih dari Aktivitas Operasi</th>
                <th>{{ formatRupiah(($totalPendapatan - $totalBeban)) }}</th>
              </tr>

              <tr>
                <th colspan="2" style="text-align: left">AKTIVITAS INVESTASI</th>
              </tr>
              <tr>
                <th style="text-align: left">Penerimaan Kas dari Aktivitas Investasi</th>
                <th>0</th>
              </tr>

              <tr>
                <th colspan="2" style="text-align: left">Pengeluaran Kas dari Aktivitas Investasi</th>
              </tr>
              @php
                  $totalPengeluaranInvestasi = 0;
              @endphp
              @foreach ($akuns as $akun)
              @if($akun->tipe == 'Aktiva Tetap')
                  <tr>
                    <td>{{ $akun->nama }}</td>
                    @php
                        $saldoItem = collect($saldoAkun)->firstWhere('akun_id', $akun->id);
                    @endphp
                    
                    @if($saldoItem)
                        <td>
                            {{ $saldoItem['saldo_bersih'] ? formatRupiah($saldoItem['saldo_bersih']) : 0 }}
                        </td>
                        @php
                            $totalPengeluaranInvestasi += $saldoItem['saldo_bersih'];
                        @endphp
                      @else
                          <td>0</td>
                      @endif
                  </tr>
              @endif
              @endforeach
              <tr>
                <th>Total Pengeluaran</th>
                <th>{{ formatRupiah($totalPengeluaranInvestasi) }}</th>
              </tr>
              <tr>
                <th>Arus Kas Bersih dari Aktivitas Investasi</th>
                <th>{{ formatRupiah((0 - $totalPengeluaranInvestasi)) }}</th>
              </tr>

              <tr>
                <th>AKTIVITAS PENDANAAN</th>
                <th>{{ formatRupiah((0 - $totalPengeluaranInvestasi)) }}</th>
              </tr>

              <tr>
                <th style="text-align: left">Penerimaan Kas dari Aktivitas Pendanaan</th>
                <th>0</th>
              </tr>
              <tr>
                <th colspan="2" style="text-align: left">Pengeluaran Kas dari Aktivitas Pendanaan</th>
              </tr>
              @php
                  $totalPengeluaranPendanaan = 0;
              @endphp
              @foreach ($akuns as $akun)
              @if($akun->jenis == 'LIABILITAS JANGKA PENDEK')
                  <tr>
                    <td>{{ $akun->nama }}</td>
                    @php
                        $saldoItem = collect($saldoAkun)->firstWhere('akun_id', $akun->id);
                    @endphp
                    
                    @if($saldoItem)
                        <td>
                            {{ $saldoItem['saldo_bersih'] ? formatRupiah($saldoItem['saldo_bersih']) : 0 }}
                        </td>
                        @php
                            $totalPengeluaranPendanaan += $saldoItem['saldo_bersih'];
                        @endphp
                      @else
                          <td>0</td>
                      @endif
                  </tr>
              @endif
              @endforeach
              @foreach ($akuns as $akun)
              @if($akun->jenis == 'LIABILITAS JANGKA PANJANG')
                  <tr>
                    <td>{{ $akun->nama }}</td>
                    @php
                        $saldoItem = collect($saldoAkun)->firstWhere('akun_id', $akun->id);
                    @endphp
                    
                    @if($saldoItem)
                        <td>
                            {{ $saldoItem['saldo_bersih'] ? formatRupiah($saldoItem['saldo_bersih']) : 0 }}
                        </td>
                        @php
                            $totalPengeluaranPendanaan += $saldoItem['saldo_bersih'];
                        @endphp
                      @else
                          <td>0</td>
                      @endif
                  </tr>
              @endif
              @endforeach
              <tr>
                <th>Total Pengeluaran</th>
                <th>{{ formatRupiah($totalPengeluaranPendanaan) }}</th>
              </tr>
              <tr>
                <th>Arus Kas Bersih dari Aktivitas Pendanaan</th>
                <th>{{ formatRupiah((0 - $totalPengeluaranPendanaan)) }}</th>
              </tr>
              <tr>
                <th>Perubahan Bersih Dalam Kas</th>
                <th>{{ formatRupiah((($totalPendapatan - $totalBeban) + (0 - $totalPengeluaranInvestasi) + (0 - $totalPengeluaranPendanaan))) }}</th>
              </tr>
              <tr>
                <th>Total Kas Awal</th>
                <th>{{ formatRupiah($saldo) }}</th>
              </tr>
              <tr>
                <th>Total Kas Akhir</th>
                <th>{{ formatRupiah(($saldo - (($totalPendapatan - $totalBeban) + (0 - $totalPengeluaranInvestasi) + (0 - $totalPengeluaranPendanaan)))) }}</th>
              </tr>
            </tbody>
          </table>
    </div>
</body>
</html>