@extends('layout')
@section('css')
    <style>
      .floating-button {
            position: fixed;
            top: 15%;
            right: 20px;
            cursor: pointer;
            z-index: 1000;
        }
    </style>
@endsection
@section('content')
     <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Posisi Keuangan Konsolidasi</h1>
          </div>
        </div>
      </div>
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Posisi Keuangan Konsolidasi</h3>
                </div>
                
              <div class="card-body">
                <div class="row mb-1">
                  <div class="col-sm-6 col-md-4 col-lg-2">
                    <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="filterTahun" name="tahun" style="width: 100%" required>
                      <option value="">Pilih Tahun</option>
                      @foreach ($tahun as $item)
                          <option value="{{ $item }}" {{ request()->input('tahun') == $item ? 'selected' : '' }}>{{ $item }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-sm-6 col-md-4 col-lg-2">
                    <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="filterBulan" name="bulan" style="width: 100%" required>
                      <option value="">Pilih Bulan</option>
                      @foreach ($bulan as $key => $value)
                          <option value="{{ $key }}" {{ request()->input('bulan') == $key ? 'selected' : '' }}>{{ $value }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-sm-6 col-md-4 col-lg-8 d-flex justify-content-between">
                    <div>
                        <button class="btn btn-primary" type="button" onClick="filter()">Filter</button>
                        <button class="btn btn-warning ml-1" type="button" onClick="clearFilter()">Clear</button>
                    </div>
                    <div class="ml-auto">
                        <button class="btn btn-success" type="button" id="btnExcel" onclick="excel()"><i class="far fa-file-excel"></i></button>
                        <button class="btn btn-danger ml-1" type="button" id="btnPdf" onclick="pdf()"><i class="far fa-file-pdf"></i></button>
                    </div>
                  </div>
                </div>
                <table id="example1" class="table table-bordered table-striped">
                  <tbody id="tableBody">
                    <tr>
                      <th colspan="2" style="text-align: left">Kas</th>
                    </tr>
                    @php
                        $kasTunai = $saldoAkun->whereIn('jenis', ['KAS'])->sum('saldo_bersih');
                        $kasBank = $saldoAkun->whereIn('jenis', ['BANK'])->sum('saldo_bersih');
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
                    @if($akun->jenis == 'PIUTANG')
                        <tr>
                          @php
                              $nominal = $saldoAkun->where('nama_akun', 'LIKE', $akun->nama)->sum('saldo_bersih');
                              $totalPIUTANG += $nominal;
                          @endphp
                          <td>{{ $akun->nama }}</td>
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
                    @if($akun->jenis == 'PERSEDIAAN')
                        <tr>
                          @php
                              $nominal = $saldoAkun->where('nama_akun', 'LIKE', $akun->nama)->sum('saldo_bersih');
                              $totalPERSEDIAAN += $nominal;
                          @endphp
                          <td>{{ $akun->nama }}</td>
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
                      <th class="text-right">{{ formatRupiah(($totalKas + $totalPERSEDIAAN + $totalPIUTANG)) }}</th>
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
                        $nominal = $saldoAkun->where('nama_akun', 'LIKE', $akun->nama)->sum('saldo_bersih');
                    @endphp
                    @if($akun->jenis == 'Aktiva Tetap')
                        @if($akun->tipe != 'Akum. Penyusutan')
                            @php
                                $totalAkum += $nominal;
                                $totalASET_TIDAK_LANCAR += $nominal;
                            @endphp
                            <tr>
                                <td>{{ $akun->nama }}</td>
                                <td class="text-right">{{ formatRupiah($nominal) }}</td>
                            </tr>
                        @else
                            @php
                                $totalTidakAkum += $nominal;
                                $totalASET_TIDAK_LANCAR -= $nominal;
                            @endphp
                            <tr>
                                <td>{{ $akun->nama }}</td>
                                <td class="text-right">{{ formatRupiah(($nominal * -1)) }}</td>
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
                          $totalAset = ($totalKas + $totalPERSEDIAAN + $totalPIUTANG) + $totalASET_TIDAK_LANCAR;
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
                    @if($akun->jenis == 'Hutang')
                        <tr>
                          @php
                              $nominal = $saldoAkun->where('nama_akun', 'LIKE', $akun->nama)->sum('saldo_bersih');
                              $totalLiabilitasPendek += $nominal;
                          @endphp
                          <td>{{ $akun->nama }}</td>
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
                        $namaAkun = $akuns->where('tipe', 'Aset Neto')->where('kelompok', '!=', 'DENGAN PEMBATASAN')->first();
                        $namaAkun2 = $akuns->where('tipe', 'Aset Neto')->where('kelompok', '==', 'DENGAN PEMBATASAN')->first();

                        $totalAsetNetoTanpaPembatasan = $akuns->where('tipe', 'Aset Neto')->where('kelompok', '!=', 'DENGAN PEMBATASAN')->sum(function($akun) use ($saldoAkun) {
                            $saldoItem = collect($saldoAkun)->firstWhere('akun_id', $akun->id);
                            return $saldoItem ? $saldoItem['saldo_bersih'] : 0;
                        });

                        $totalPendapatanTanpaPembatasan = $akuns->where('tipe', 'Pendapatan')->where('kelompok', '!=', 'DENGAN PEMBATASAN')->sum(function($akun) use ($saldoAkun) {
                            $saldoItem = collect($saldoAkun)->firstWhere('akun_id', $akun->id);
                            return $saldoItem ? $saldoItem['saldo_bersih'] : 0;
                        });

                        $totalBebanTanpaPembatasan = $akuns->where('tipe', 'Beban')->where('kelompok', '!=', 'DENGAN PEMBATASAN')->sum(function($akun) use ($saldoAkun) {
                            $saldoItem = collect($saldoAkun)->firstWhere('akun_id', $akun->id);
                            return $saldoItem ? $saldoItem['saldo_bersih'] : 0;
                        });

                        $totalAsetNetoDenganPembatasan = $akuns->where('tipe', 'Aset Neto')->where('kelompok', 'DENGAN PEMBATASAN')->sum(function($akun) use ($saldoAkun) {
                            $saldoItem = collect($saldoAkun)->firstWhere('akun_id', $akun->id);
                            return $saldoItem ? $saldoItem['saldo_bersih'] : 0;
                        });

                        $totalPendapatanDenganPembatasan = $akuns->where('tipe', 'Pendapatan')->where('kelompok', 'DENGAN PEMBATASAN')->sum(function($akun) use ($saldoAkun) {
                            $saldoItem = collect($saldoAkun)->firstWhere('akun_id', $akun->id);
                            return $saldoItem ? $saldoItem['saldo_bersih'] : 0;
                        });

                        $totalBebanDenganPembatasan = $akuns->where('tipe', 'Beban')->where('kelompok', 'DENGAN PEMBATASAN')->sum(function($akun) use ($saldoAkun) {
                            $saldoItem = collect($saldoAkun)->firstWhere('akun_id', $akun->id);
                            return $saldoItem ? $saldoItem['saldo_bersih'] : 0;
                        });

                        $saldoAkhirTanpaPembatasan = $totalPendapatanTanpaPembatasan - $totalBebanTanpaPembatasan + $totalAsetNetoTanpaPembatasan;
                        $saldoAkhirDenganPembatasan = $totalPendapatanDenganPembatasan - $totalBebanDenganPembatasan + $totalAsetNetoDenganPembatasan;
                    @endphp
                    <tr>
                      <td>{{ $namaAkun->nama }}</td>
                      <td class="text-right">{{ formatRupiah($saldoAkhirTanpaPembatasan) }}</td>
                    </tr>
                    <tr>
                      <td>{{ $namaAkun2->nama }}</td>
                      <td class="text-right">{{ formatRupiah($saldoAkhirDenganPembatasan) }}</td>
                    </tr>
                    <tr>
                      <th>Total Aset Neto</th>
                      <th class="text-right">{{ formatRupiah(($saldoAkhirTanpaPembatasan + $saldoAkhirDenganPembatasan)) }}</th>
                    </tr>
                    <tr>
                      <th>Total Liabilitas dan Aset Neto</th>
                      <th class="text-right">{{ formatRupiah(($totalLiabilitas + ($saldoAkhirTanpaPembatasan + $saldoAkhirDenganPembatasan))) }}</th>
                    </tr>
                  </tbody>
                </table>
              </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
@section('js')
    <script>
      var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      $(document).ready(function() {
      });
        $(function () {
            $("#example1").DataTable({
                "responsive": true, 
                "lengthChange": true, 
                "autoWidth": false,
                "buttons": ["excel", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });

      function filter() {
          let filterTahun = $('#filterTahun').val();
          let filterBulan = $('#filterBulan').val();

          if (!filterTahun || !filterBulan) {
                toastr.error('Semua filter harus diisi', {
                    closeButton: true,
                    tapToDismiss: false,
                    rtl: false,
                    progressBar: true
                });
                return;
            }

          let url = "{{ route('posisi_konsolidasi.index', ['instansi' => $instansi]) }}";
          let queryString = '?tahun=' + filterTahun + '&bulan=' + filterBulan;
          window.location.href = url + queryString;
      }

      function clearFilter() {
        window.location.href = "{{ route('posisi_konsolidasi.index', ['instansi' => $instansi]) }}";
      }

      function excel() {
        let filterTahun = $('#filterTahun').val();
        let filterBulan = $('#filterBulan').val();
        
        if (!filterTahun || !filterBulan) {
            toastr.error('Semua filter harus diisi', {
                closeButton: true,
                tapToDismiss: false,
                rtl: false,
                progressBar: true
            });
            return;
        }

        let url = "{{ route('posisi_konsolidasi.excel', ['instansi' => $instansi]) }}";
        let queryString = '?tahun=' + filterTahun + '&bulan=' + filterBulan;
        window.location.href = url + queryString;
      }

      function pdf() {
        let filterTahun = $('#filterTahun').val();
        let filterBulan = $('#filterBulan').val();
        
        if (!filterTahun || !filterBulan) {
            toastr.error('Semua filter harus diisi', {
                closeButton: true,
                tapToDismiss: false,
                rtl: false,
                progressBar: true
            });
            return;
        }

        let url = "{{ route('posisi_konsolidasi.pdf', ['instansi' => $instansi]) }}";
        let queryString = '?tahun=' + filterTahun + '&bulan=' + filterBulan;
        window.open(url + queryString, '_blank');
      }
    </script>
@endsection