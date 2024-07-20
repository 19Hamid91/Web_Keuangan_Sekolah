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
            <h1 class="m-0">Arus Kas</h1>
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
                  <h3 class="card-title">Arus Kas</h3>
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
                              $piutangSewaKantin = collect($saldoAkun)->firstWhere('nama_akun', 'Piutang Sewa Kantin');
                          @endphp
                          
                          @if($saldoItem && $akun->nama == 'Pendapatan Sewa Kantin')
                          <td>
                              {{ $saldoItem['saldo_bersih'] ? formatRupiah(($saldoItem['saldo_bersih'] - $piutangSewaKantin['saldo_bersih'])) : 0 }}
                          </td>
                          @php
                              $totalPendapatan += ($saldoItem['saldo_bersih'] - $piutangSewaKantin['saldo_bersih']);
                          @endphp
                          @elseif($saldoItem && $akun->nama != 'Pendapatan Sewa Kantin')
                          <td>
                              {{ $saldoItem['saldo_bersih'] ? formatRupiah($saldoItem['saldo_bersih']) : 0 }}
                          </td>
                          @php
                              $totalPendapatan += $saldoItem['saldo_bersih'];
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
                    @if(($akun->jenis == 'Beban' || $akun->jenis == 'BEBAN') && !in_array($akun->nama, ['Biaya Penyusutan Peralatan', 'Biaya Penyusutan Bangunan', 'Biaya Persediaan ATK', 'Biaya Penyusutan Inventaris', 'Biaya Penyusutan Kendaraan', 'Biaya Penyusutan Aktiva Tetap Lainnya']))
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
                    @php
                        $saldoItem = collect($saldoAkun)->firstWhere('nama_akun', 'Persediaan ATK');
                    @endphp
                    
                    @if($saldoItem)
                      <td>{{ $saldoItem['nama_akun'] }}</td>
                      <td>
                          {{ $saldoItem['total_debit'] ? formatRupiah($saldoItem['total_debit']) : 0 }}
                      </td>
                      @php
                          $totalBeban += $saldoItem['total_debit'];
                      @endphp
                    @else
                        <td>-</td>
                        <td>0</td>
                    @endif
                    <tr>
                      <th>Total Biaya</th>
                      <th>{{ formatRupiah($totalBeban) }}</th>
                    </tr>
                    <tr>
                      <th>Arus Kas Bersih dari Aktivitas Operasi</th>
                      <th>{{ formatRupiah(($totalPendapatan - $totalBeban)) }}</th>
                    </tr>
                    <tr>
                      <td colspan="2">&nbsp;</td>
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
                                  {{ $saldoItem['total_debit'] ? formatRupiah($saldoItem['total_debit']) : 0 }}
                              </td>
                              @php
                                  $totalPengeluaranInvestasi += $saldoItem['total_debit'];
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
                      <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                      <th>AKTIVITAS PENDANAAN</th>
                      <th></th>
                    </tr>

                    <tr>
                      <th colspan="2" style="text-align: left">Penerimaan Kas dari Aktivitas Pendanaan</th>
                    </tr>
                    @php
                        $totalPenerimaanPendanaan = 0;
                    @endphp
                    @foreach ($akuns as $akun)
                    @if($akun->nama == 'Hutang Bank')
                        <tr>
                          <td>{{ $akun->nama }}</td>
                          @php
                              $saldoItem = collect($saldoAkun)->firstWhere('akun_id', $akun->id);
                          @endphp
                          
                          @if($saldoItem)
                              <td>
                                  {{ $saldoItem['total_kredit'] ? formatRupiah($saldoItem['total_kredit']) : 0 }}
                              </td>
                              @php
                                  $totalPenerimaanPendanaan += $saldoItem['total_kredit'];
                              @endphp
                            @else
                                <td>0</td>
                            @endif
                        </tr>
                    @endif
                    @endforeach
                    <tr>
                      <th colspan="2" style="text-align: left">Pengeluaran Kas dari Aktivitas Pendanaan</th>
                    </tr>
                    @php
                        $totalPengeluaranPendanaan = 0;
                    @endphp
                    @foreach ($akuns as $akun)
                    @if(($akun->jenis == 'Hutang' && $instansi == 'yayasan') || ($akun->nama == 'Hutang Bank' && $instansi != 'yayasan'))
                        <tr>
                          <td>{{ $akun->nama }}</td>
                          @php
                              $saldoItem = collect($saldoAkun)->firstWhere('akun_id', $akun->id);
                          @endphp
                          
                          @if($saldoItem)
                              <td>
                                  {{ $saldoItem['total_debit'] ? formatRupiah($saldoItem['total_debit']) : 0 }}
                              </td>
                              @php
                                  $totalPengeluaranPendanaan += $saldoItem['total_debit'];
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
                      <th>{{ formatRupiah(($totalPenerimaanPendanaan - $totalPengeluaranPendanaan)) }}</th>
                    </tr>
                    <tr>
                      <th>Perubahan Bersih Dalam Kas</th>
                      <th>{{ formatRupiah((($totalPendapatan - $totalBeban) + (0 - $totalPengeluaranInvestasi) + ($totalPenerimaanPendanaan - $totalPengeluaranPendanaan))) }}</th>
                    </tr>
                    <tr>
                      <th>Total Kas Awal</th>
                      <th>{{ formatRupiah($saldo) }}</th>
                    </tr>
                    <tr>
                      <th>Total Kas Akhir</th>
                      <th>{{ formatRupiah(($saldo + (($totalPendapatan - $totalBeban) + (0 - $totalPengeluaranInvestasi) + ($totalPenerimaanPendanaan - $totalPengeluaranPendanaan)))) }}</th>
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

          let url = "{{ route('arus_kas.index', ['instansi' => $instansi]) }}";
          let queryString = '?tahun=' + filterTahun + '&bulan=' + filterBulan;
          window.location.href = url + queryString;
      }

      function clearFilter() {
        window.location.href = "{{ route('arus_kas.index', ['instansi' => $instansi]) }}";
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

        let url = "{{ route('arus_kas.excel', ['instansi' => $instansi]) }}";
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

        let url = "{{ route('arus_kas.pdf', ['instansi' => $instansi]) }}";
        let queryString = '?tahun=' + filterTahun + '&bulan=' + filterBulan;
        window.open(url + queryString, '_blank');
      }
    </script>
@endsection