<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Posisi Keuangan</title>
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
        <h3 style="margin:1">LAPORAN POSISI KEUANGAN</h3>
        <h3 style="margin:1">Periode {{ $bulan }} {{ $tahun }}</h3>
        <hr>
    </div>
    <div class="content">
        <table id="example1" class="table table-bordered table-striped">
            <tbody id="tableBody">
              <tr>
                <th colspan="2" style="text-align: left">Kas</th>
              </tr>
              @php
                  $totalKas = 0;
              @endphp
              @foreach ($akuns as $akun)
              @if($akun['jenis'] == 'KAS')
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
                            $totalKas += ($saldoItem['saldo_bersih']);
                        @endphp
                      @else
                          <td>0</td>
                      @endif
                  </tr>
              @endif
              @endforeach
              <tr>
                <th>Total Kas</th>
                <th>{{ formatRupiah($totalKas) }}</th>
              </tr>

              <tr>
                <th colspan="2" style="text-align: left">Bank</th>
              </tr>
              @php
                  $totalBANK = 0;
              @endphp
              @foreach ($akuns as $akun)
              @if($akun['jenis'] == 'BANK')
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
                            $totalBANK += $saldoItem['saldo_bersih'];
                        @endphp
                      @else
                          <td>0</td>
                      @endif
                  </tr>
              @endif
              @endforeach
              <tr>
                <th>Total Bank</th>
                <th>{{ formatRupiah($totalBANK) }}</th>
              </tr>

              <tr>
                <th colspan="2" style="text-align: left">Persediaan</th>
              </tr>
              @php
                  $totalPERSEDIAAN = 0;
              @endphp
              @foreach ($akuns as $akun)
              @if($akun['jenis'] == 'PERSEDIAAN')
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
                            $totalPERSEDIAAN += $saldoItem['saldo_bersih'];
                        @endphp
                      @else
                          <td>0</td>
                      @endif
                  </tr>
              @endif
              @endforeach
              <tr>
                <th>Total Persediaan</th>
                <th>{{ formatRupiah($totalPERSEDIAAN) }}</th>
              </tr>

              <tr>
                <th colspan="2" style="text-align: left">Piutang</th>
              </tr>
              @php
                  $totalPIUTANG = 0;
              @endphp
              @foreach ($akuns as $akun)
              @if($akun['jenis'] == 'PIUTANG')
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
                            $totalPIUTANG += $saldoItem['saldo_bersih'];
                        @endphp
                      @else
                          <td>0</td>
                      @endif
                  </tr>
              @endif
              @endforeach
              <tr>
                <th>Total Piutang</th>
                <th>{{ formatRupiah($totalPIUTANG) }}</th>
              </tr>

              <tr>
                <th colspan="2" style="text-align: left">Aset Lancar Lainnya</th>
              </tr>
              @php
                  $totalASET_LANCAR_LAINNYA = 0;
              @endphp
              @foreach ($akuns as $akun)
              @if($akun['jenis'] == 'ASET LANCAR LAINNYA')
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
                            $totalASET_LANCAR_LAINNYA += $saldoItem['saldo_bersih'];
                        @endphp
                      @else
                          <td>0</td>
                      @endif
                  </tr>
              @endif
              @endforeach
              <tr>
                <th>Total Aset Lancar Lainnya</th>
                <th>{{ formatRupiah($totalASET_LANCAR_LAINNYA) }}</th>
              </tr>
              <tr>
                <th>Total Aset Lancar</th>
                <th>{{ formatRupiah(($totalKas + $totalBANK + $totalPERSEDIAAN + $totalPIUTANG + $totalASET_LANCAR_LAINNYA)) }}</th>
              </tr>

              <tr>
                <th colspan="2" style="text-align: left">Aset Tidak Lancar</th>
              </tr>
              @php
                  $totalASET_TIDAK_LANCAR = 0;
              @endphp
              @foreach ($akuns as $akun)
              @if($akun['jenis'] == 'ASET TIDAK LANCAR')
                  <tr>
                    <td>{{ $akun['nama'] }}</td>
                    @php
                        $saldoItem = collect($data)->firstWhere('akun_id', $akun['id']);
                    @endphp
                    
                    @if($saldoItem)
                        <td>
                            {{-- @if(strpos($akun['nama'], 'Akum') !== false)
                            {{ $saldoItem['saldo_bersih'] ? formatRupiah(($saldoItem['saldo_bersih'] * -1)) : 0 }}
                            @else --}}
                            {{ $saldoItem['saldo_bersih'] ? formatRupiah($saldoItem['saldo_bersih']) : 0 }}
                            {{-- @endif --}}
                        </td>
                        @php
                            // if (strpos($akun['nama'], 'Akum') !== false) {
                            //   $totalASET_TIDAK_LANCAR -= $saldoItem['saldo_bersih'];
                            // } else {
                              $totalASET_TIDAK_LANCAR += $saldoItem['saldo_bersih'];
                            // }
                        @endphp
                      @else
                          <td>0</td>
                      @endif
                  </tr>
              @endif
              @endforeach
              <tr>
                <th>Total Aset Tidak Lancar</th>
                <th>{{ formatRupiah($totalASET_TIDAK_LANCAR) }}</th>
              </tr>
              
              <tr>
                @php
                    $totalAset = ($totalKas + $totalBANK + $totalPERSEDIAAN + $totalPIUTANG + $totalASET_LANCAR_LAINNYA) + $totalASET_TIDAK_LANCAR;
                @endphp
                <th>Total Aset</th>
                <th>{{ formatRupiah($totalAset) }}</th>
              </tr>
              
              <tr>
                <th colspan="2" style="text-align: left">Liabilitas Jangka Pendek</th>
              </tr>
              @php
                  $totalLiabilitasPendek = 0;
              @endphp
              @foreach ($akuns as $akun)
              @if($akun['jenis'] == 'LIABILITAS JANGKA PENDEK')
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
                            $totalLiabilitasPendek += ($saldoItem['saldo_bersih']);
                        @endphp
                      @else
                          <td>0</td>
                      @endif
                  </tr>
              @endif
              @endforeach
              <tr>
                <th>Total Liabilitas Jangka Pendek</th>
                <th>{{ formatRupiah($totalLiabilitasPendek) }}</th>
              </tr>

              <tr>
                <th colspan="2" style="text-align: left">Liabilitas Jangka Panjang</th>
              </tr>
              @php
                  $totalLiabilitasPanjang = 0;
              @endphp
              @foreach ($akuns as $akun)
              @if($akun['jenis'] == 'LIABILITAS JANGKA PANJANG')
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
                            $totalLiabilitasPanjang += ($saldoItem['saldo_bersih']);
                        @endphp
                      @else
                          <td>0</td>
                      @endif
                  </tr>
              @endif
              @endforeach
              <tr>
                <th>Total Liabilitas Jangka Panjang</th>
                <th>{{ formatRupiah($totalLiabilitasPanjang) }}</th>
              </tr>
              <tr>
                @php
                    $totalLiabilitas = $totalLiabilitasPendek + $totalLiabilitasPanjang;
                @endphp
                <th>Total Liabilitas</th>
                <th>{{ formatRupiah($totalLiabilitas) }}</th>
              </tr>

              <tr>
                <th colspan="2" style="text-align: left">Aset Neto</th>
              </tr>
              @php
                  $totalAset_Neto = 0;
              @endphp
              @foreach ($akuns as $akun)
              @if($akun['jenis'] == 'ASET NETO')
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
                            $totalAset_Neto += ($saldoItem['saldo_bersih']);
                        @endphp
                      @else
                          <td>0</td>
                      @endif
                  </tr>
              @endif
              @endforeach
              <tr>
                <th>Total Aset Neto</th>
                <th>{{ formatRupiah($totalAset_Neto) }}</th>
              </tr>
              <tr>
                <th>Total Liabilitas dan Aset Neto</th>
                <th>{{ formatRupiah(($totalLiabilitas + $totalAset_Neto)) }}</th>
              </tr>
              <tr>
                <th>Selisih Aset dengan Liabilitas dan Aset Neto</th>
                <th>{{ formatRupiah(($totalAset - ($totalLiabilitas + $totalAset_Neto))) }}</th>
              </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
