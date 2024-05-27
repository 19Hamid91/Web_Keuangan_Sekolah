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
            <h1 class="m-0">Kartu Penyusutan</h1>
          </div>
          {{-- <div class="col-sm-6">
            <a href="{{ route('kartu-penyusutan.create', ['instansi' => $instansi]) }}" class="btn btn-primary float-sm-right">Tambah</a>
          </div> --}}
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
                  <h3 class="card-title">Kartu Penyusutan {{ 'test' }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table>
                    <tr>
                      <td>Nama Barang</td>
                      <td> : </td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>Nomor Barang</td>
                      <td> : </td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>Tanggal Operasi</td>
                      <td> : </td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>Masa Penggunaan</td>
                      <td> : </td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>Residu</td>
                      <td> : </td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>Metode</td>
                      <td> : </td>
                      <td></td>
                    </tr>
                  </table>
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="5%">Periode</th>
                        <th>Beban Penyusutan Tahun Berjalan</th>
                        <th>Akumulasi Penyusutan</th>
                        <th>Nilai Buku</th>
                      </tr>
                    </thead>
                    <tbody id="body_data">
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
        $(function () {
            $("#example1").DataTable({
                "responsive": true, 
                "lengthChange": false, 
                "autoWidth": false,
                "searching" : false,
                "ordering" : false,
                // "buttons": ["excel", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });

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
                fetch(`kartu-penyusutan/${id}/delete`, {
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