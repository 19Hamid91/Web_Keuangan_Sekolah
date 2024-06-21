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
            <h1 class="m-0">Pengeluaran Lainnya</h1>
          </div>
          <div class="col-sm-6">
            <a href="{{ route('pengeluaran_lainnya.create', ['instansi' => $instansi]) }}" class="btn btn-primary float-sm-right">Tambah</a>
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
                  <h3 class="card-title">Daftar Pengeluaran Lainnya</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="row mb-1">
                    <div class="col-sm-6 col-md-3 col-lg-2">
                      <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="filterJenis" style="width: 100%" required>
                        <option value="Perbaikan Aset">Perbaikan Aset Tetap</option>
                        @if ($instansi == 'tk-kb-tpa')
                        <option value="Outbond">Outbond</option>
                        @endif
                        <option value="Operasional">Operasional</option>
                        <option value="Lainnya">Lainnya</option>
                      </select>
                    </div>
                  </div>
                  <table id="perbaikanTable" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="5%">No</th>
                        <th class="perbaikan-head">Teknisi</th>
                        <th class="perbaikan-head">Aset Tetap</th>
                        <th class="perbaikan-head">Tanggal Perbaikan</th>
                        <th class="perbaikan-head">Jenis Perbaikan</th>
                        <th class="perbaikan-head">Harga Perbaikan</th>
                        <th width="15%">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                  </table>
                  <table id="outbondTable" class="table table-bordered table-striped d-none">
                    <thead>
                      <tr>
                        <th width="5%">No</th>
                        <th class="outbond-head">Biro</th>
                        <th class="outbond-head">Tanggal Pembayaran</th>
                        <th class="outbond-head">Harga</th>
                        <th class="outbond-head">Tanggal Outbond</th>
                        <th class="outbond-head">Tempat Outbond</th>
                        <th width="15%">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                  </table>
                  <table id="operasionalTable" class="table table-bordered table-striped d-none">
                    <thead>
                      <tr>
                        <th width="5%">No</th>
                        <th class="operasional-head">Karyawan</th>
                        <th class="operasional-head">Jenis Tagihan</th>
                        <th class="operasional-head">Tanggal Pembayaran</th>
                        <th class="operasional-head">Jumlah Tagihan</th>
                        <th class="operasional-head">Keterangan</th>
                        <th width="15%">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                  </table>
                  <table id="lainnyaTable" class="table table-bordered table-striped d-none">
                    <thead>
                      <tr>
                        <th width="5%">No</th>
                        <th class="lainnya-head">Nama</th>
                        <th class="lainnya-head">Tanggal</th>
                        <th class="lainnya-head">Nominal</th>
                        <th class="lainnya-head">Keterangan</th>
                        <th width="15%">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
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
         $(document).ready(function() {
            var table = null;

            function initializeTable(filterJenis) {
                if (table !== null) {
                    table.destroy(); 
                }

                if(filterJenis == 'Perbaikan Aset'){
                  table = $("#perbaikanTable").DataTable({
                    "responsive": true,
                    "lengthChange": true,
                  "autoWidth": false,
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": "{{ route('pengeluaran_lainnya.getData', ['instansi' => $instansi]) }}",
                        "data": function(d) {
                            d.filterJenis = filterJenis;
                        }
                    },
                    "columns": [
                      { "data": null, "title": "No" },
                      { "data": "teknisi_id", "title": "Teknisi" },
                      { "data": "aset_id", "title": "Aset" },
                      { "data": "tanggal", "title": "Tanggal" },
                      { "data": "jenis", "title": "Jenis" },
                      { "data": "harga", "title": "Harga" },
                      {
                        "data": null,
                        "title": "Aksi",
                        "render": function(data, type, row) {
                          return `
                              <td class="text-center">
                                  <a href="/{{ $instansi }}/pengeluaran_lainnya/Perbaikan Aset/edit/${data.id}" class="btn bg-warning pt-1 pb-1 pl-2 pr-2 rounded">
                                      <i class="fas fa-edit"></i>
                                  </a>
                                  <a href="/{{ $instansi }}/pengeluaran_lainnya/Perbaikan Aset/show/${data.id}" class="btn bg-secondary pt-1 pb-1 pl-2 pr-2 rounded">
                                      <i class="fas fa-eye"></i>
                                  </a>
                                  <a onclick="remove('Perbaikan Aset',${data.id})" class="btn bg-danger pt-1 pb-1 pl-2 pr-2 rounded">
                                      <i class="fas fa-times fa-lg"></i>
                                  </a>
                              </td>
                          `;
                        }
                      }
                    ],
                    "order": [],
                    "drawCallback": function(settings) {
                        var api = this.api();
                        var startIndex = api.context[0]._iDisplayStart;

                        api.column(0, {order: 'applied'}).nodes().each(function(cell, i) {
                            cell.innerHTML = startIndex + i + 1;
                        });
                    }
                  });
                } else if (filterJenis == 'Outbond'){
                  table = $("#outbondTable").DataTable({
                    "responsive": true,
                    "lengthChange": true,
                    "autoWidth": false,
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": "{{ route('pengeluaran_lainnya.getData', ['instansi' => $instansi]) }}",
                        "data": function(d) {
                            d.filterJenis = filterJenis;
                        }
                    },
                    "columns": [
                        { "data": null, "title": "No" },
                        { "data": "biro_id", "title": "Biro" },
                        { "data": "tanggal_pembayaran", "title": "Tanggal Pembayaran" },
                        { "data": "harga_outbond", "title": "Harga Outbond" },
                        { "data": "tanggal_outbond", "title": "Tanggal Outbond" },
                        { "data": "tempat_outbond", "title": "Tempat Outbond" },
                        {
                        "data": null,
                        "title": "Aksi",
                        "render": function(data, type, row) {
                          return `
                              <td class="text-center">
                                  <a href="/{{ $instansi }}/pengeluaran_lainnya/Outbond/edit/${data.id}" class="btn bg-warning pt-1 pb-1 pl-2 pr-2 rounded">
                                      <i class="fas fa-edit"></i>
                                  </a>
                                  <a href="/{{ $instansi }}/pengeluaran_lainnya/Outbond/show/${data.id}" class="btn bg-secondary pt-1 pb-1 pl-2 pr-2 rounded">
                                      <i class="fas fa-eye"></i>
                                  </a>
                                  <a onclick="remove('Outbond',${data.id})" class="btn bg-danger pt-1 pb-1 pl-2 pr-2 rounded">
                                      <i class="fas fa-times fa-lg"></i>
                                  </a>
                              </td>
                            `;
                          }
                        }
                    ],
                    "order": [],
                    "drawCallback": function(settings) {
                        var api = this.api();
                        var startIndex = api.context[0]._iDisplayStart;

                        api.column(0, {order: 'applied'}).nodes().each(function(cell, i) {
                            cell.innerHTML = startIndex + i + 1;
                        });
                    }
                  });
                } else if (filterJenis == 'Operasional'){
                  table = $("#operasionalTable").DataTable({
                    "responsive": true,
                    "lengthChange": true,
                    "autoWidth": false,
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": "{{ route('pengeluaran_lainnya.getData', ['instansi' => $instansi]) }}",
                        "data": function(d) {
                            d.filterJenis = filterJenis;
                        }
                    },
                    "columns": [
                        { "data": null, "title": "No" },
                        { "data": "karyawan_id", "title": "Karyawan" },
                        { "data": "jenis", "title": "Jenis" },
                        { "data": "tanggal_pembayaran", "title": "Tanggal Pembayaran" },
                        { "data": "jumlah_tagihan", "title": "Jumlah Tagihan" },
                        { "data": "keterangan", "title": "Keterangan" },
                        {
                        "data": null,
                        "title": "Aksi",
                        "render": function(data, type, row) {
                          return `
                              <td class="text-center">
                                  <a href="/{{ $instansi }}/pengeluaran_lainnya/Operasional/edit/${data.id}" class="btn bg-warning pt-1 pb-1 pl-2 pr-2 rounded">
                                      <i class="fas fa-edit"></i>
                                  </a>
                                  <a href="/{{ $instansi }}/pengeluaran_lainnya/Operasional/show/${data.id}" class="btn bg-secondary pt-1 pb-1 pl-2 pr-2 rounded">
                                      <i class="fas fa-eye"></i>
                                  </a>
                                  <a onclick="remove('Operasional',${data.id})" class="btn bg-danger pt-1 pb-1 pl-2 pr-2 rounded">
                                      <i class="fas fa-times fa-lg"></i>
                                  </a>
                              </td>
                            `;
                          }
                        }
                    ],
                    "order": [],
                    "drawCallback": function(settings) {
                        var api = this.api();
                        var startIndex = api.context[0]._iDisplayStart;

                        api.column(0, {order: 'applied'}).nodes().each(function(cell, i) {
                            cell.innerHTML = startIndex + i + 1;
                        });
                    }
                  });
                } else if (filterJenis == 'Lainnya'){
                  table = $("#lainnyaTable").DataTable({
                    "responsive": true,
                    "lengthChange": true,
                    "autoWidth": false,
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": "{{ route('pengeluaran_lainnya.getData', ['instansi' => $instansi]) }}",
                        "data": function(d) {
                            d.filterJenis = filterJenis;
                        }
                    },
                    "columns": [
                        { "data": null, "title": "No" },
                        { "data": "nama", "title": "Nama" },
                        { "data": "tanggal", "title": "Tanggal" },
                        { "data": "nominal", "title": "Nominal" },
                        { "data": "keterangan", "title": "Keterangan" },
                        {
                        "data": null,
                        "title": "Aksi",
                        "render": function(data, type, row) {
                          return `
                              <td class="text-center">
                                  <a href="/{{ $instansi }}/pengeluaran_lainnya/Lainnya/edit/${data.id}" class="btn bg-warning pt-1 pb-1 pl-2 pr-2 rounded">
                                      <i class="fas fa-edit"></i>
                                  </a>
                                  <a href="/{{ $instansi }}/pengeluaran_lainnya/Lainnya/show/${data.id}" class="btn bg-secondary pt-1 pb-1 pl-2 pr-2 rounded">
                                      <i class="fas fa-eye"></i>
                                  </a>
                                  <a onclick="remove('Lainnya',${data.id})" class="btn bg-danger pt-1 pb-1 pl-2 pr-2 rounded">
                                      <i class="fas fa-times fa-lg"></i>
                                  </a>
                              </td>
                            `;
                          }
                        }
                    ],
                    "order": [],
                    "drawCallback": function(settings) {
                        var api = this.api();
                        var startIndex = api.context[0]._iDisplayStart;

                        api.column(0, {order: 'applied'}).nodes().each(function(cell, i) {
                            cell.innerHTML = startIndex + i + 1;
                        });
                    }
                  });
                }
                
                table.buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            }

            const dataTableSearchInput = $('#perbaikanTable_filter input');

            dataTableSearchInput.off('input').on('input', debounce(function() {
                table.search(this.value).draw();
            }, 1000));
            initializeTable('Perbaikan Aset');
            
            $(document).on('change', '#filterJenis', function() {
                var filterJenis = $(this).val() ?? 'Perbaikan Aset';
                switchTable(filterJenis)
                initializeTable(filterJenis);
            });
        });

        function switchTable(jenis){
          if (jenis == 'Perbaikan Aset') {
              $('#perbaikanTable').removeClass('d-none');
              $('#outbondTable').addClass('d-none');
              $('#operasionalTable').addClass('d-none');
              $('#lainnyaTable').addClass('d-none');
          } else if (jenis == 'Outbond') {
              $('#perbaikanTable').addClass('d-none');
              $('#outbondTable').removeClass('d-none');
              $('#operasionalTable').addClass('d-none');
              $('#lainnyaTable').addClass('d-none');
          } else if (jenis == 'Operasional') {
              $('#perbaikanTable').addClass('d-none');
              $('#outbondTable').addClass('d-none');
              $('#operasionalTable').removeClass('d-none');
              $('#lainnyaTable').addClass('d-none');
          } else if (jenis == 'Lainnya') {
              $('#perbaikanTable').addClass('d-none');
              $('#outbondTable').addClass('d-none');
              $('#operasionalTable').addClass('d-none');
              $('#lainnyaTable').removeClass('d-none');
          }
        }

        function debounce(func, wait) {
            let timeout;
            return function(...args) {
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(this, args), wait);
            };
        }

        function remove(jenis, id){
          var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
          Swal.fire({
            title: 'Apakah Anda yakin ingin menghapus data ini?',
            text: "Tindakan ini tidak dapat dibatalkan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`pengeluaran_lainnya/${jenis}/delete/${id}`, {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                      toastr.error(response.json(), {
                        closeButton: true,
                        tapToDismiss: false,
                        rtl: false,
                        progressBar: true
                      });
                    }
                })
                .then(data => {
                  toastr.success('Data berhasil dihapus', {
                    closeButton: true,
                    tapToDismiss: false,
                    rtl: false,
                    progressBar: true
                  });
                  setTimeout(() => {
                    location.reload();
                  }, 2000);
                })
                .catch(error => {
                  toastr.error('Gagal menghapus data', {
                    closeButton: true,
                    tapToDismiss: false,
                    rtl: false,
                    progressBar: true
                  });
                });
            }
        })
        }
    </script>
@endsection