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
                        <option value="Perbaikan Aset" selected>Perbaikan Aset</option>
                        <option value="Outbond">Outbond</option>
                        <option value="Operasioanl">Operasioanl</option>
                      </select>
                    </div>
                  </div>
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="5%">No</th>
                        <th>Instansi</th>
                        <th>Jenis Pengeluaran</th>

                        {{-- <th class="perbaikan-head">Teknisi</th>
                        <th class="perbaikan-head">Tanggal Perbaikan</th>
                        <th class="perbaikan-head">Aset</th>
                        <th class="perbaikan-head">Jenis Perbaikan</th>
                        <th class="perbaikan-head">Harga Perbaikan</th>

                        <th class="outbond-head">Biro</th>
                        <th class="outbond-head">Tanggal Pembayaran</th>
                        <th class="outbond-head">Harga</th>
                        <th class="outbond-head">Tanggal Outbond</th>
                        <th class="outbond-head">Tempat Outbond</th>

                        <th class="operasional-head">Karyawan</th>
                        <th class="operasional-head">Jenis Tagihan</th>
                        <th class="operasional-head">Tanggal Pembayaran</th>
                        <th class="operasional-head">Jumlah Tagihan</th> --}}
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
            var table = $("#example1").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "buttons": ["excel", "colvis"],
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('pengeluaran_lainnya.getData', ['instansi' => $instansi]) }}",
                    "data": function (d) {
                        d.filterJenis = $('#filterJenis').val() ?? 'Perbaikan Aset';
                    }
                },
                "columns": [
                    { "data": "name" },
                    { "data": "age" },
                    { "data": "position" },
                    { "data": "office" }
                ]
            });

            table.buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

            $(document).on('change', '#filterJenis', function() {
                table.ajax.reload();
            });
        });

        function getData(jenis){
        }

        function remove(id){
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
                fetch(`pengeluaran_lainnya/${id}/delete`, {
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