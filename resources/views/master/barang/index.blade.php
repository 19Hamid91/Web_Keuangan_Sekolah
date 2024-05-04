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
            <button class="btn btn-primary float-sm-right" data-target="#modal-barang-create" data-toggle="modal">Tambah</button>
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
                  <h3 class="card-title">Barang</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="5%">No</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Jenis</th>
                        <th width="15%">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($barang as $item)
                          <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->kode ?? '-' }}</td>
                            <td>{{ $item->nama_barang ?? '-' }}</td>
                            <td>{{ $item->jenis ?? '-' }}</td>
                            <td class="text-center">
                              <button onclick="edit('{{ $item->id ?? '-' }}', '{{ $item->kode ?? '-' }}', '{{ $item->nama_barang ?? '-' }}', '{{ $item->jenis ?? '-' }}')" class="bg-warning pt-1 pb-1 pl-2 pr-2 rounded">
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
    <div class="modal fade" id="modal-barang-create">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Tambah Data Barang</h4>
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
            <form action="{{ route('barang.store') }}" method="post">
              @csrf
              <div class="form-group">
                <label for="kode">Kode Barang</label>
                <input type="text" class="form-control" id="kode" name="kode" placeholder="Kode Barang" value="{{ old('kode') }}" required>
              </div>
              <div class="form-group">
                <label for="nama_barang">Nama Barang</label>
                <input type="text" class="form-control" id="nama_barang" name="nama_barang" placeholder="Nama Barang" value="{{ old('nama_barang') }}" required>
              </div>
              <div class="form-group">
                <label for="saldo_awal">Jenis</label>
                <select class="form-control select2" data-dropdown-css-class="select2-danger" style="width: 100%" id="jenis" name="jenis" required>
                      <option value="Aset">Aset</option>
                      <option value="ATK">ATK</option>
                </select>
              </div>
              <div class="form-group">
                <label for="satuan">Satuan</label>
                <input type="text" class="form-control" id="satuan" name="satuan" placeholder="Satuan" required>
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
    <div class="modal fade" id="modal-barang-edit">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Edit Data Barang</h4>
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
                <label for="kode">Kode</label>
                <input type="text" class="form-control" id="edit_kode" name="kode" placeholder="Kode Barang" required>
              </div>
              <div class="form-group">
                <label for="nama_barang">Nama Barang</label>
                <input type="text" class="form-control" id="edit_nama_barang" name="nama_barang" placeholder="Nama Barang" required>
              </div>
              <div class="form-group">
                <label for="saldo_awal">Jenis</label>
                <select class="form-control select2" data-dropdown-css-class="select2-danger" style="width: 100%" id="edit_jenis" name="jenis" required>
                  <option value="Aset">Aset</option>
                  <option value="ATK">ATK</option>
                </select>
              </div>
              <div class="form-group">
                <label for="satuan">Satuan</label>
                <input type="text" class="form-control" id="edit_satuan" name="satuan" placeholder="Satuan" required>
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

        function edit(id, kode, nama_barang, jenis){
          $('#edit-form').attr('action', 'barang/'+id+'/update')
          $('#edit_kode').val(kode)
          $('#edit_nama_barang').val(nama_barang)
          $('#edit_jenis').val(jenis)
          $('#modal-barang-edit').modal('show')
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
                fetch(`/barang/${id}/delete`, {
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