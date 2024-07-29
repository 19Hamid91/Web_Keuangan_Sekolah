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
            <h1 class="m-0">Neraca Saldo</h1>
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
                  <h3 class="card-title">Neraca Saldo</h3>
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
                    @if((Auth::user()->instansi_id == $data_instansi->id && in_array(Auth::user()->role, ['BENDAHARA'])))
                    <div class="ml-auto">
                        <button class="btn btn-success" type="button" id="btnExcel" onclick="excel()"><i class="far fa-file-excel"></i></button>
                        <button class="btn btn-danger ml-1" type="button" id="btnPdf" onclick="pdf()"><i class="far fa-file-pdf"></i></button>
                    </div>
                    @endif
                  </div>
                </div>
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
                    @php
                      $totalDebit = $saldoAkun->sum('total_debit');
                      $totalKredit = $saldoAkun->sum('total_kredit');
                    @endphp
                    <div class="row mt-3">
                      <div class="col-sm-6 col-md-4 col-lg-3">
                          <div class="form-group">
                              <label>Total Debit</label>
                              <div class="input-group mb-3">
                                <input type="text" id="total_debit" name="total_debit" class="form-control text-right" placeholder="Saldo Awal" value="{{ $totalDebit ? formatRupiah($totalDebit) : 0 }}" readonly required>
                              </div>
                          </div>
                      </div>
                      <div class="col-sm-6 col-md-4 col-lg-3">
                          <div class="form-group">
                              <label>Total Kredit</label>
                              <div class="input-group mb-3">
                                <input type="text" id="total_kredit" name="total_kredit" class="form-control text-right" placeholder="Saldo Akhir" value="{{ $totalKredit ? formatRupiah($totalKredit) : 0 }}" readonly required>
                              </div>
                          </div>
                      </div>
                    </div>
                    @foreach ($saldoAkun as $item)
                      <tr>
                        <td>
                            {{ $loop->iteration }}
                        </td>
                        <td>
                            {{ $item['nama_akun'] }}
                        </td>
                        <td class="text-right">
                            {{ $item['total_debit'] ? formatRupiah($item['saldo_bersih']) : 0 }}
                        </td>
                        <td class="text-right">
                            {{ $item['total_kredit'] ? formatRupiah($item['saldo_bersih']) : 0 }}
                        </td>
                      </tr>
                    @endforeach
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

          let url = "{{ route('neraca.index', ['instansi' => $instansi]) }}";
          let queryString = '?tahun=' + filterTahun + '&bulan=' + filterBulan;
          window.location.href = url + queryString;
      }

      function clearFilter() {
        window.location.href = "{{ route('neraca.index', ['instansi' => $instansi]) }}";
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

        let url = "{{ route('neraca.excel', ['instansi' => $instansi]) }}";
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

        let url = "{{ route('neraca.pdf', ['instansi' => $instansi]) }}";
        let queryString = '?tahun=' + filterTahun + '&bulan=' + filterBulan;
        window.open(url + queryString, '_blank');
      }
    </script>
@endsection