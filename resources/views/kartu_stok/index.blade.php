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
                    <div class="col-sm-4 col-md-3 col-lg-2">
                      <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="filterAtk" style="width: 100%">
                        <option value="">ATK</option>
                        @foreach ($atks as $item)
                            <option value="{{ $item->id }}" {{ request()->input('atk') == $item->id ? 'selected' : '' }}>{{ $item->nama_atk }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-sm-4 col-md-3 col-lg-2">
                      <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="filterTahun" style="width: 100%">
                        <option value="">Tahun</option>
                        @foreach ($tahun as $item)
                            <option value="{{ $item }}" {{ request()->input('tahun') == $item ? 'selected' : '' }}>{{ $item }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-sm-4 col-md-3 col-lg-2">
                      <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="filterBulan" style="width: 100%">
                        <option value="">Bulan</option>
                        @foreach ($bulan as $key => $value)
                            <option value="{{ $key }}" {{ request()->input('bulan') == $key ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-sm-4 col-md-3 col-lg-6 d-flex justify-content-between">
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
                    <div class="col-sm-4 col-md-3 col-lg-2">
                      <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="filterAtk2" style="width: 100%">
                        <option value="">ATK</option>
                        @foreach ($atks as $item)
                            <option value="{{ $item->id }}" {{ request()->input('atk2') == $item->id ? 'selected' : '' }}>{{ $item->nama_atk }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-sm-4 col-md-3 col-lg-2">
                      <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="filterTahun2" style="width: 100%">
                        <option value="">Pilih Tahun</option>
                        @foreach ($tahun as $item)
                            <option value="{{ $item }}" {{ request()->input('tahun2') == $item ? 'selected' : '' }}>{{ $item }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-sm-4 col-md-3 col-lg-2">
                      <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="filterBulan2" style="width: 100%">
                        <option value="">Pilih Bulan</option>
                        @foreach ($bulan as $key => $value)
                            <option value="{{ $key }}" {{ request()->input('bulan2') == $key ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-6 d-flex justify-content-between">
                      <div>
                        <button class="btn btn-primary" type="button" onClick="filter()">Filter</button>
                        <button class="btn btn-warning" type="button" onClick="clearFilter()">Clear</button>
                      </div>
                      <div>
                        <button class="btn btn-success" type="button" id="btnJurnal" onClick="jurnal()">Tambah Jurnal</button>
                      </div>
                    </div>
                  </div>
                  <table id="example2" class="table table-bordered table-striped">
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
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        $(document).ready(function(){
          $('.daterange').daterangepicker();
        })
        $(function () {
            $("#example1").DataTable({
                "responsive": true, 
                "lengthChange": true, 
                "autoWidth": false,
                "buttons": ["excel", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $("#example2").DataTable({
                "responsive": true, 
                "lengthChange": true, 
                "autoWidth": false,
                "buttons": ["excel", "colvis"]
            }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
        });
        function filter() {
          let filterAtk = $('#filterAtk').val();
          let filterAtk2 = $('#filterAtk2').val();
          let filterTahun = $('#filterTahun').val();
          let filterBulan = $('#filterBulan').val();
          let filterTahun2 = $('#filterTahun2').val();
          let filterBulan2 = $('#filterBulan2').val();

          let url = "{{ route('kartu-stok.index', ['instansi' => $instansi]) }}";
          let queryString = '?tahun=' + filterTahun + '&bulan=' + filterBulan + '&atk=' + filterAtk + '&tahun2=' + filterTahun2 + '&bulan2=' + filterBulan2 + '&atk2=' + filterAtk2;
          window.location.href = url + queryString;
      }

      function clearFilter() {
        window.location.href = "{{ route('kartu-stok.index', ['instansi' => $instansi]) }}";
      }

      function jurnal() {
        let filterTahun2 = $('#filterTahun2').val();
        let filterBulan2 = $('#filterBulan2').val();
        if (!filterTahun2 || !filterBulan2) {
            toastr.error('Semua filter harus diisi', {
                closeButton: true,
                tapToDismiss: false,
                rtl: false,
                progressBar: true
            });
            return;
        }
        $.ajax({
                  url: "kartu-stok/jurnal",
                  type: 'GET',
                  data: { 
                    tahun2: filterTahun2,
                    bulan2: filterBulan2,
                   }, 
                  headers: {
                      'X-CSRF-TOKEN': csrfToken
                  },
                  success: function(response) {
                    toastr.success(response, {
                        closeButton: true,
                        tapToDismiss: false,
                        rtl: false,
                        progressBar: true
                    });
                  },
                  error: function(xhr, status, error) {
                    toastr.error(error, {
                        closeButton: true,
                        tapToDismiss: false,
                        rtl: false,
                        progressBar: true
                    });
                  }
              });
      }
    </script>
@endsection