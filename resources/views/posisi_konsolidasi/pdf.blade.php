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
      .text-right {
        text-align:right;
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
                    $kasTunai = array_sum(array_column(array_filter($data, fn($item) => in_array($item['jenis'], ['KAS'])), 'saldo_bersih'));
                    $kasBank = array_sum(array_column(array_filter($data, fn($item) => in_array($item['jenis'], ['BANK'])), 'saldo_bersih'));
                    $totalKas = $kasTunai + $kasBank;
                @endphp
                <tr>
                    <td>Kas Tunai</td>
                    <td class="text-right">{{ formatRupiah($kasTunai) }}</td>
                </tr>
                <tr>
                    <td>Kas pada Bank</td>
                    <td class="text-right">{{ formatRupiah($kasBank) }}</td>
                </tr>
                <tr>
                    <th>Total Kas</th>
                    <th class="text-right">{{ formatRupiah($totalKas) }}</th>
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
                            @php
                                $nominal = array_sum(array_column(array_filter($data, fn($item) => $item['nama_akun'] == $akun['nama']), 'saldo_bersih'));
                                $totalPIUTANG += $nominal;
                            @endphp
                            <td>{{ $akun['nama'] }}</td>
                            <td class="text-right">{{ formatRupiah($nominal) }}</td>
                        </tr>
                    @endif
                @endforeach
                <tr>
                    <th>Total Piutang</th>
                    <th class="text-right">{{ formatRupiah($totalPIUTANG) }}</th>
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
                            @php
                                $nominal = array_sum(array_column(array_filter($data, fn($item) => $item['nama_akun'] == $akun['nama']), 'saldo_bersih'));
                                $totalPERSEDIAAN += $nominal;
                            @endphp
                            <td>{{ $akun['nama'] }}</td>
                            <td class="text-right">{{ formatRupiah($nominal) }}</td>
                        </tr>
                    @endif
                @endforeach
                <tr>
                    <th>Total Persediaan</th>
                    <th class="text-right">{{ formatRupiah($totalPERSEDIAAN) }}</th>
                </tr>
            
                <tr>
                    <th>Total Aktiva Lancar</th>
                    <th class="text-right">{{ formatRupiah($totalKas + $totalPERSEDIAAN + $totalPIUTANG) }}</th>
                </tr>
            
                <tr>
                    <th colspan="2" style="text-align: left">Aktiva Tetap</th>
                </tr>
                @php
                    $totalAkum = 0;
                    $totalTidakAkum = 0;
                    $totalASET_TIDAK_LANCAR = 0;
                @endphp
                @foreach ($akuns as $akun)
                @php
                    $nominal = array_sum(array_column(array_filter($data, fn($item) => $item['nama_akun'] == $akun['nama']), 'saldo_bersih'));
                @endphp
                @if($akun['jenis'] == 'Aktiva Tetap')
                    @if($akun['tipe'] != 'Akum. Penyusutan')
                        @php
                            $totalAkum += $nominal;
                            $totalASET_TIDAK_LANCAR += $nominal;
                        @endphp
                        <tr>
                            <td>{{ $akun['nama'] }}</td>
                            <td class="text-right">{{ formatRupiah($nominal) }}</td>
                        </tr>
                    @else
                        @php
                            $totalTidakAkum += $nominal;
                            $totalASET_TIDAK_LANCAR -= $nominal;
                        @endphp
                        <tr>
                            <td>{{ $akun['nama'] }}</td>
                            <td class="text-right">{{ formatRupiah($nominal * -1) }}</td>
                        </tr>
                    @endif
                @endif
                @endforeach            
                <tr>
                    <th>Total Aktiva Tetap</th>
                    <th class="text-right">{{ formatRupiah($totalASET_TIDAK_LANCAR) }}</th>
                </tr>
                
                <tr>
                    @php
                        $totalAset = $totalKas + $totalPERSEDIAAN + $totalPIUTANG + $totalASET_TIDAK_LANCAR;
                    @endphp
                    <th>Total Aset</th>
                    <th class="text-right">{{ formatRupiah($totalAset) }}</th>
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
                            @php
                                $nominal = array_sum(array_column(array_filter($data, fn($item) => $item['nama_akun'] == $akun['nama']), 'saldo_bersih'));
                                $totalLiabilitasPendek += $nominal;
                            @endphp
                            <td>{{ $akun['nama'] }}</td>
                            <td class="text-right">{{ formatRupiah($nominal) }}</td>
                        </tr>
                    @endif
                @endforeach
                <tr>
                    @php
                        $totalLiabilitas = $totalLiabilitasPendek;
                    @endphp
                    <th>Total Liabilitas</th>
                    <th class="text-right">{{ formatRupiah($totalLiabilitas) }}</th>
                </tr>
            
                <tr>
                    <th colspan="2" style="text-align: left">Aset Neto</th>
                </tr>
                @php
                    $namaAkun = collect($akuns)->first(fn($akun) => $akun['tipe'] == 'Aset Neto' && $akun['kelompok'] != 'DENGAN PEMBATASAN');
                    $namaAkun2 = collect($akuns)->first(fn($akun) => $akun['tipe'] == 'Aset Neto' && $akun['kelompok'] == 'DENGAN PEMBATASAN');
            
                    $totalAsetNetoTanpaPembatasan = array_sum(array_map(function($akun) use ($data) {
                        $saldoItem = collect($data)->firstWhere('akun_id', $akun['id']);
                        return $saldoItem ? $saldoItem['saldo_bersih'] : 0;
                    }, array_filter($akuns, fn($akun) => $akun['tipe'] == 'Aset Neto' && $akun['kelompok'] != 'DENGAN PEMBATASAN')));
            
                    $totalPendapatanTanpaPembatasan = array_sum(array_map(function($akun) use ($data) {
                        $saldoItem = collect($data)->firstWhere('akun_id', $akun['id']);
                        return $saldoItem ? $saldoItem['saldo_bersih'] : 0;
                    }, array_filter($akuns, fn($akun) => $akun['tipe'] == 'Pendapatan' && $akun['kelompok'] != 'DENGAN PEMBATASAN')));
            
                    $totalBebanTanpaPembatasan = array_sum(array_map(function($akun) use ($data) {
                        $saldoItem = collect($data)->firstWhere('akun_id', $akun['id']);
                        return $saldoItem ? $saldoItem['saldo_bersih'] : 0;
                    }, array_filter($akuns, fn($akun) => $akun['tipe'] == 'Beban' && $akun['kelompok'] != 'DENGAN PEMBATASAN')));
            
                    $totalAsetNetoDenganPembatasan = array_sum(array_map(function($akun) use ($data) {
                        $saldoItem = collect($data)->firstWhere('akun_id', $akun['id']);
                        return $saldoItem ? $saldoItem['saldo_bersih'] : 0;
                    }, array_filter($akuns, fn($akun) => $akun['tipe'] == 'Aset Neto' && $akun['kelompok'] == 'DENGAN PEMBATASAN')));
            
                    $totalPendapatanDenganPembatasan = array_sum(array_map(function($akun) use ($data) {
                        $saldoItem = collect($data)->firstWhere('akun_id', $akun['id']);
                        return $saldoItem ? $saldoItem['saldo_bersih'] : 0;
                    }, array_filter($akuns, fn($akun) => $akun['tipe'] == 'Pendapatan' && $akun['kelompok'] == 'DENGAN PEMBATASAN')));
            
                    $totalBebanDenganPembatasan = array_sum(array_map(function($akun) use ($data) {
                        $saldoItem = collect($data)->firstWhere('akun_id', $akun['id']);
                        return $saldoItem ? $saldoItem['saldo_bersih'] : 0;
                    }, array_filter($akuns, fn($akun) => $akun['tipe'] == 'Beban' && $akun['kelompok'] == 'DENGAN PEMBATASAN')));
            
                    $saldoAkhirTanpaPembatasan = $totalPendapatanTanpaPembatasan - $totalBebanTanpaPembatasan + $totalAsetNetoTanpaPembatasan;
                    $saldoAkhirDenganPembatasan = $totalPendapatanDenganPembatasan - $totalBebanDenganPembatasan + $totalAsetNetoDenganPembatasan;
                @endphp
                <tr>
                    <td>{{ $namaAkun['nama'] }}</td>
                    <td class="text-right">{{ formatRupiah($saldoAkhirTanpaPembatasan) }}</td>
                </tr>
                <tr>
                    <td>{{ $namaAkun2['nama'] }}</td>
                    <td class="text-right">{{ formatRupiah($saldoAkhirDenganPembatasan) }}</td>
                </tr>
                <tr>
                    <th>Total Aset Neto</th>
                    <th class="text-right">{{ formatRupiah($saldoAkhirTanpaPembatasan + $saldoAkhirDenganPembatasan) }}</th>
                </tr>
                <tr>
                    <th>Total Liabilitas dan Aset Neto</th>
                    <th class="text-right">{{ formatRupiah($totalLiabilitas + $saldoAkhirTanpaPembatasan + $saldoAkhirDenganPembatasan) }}</th>
                </tr>
            </tbody>            
        </table>
    </div>
</body>
</html>
