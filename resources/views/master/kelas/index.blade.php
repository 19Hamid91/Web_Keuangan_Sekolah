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
            <button class="btn btn-primary float-sm-right" data-target="#modal-kelas-create" data-toggle="modal">Tambah</button>
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
                  <h3 class="card-title">Kelas</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Kode Kelas</th>
                        <th>Nama Kelas</th>
                        <th>Kode Sekolah</th>
                        <th>Nama Sekolah</th>
                        <th>Grup kelas</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($kelas as $item)
                          <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->kode }}</td>
                            <td>{{ $item->nama_kelas }}</td>
                            <td>{{ $item->kode_sekolah }}</td>
                            <td>{{ $item->sekolah->nama_sekolah }}</td>
                            <td>{{ $item->grup_kelas }}</td>
                            <td class="text-center">
                              <button onclick="edit('{{ $item->id }}', '{{ $item->kode }}', '{{ $item->nama_kelas }}', '{{ $item->grup_kelas }}', '{{ $item->kode_sekolah }}')" class="bg-warning pt-1 pb-1 pl-2 pr-2 rounded">
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
    <div class="modal fade" id="modal-kelas-create">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Tambah Data Kelas</h4>
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
            <form action="{{ route('kelas.store') }}" method="post">
              @csrf
              <div class="form-group">
                <label for="kode">Kode Kelas</label>
                <input type="text" class="form-control" id="kode" name="kode" placeholder="Kode Kelas" required>
              </div>
              <div class="form-group">
                <label for="nama">Nama Kelas</label>
                <input type="text" class="form-control" id="nama_kelas" name="nama_kelas" placeholder="Nama Kelas" required>
              </div>
              <div class="form-group">
                <label for="grup_kelas">Grup Kelas</label>
                <input type="number" class="form-control" id="grup_kelas" name="grup_kelas" placeholder="Grup Kelas" required>
              </div>
              <div class="form-group">
                  <label>Sekolah</label>
                  <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" id="kode_sekolah" name="kode_sekolah" required>
                    <option value="">Pilih Sekolah</option>
                    @foreach ($sekolah as $item)
                        <option value="{{ $item->kode }}">{{ $item->nama_sekolah }}</option>
                    @endforeach
                  </select>
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
    <div class="modal fade" id="modal-kelas-edit">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Edit Data Kelas</h4>
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
                <label for="kode">Kode Kelas</label>
                <input type="text" class="form-control" id="edit_kode" name="kode" placeholder="Kode Kelas" required>
              </div>
              <div class="form-group">
                <label for="nama">Nama Kelas</label>
                <input type="text" class="form-control" id="edit_nama_kelas" name="nama_kelas" placeholder="Nama Kelas" required>
              </div>
              <div class="form-group">
                <label for="grup_kelas">Grup Kelas</label>
                <input type="number" class="form-control" id="edit_grup_kelas" name="grup_kelas" placeholder="Grup Kelas" required>
              </div>
              <div class="form-group">
                  <label>Sekolah</label>
                  <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" id="edit_kode_sekolah" name="kode_sekolah">
                    <option value="">Pilih Kelas</option>
                    @foreach ($sekolah as $item)
                        <option value="{{ $item->kode }}">{{ $item->nama_sekolah }}</option>
                    @endforeach
                  </select>
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

        function edit(id, kode, nama_kelas, grup_kelas, kode_sekolah){
          $('#edit-form').attr('action', 'kelas/'+id+'/update')
          $('#edit_kode').val(kode)
          $('#edit_nama_kelas').val(nama_kelas)
          $('#edit_grup_kelas').val(grup_kelas)
          $('#edit_kode_sekolah').val(kode_sekolah).trigger('change')
          $('#modal-kelas-edit').modal('show')
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
                fetch(`/kelas/${id}/delete`, {
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