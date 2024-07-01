@extends('layout')
@section('css')
    
@endsection
@section('content')
     <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Kartu Stok</h1>
          </div>
          @if((Auth::user()->instansi_id == $data_instansi->id && in_array(Auth::user()->role, ['BENDAHARA', 'SARPRAS YAYASAN', 'SARPRAS SEKOLAH', 'TU'])) || in_array(Auth::user()->role, ['ADMIN']))
          <div class="col-sm-6">
            <a href="{{ route('kartu-stok.create', ['instansi' => $instansi]) }}" class="btn btn-primary float-sm-right">Tambah</a>
          </div>
          @endif
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
                  <h3 class="card-title">Kartu Stok</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="row mb-1">
                    <div class="col-sm-2">
                      <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="filterAtk" required>
                        <option value="">ATK</option>
                        @foreach ($atks as $item)
                            <option value="{{ $item->id }}" {{ old('atk_id') == $item->id ? 'selected' : '' }}>{{ $item->nama_atk }}</option>
                        @endforeach
                      </select>
                    </div>
                    {{-- <div class="col-sm-2">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="far fa-calendar-alt"></i>
                          </span>
                        </div>
                        <input type="text" class="form-control daterange" id="filterDaterange">
                      </div>
                    </div> --}}
                  </div>
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th rowspan="2" width="5%">No</th>
                        <th rowspan="2" >Atk</th>
                        <th rowspan="2" >Tanggal</th>
                        <th rowspan="2" >Pengambil/Supplier</th>
                        <th colspan="2" class="text-center">Jumlah Barang</th>
                        <th rowspan="2" >Sisa</th>
                      </tr>
                      <tr>
                        <th class="bg-success">Masuk</th>
                        <th class="bg-danger">Keluar</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($data as $item)
                          <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->atk->nama_atk ?? '-' }}</td>
                            <td>{{ $item->tanggal ? formatTanggal($item->tanggal) : '-' }}</td>
                            <td>{{ $item->pengambil ?? '-' }}</td>
                            <td class="text-success">{{ $item->masuk ?? '-' }}</td>
                            <td class="text-danger">{{ $item->keluar ?? '-' }}</td>
                            <td>{{ $item->sisa ?? '-' }}</td>
                          </tr>
                      @endforeach
                  </table>
                </div>
              </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                  <h3 class="card-title">ATK Periode Berjalan</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="row mb-1">
                    <div class="col-sm-6 col-md-4 col-lg-2">
                      <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="filterTahun" style="width: 100%">
                        <option value="">Pilih Tahun</option>
                        @foreach ($tahun as $item)
                            <option value="{{ $item }}" {{ request()->input('tahun') == $item ? 'selected' : '' }}>{{ $item }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-2">
                      <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="filterBulan" style="width: 100%">
                        <option value="">Pilih Bulan</option>
                        @foreach ($bulan as $key => $value)
                            <option value="{{ $key }}" {{ request()->input('bulan') == $key ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-8 d-flex justify-content-between">
                      <div>
                        <button class="btn btn-primary" type="button" onClick="filter()">Filter</button>
                        <button class="btn btn-warning" type="button" onClick="clearFilter()">Clear</button>
                      </div>
                      {{-- <div>
                        <button class="btn btn-success" type="button" id="btnExcel" onClick="excel()"><i class="far fa-file-excel"></i></button>
                        <button class="btn btn-danger ml-1" type="button" id="btnPdf" onclick="pdf()"><i class="far fa-file-pdf"></i></button>
                      </div> --}}
                    </div>
                  </div>
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="5%">No</th>
                        <th>Atk</th>
                        <th>Jumlah ATK Masuk</th>
                        <th>Total Harga Perolehan</th>
                        <th>Harga Rata-rata per Unit</th>
                        <th>Jumlah ATK Keluar</th>
                        <th>Jumlah Penggunaan ATK</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($result as $item)
                          <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item['atk'] ?? '-' }}</td>
                            <td>{{ $item['total_masuk'] ?? '-' }}</td>
                            <td>{{ $item['total_harga'] ? formatRupiah($item['total_harga']) : '-' }}</td>
                            <td>{{ $item['harga_per_unit'] ? formatRupiah($item['harga_per_unit']) : '-' }}</td>
                            <td>{{ $item['total_keluar'] ?? 0 }}</td>
                            <td>{{ $item['harga_per_penggunaan'] ? formatRupiah($item['harga_per_penggunaan']) : 0 }}</td>
                          </tr>
                      @endforeach
                  </table>
                </div>
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
        $(document).ready(function(){
          $('.daterange').daterangepicker();
        })
        $('#filterAtk').on('change', function(){
          let table =  $("#example1").DataTable();
          let atk = $(this).find(':selected').text();
          table.row(1).search(atk).draw();
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

          let url = "{{ route('kartu-stok.index', ['instansi' => $instansi]) }}";
          let queryString = '?tahun=' + filterTahun + '&bulan=' + filterBulan;
          window.location.href = url + queryString;
      }

      function clearFilter() {
        window.location.href = "{{ route('kartu-stok.index', ['instansi' => $instansi]) }}";
      }
    </script>
@endsection