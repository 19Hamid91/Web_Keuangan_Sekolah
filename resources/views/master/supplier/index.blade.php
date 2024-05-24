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
            <h1 class="m-0">Master Data</h1>
          </div>
          <div class="col-sm-6">
            <button class="btn btn-primary float-sm-right" data-target="#modal-supplier-create" data-toggle="modal">Tambah</button>
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
                  <h3 class="card-title">Supplier</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="5%">No</th>
                        <th>Jenis</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Telpon</th>
                        <th width="15%">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($supplier as $item)
                          <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->jenis_supplier ?? '-' }}</td>
                            <td>{{ $item->nama_supplier ?? '-' }}</td>
                            <td>{{ $item->alamat_supplier ?? '-' }}</td>
                            <td>{{ $item->notelp_supplier ?? '-' }}</td>
                            <td class="text-center">
                              <button onclick="edit('{{ $item->id ?? '-' }}', '{{ $item->jenis_supplier ?? '-' }}', '{{ $item->nama_supplier ?? '-' }}', '{{ $item->alamat_supplier ?? '-' }}', '{{ $item->notelp_supplier ?? '-' }}')" class="bg-warning pt-1 pb-1 pl-2 pr-2 rounded">
                                  <i class="fas fa-edit"></i>
                              </button>
                              <button onclick="remove({{ $item->id }})" class="bg-danger pt-1 pb-1 pl-2 pr-2 rounded">
                                  <i class="fas fa-times fa-lg"></i>
                              </button>
                          </td>
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

    {{-- Modal Start --}}
    <div class="modal fade" id="modal-supplier-create">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Tambah Data Supplier</h4>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="{{ route('supplier.store', ['instansi' => $instansi]) }}" method="post">
              @csrf
              <div class="form-group">
                <label for="jenis_supplier">Jenis supplier</label>
                <input type="text" class="form-control" id="jenis_supplier" name="jenis_supplier" placeholder="Jenis supplier" value="{{ old('jenis_supplier') }}" required>
              </div>
              <div class="form-group">
                <label for="nama_supplier">Nama Supplier</label>
                <input type="text" class="form-control" id="nama_supplier" name="nama_supplier" placeholder="Nama Supplier" value="{{ old('nama_supplier') }}" required>
              </div>
              <div class="form-group">
                <label for="alamat_supplier">Alamat</label>
                <textarea class="form-control" name="alamat_supplier" id="alamat_supplier"></textarea>
              </div>
              <div class="form-group">
                <label for="notelp_supplier">No Telpon Supplier</label>
                <input type="text" class="form-control" id="notelp_supplier" name="notelp_supplier" placeholder="No Telpon Supplier" required>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button
                type="button"
                class="btn btn-default"
                data-dismiss="modal"
              >
                Close
              </button>
              <button type="submit" class="btn btn-primary">
                Save
              </button>
            </div>
          </form>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <div class="modal fade" id="modal-supplier-edit">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Edit Data supplier</h4>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="edit-form" action="" method="post">
              @csrf
              @method('patch')
              <div class="form-group">
                <label for="jenis_supplier">Jenis Supplier</label>
                <input type="text" class="form-control" id="edit_jenis_supplier" name="jenis_supplier" placeholder="Jenis Supplier" required>
              </div>
              <div class="form-group">
                <label for="nama_supplier">Nama supplier</label>
                <input type="text" class="form-control" id="edit_nama_supplier" name="nama_supplier" placeholder="Nama supplier" required>
              </div>
              <div class="form-group">
                <label for="alamat_supplier">Alamat</label>
                <textarea class="form-control" name="alamat_supplier" id="edit_alamat_supplier"></textarea>
              </div>
              <div class="form-group">
                <label for="notelp_supplier">No Telpon Supplier</label>
                <input type="text" class="form-control" id="edit_notelp_supplier" name="notelp_supplier" placeholder="No Telpon Supplier" required>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button
                type="button"
                class="btn btn-default"
                data-dismiss="modal"
              >
                Close
              </button>
              <button type="submit" class="btn btn-warning">
                Update
              </button>
            </div>
          </form>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    {{-- Modal End --}}
  </div>
  <!-- /.content-wrapper -->
@endsection
@section('js')
    <script>
        $(function () {
            $("#example1").DataTable({
                "responsive": true, 
                "lengthChange": true, 
                "autoWidth": false,
                "buttons": ["excel", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });

        function edit(id, jenis_supplier, nama_supplier, alamat_supplier, notelp_supplier){
          $('#edit-form').attr('action', 'supplier/'+id+'/update')
          $('#edit_jenis_supplier').val(jenis_supplier)
          $('#edit_nama_supplier').val(nama_supplier)
          $('#edit_alamat_supplier').val(alamat_supplier)
          $('#edit_notelp_supplier').val(notelp_supplier)
          $('#modal-supplier-edit').modal('show')
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
                fetch(`supplier/${id}/delete`, {
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