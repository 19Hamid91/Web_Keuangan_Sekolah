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
                <th>Total Aktiva Lancar</th>
                <th>{{ formatRupiah(($totalKas + $totalBANK + $totalPERSEDIAAN + $totalPIUTANG)) }}</th>
                </tr>

                <tr>
                <th colspan="2" style="text-align: left">Aktiva Tetap</th>
                </tr>
                @php
                    $totalASET_TIDAK_LANCAR = 0;
                @endphp
                @foreach ($akuns as $akun)
                @if($akun['jenis'] == 'Aktiva Tetap')
                    <tr>
                    <td>{{ $akun['nama'] }}</td>
                    @php
                        $saldoItem = collect($data)->firstWhere('akun_id', $akun['id']);
                    @endphp
                    
                    @if($saldoItem)
                        <td>
                            @if(strpos($akun['nama'], 'Akum') !== false)
                            {{ $saldoItem['saldo_bersih'] ? formatRupiah(($saldoItem['saldo_bersih'] * -1)) : 0 }}
                            @else
                            {{ $saldoItem['saldo_bersih'] ? formatRupiah($saldoItem['saldo_bersih']) : 0 }}
                            @endif
                        </td>
                        @php
                            if (strpos($akun['nama'], 'Akum') !== false) {
                                $totalASET_TIDAK_LANCAR -= $saldoItem['saldo_bersih'];
                            } else {
                                $totalASET_TIDAK_LANCAR += $saldoItem['saldo_bersih'];
                            }
                        @endphp
                        @else
                            <td>0</td>
                        @endif
                    </tr>
                @endif
                @endforeach
                <tr>
                <th>Total Aktiva Tetap</th>
                <th>{{ formatRupiah($totalASET_TIDAK_LANCAR) }}</th>
                </tr>
                
                <tr>
                @php
                    $totalAset = ($totalKas + $totalBANK + $totalPERSEDIAAN + $totalPIUTANG) + $totalASET_TIDAK_LANCAR;
                @endphp
                <th>Total Aset</th>
                <th>{{ formatRupiah($totalAset) }}</th>
                </tr>
                
                <tr>
                <th colspan="2" style="text-align: left">Liabilitas</th>
                </tr>
                @php
                    $totalLiabilitasPendek = 0;
                @endphp
                @foreach ($akuns as $akun)
                @if($akun['jenis'] == 'Hutang')
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
                @php
                    $totalLiabilitas = $totalLiabilitasPendek;
                @endphp
                <th>Total Liabilitas</th>
                <th>{{ formatRupiah($totalLiabilitas) }}</th>
                </tr>

                <tr>
                <th colspan="2" style="text-align: left">Aset Neto</th>
                </tr>
                @php
                $totalAsetNetoTanpaPembatasan = 0;
                $totalPendapatanTanpaPembatasan = 0;
                $totalBebanTanpaPembatasan = 0;
                $totalAsetNetoDenganPembatasan = 0;
                $totalPendapatanDenganPembatasan = 0;
                $totalBebanDenganPembatasan = 0;

                // Cari nama akun sesuai kriteria
                $namaAkun = null;
                $namaAkun2 = null;
                foreach ($akuns as $akun) {
                    if ($akun['tipe'] == 'Aset Neto' && $akun['kelompok'] != 'DENGAN PEMBATASAN') {
                        $namaAkun = $akun;
                    } elseif ($akun['tipe'] == 'Aset Neto' && $akun['kelompok'] == 'DENGAN PEMBATASAN') {
                        $namaAkun2 = $akun;
                    }
                }

                // Looping melalui data untuk menghitung total saldo berdasarkan kriteria tertentu
                foreach ($akuns as $akun) {
                    $saldoBersih = 0;

                    // Cari saldo bersih sesuai dengan id akun di dalam data
                    foreach ($data as $saldoItem) {
                        if ($saldoItem['akun_id'] == $akun['id']) {
                            $saldoBersih = $saldoItem['saldo_bersih'];
                            break;
                        }
                    }

                    // Hitung total sesuai dengan tipe dan kelompok akun
                    if ($akun['tipe'] == 'Aset Neto' && $akun['kelompok'] != 'DENGAN PEMBATASAN') {
                        $totalAsetNetoTanpaPembatasan += $saldoBersih;
                    } elseif ($akun['tipe'] == 'Pendapatan' && $akun['kelompok'] != 'DENGAN PEMBATASAN') {
                        $totalPendapatanTanpaPembatasan += $saldoBersih;
                    } elseif ($akun['tipe'] == 'Beban' && $akun['kelompok'] != 'DENGAN PEMBATASAN') {
                        $totalBebanTanpaPembatasan += $saldoBersih;
                    } elseif ($akun['tipe'] == 'Aset Neto' && $akun['kelompok'] == 'DENGAN PEMBATASAN') {
                        $totalAsetNetoDenganPembatasan += $saldoBersih;
                    } elseif ($akun['tipe'] == 'Pendapatan' && $akun['kelompok'] == 'DENGAN PEMBATASAN') {
                        $totalPendapatanDenganPembatasan += $saldoBersih;
                    } elseif ($akun['tipe'] == 'Beban' && $akun['kelompok'] == 'DENGAN PEMBATASAN') {
                        $totalBebanDenganPembatasan += $saldoBersih;
                    }
                }

                // Hitung saldo akhir sesuai dengan rumus yang diberikan
                $saldoAkhirTanpaPembatasan = $totalPendapatanTanpaPembatasan - $totalBebanTanpaPembatasan + $totalAsetNetoTanpaPembatasan;
                $saldoAkhirDenganPembatasan = $totalPendapatanDenganPembatasan - $totalBebanDenganPembatasan + $totalAsetNetoDenganPembatasan;
                @endphp

                <tr>
                <td>{{ $namaAkun['nama'] }}</td>
                <td>{{ formatRupiah($saldoAkhirTanpaPembatasan) }}</td>
                </tr>
                @if($data_instansi['id'] == 1)
                <tr>
                <td>{{ $namaAkun2['nama'] }}</td>
                <td>{{ formatRupiah($saldoAkhirDenganPembatasan) }}</td>
                </tr>
                @endif
                <tr>
                <th>Total Aset Neto</th>
                @if($data_instansi['id'] == 1)
                <th>{{ formatRupiah(($saldoAkhirTanpaPembatasan + $saldoAkhirDenganPembatasan)) }}</th>
                @else
                <th>{{ formatRupiah($saldoAkhirTanpaPembatasan) }}</th>
                @endif
                </tr>
                <tr>
                <th>Total Liabilitas dan Aset Neto</th>
                @if($data_instansi['id'] == 1)
                <th>{{ formatRupiah(($totalLiabilitas + ($saldoAkhirTanpaPembatasan + $saldoAkhirDenganPembatasan))) }}</th>
                @else
                <th>{{ formatRupiah(($totalLiabilitas + $saldoAkhirTanpaPembatasan)) }}</th>
                @endif
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
