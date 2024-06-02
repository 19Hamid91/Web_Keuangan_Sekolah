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
            <button class="btn btn-primary float-sm-right" data-target="#modal-setakun-create" data-toggle="modal">Tambah</button>
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
                  <h3 class="card-title">Set Akun</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="5%">No</th>
                        <th>Akun</th>
                        <th>Grup</th>
                        <th>Jenis Akun</th>
                        <th>Saldo Normal</th>
                        <th width="15%">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($setakun as $item)
                          <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->akun->nama ?? '-' }}</td>
                            <td>{{ $item->grup ?? '-' }}</td>
                            <td>{{ $item->jenis_akun ?? '-' }}</td>
                            <td>{{ $item->saldo_normal ?? '-' }}</td>
                            <td class="text-center">
                              <button onclick="edit('{{ $item->id ?? '-' }}', '{{ $item->akun_id ?? '-' }}', '{{ $item->grup ?? '-' }}', '{{ $item->jenis_akun ?? '-' }}', '{{ $item->saldo_normal ?? '-' }}')" class="bg-warning pt-1 pb-1 pl-2 pr-2 rounded">
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
    <div class="modal fade" id="modal-setakun-create">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Tambah Data Set Akun</h4>
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
            <form action="{{ route('setakun.store', ['instansi' => $instansi]) }}" method="post">
              @csrf
              <div class="form-group">
                <label for="akun_id">Akun</label>
                <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" id="akun_id" name="akun_id" required>
                  <option value="">Pilih Akun</option>
                  @foreach ($akuns as $item)
                  <option value="{{ $item->id }}">{{ $item->nama }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="grup">Grup</label>
                <input type="text" class="form-control" id="grup" name="grup" placeholder="Grup" value="{{ old('grup') }}" required>
              </div>
              <div class="form-group">
                <label for="jenis_akun">jenis_akun</label>
                <input type="text" class="form-control" id="jenis_akun" name="jenis_akun" placeholder="Jenis Akun" value="{{ old('jenis_akun') }}" required>
              </div>
              <div class="form-group">
                <label for="saldo_normal">Saldo Normal</label>
                <input type="number" class="form-control" id="saldo_normal" name="saldo_normal" placeholder="Saldo Normal" value="{{ old('saldo_normal') }}" required>
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
    <div class="modal fade" id="modal-setakun-edit">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Edit Data setakun</h4>
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
                <label for="akun_id">Akun</label>
                <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" id="edit_akun_id" name="akun_id" required>
                  <option value="">Pilih Akun</option>
                  @foreach ($akuns as $item)
                  <option value="{{ $item->id }}">{{ $item->nama }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="grup">Grup</label>
                <input type="text" class="form-control" id="edit_grup" name="grup" placeholder="Grup" value="{{ old('grup') }}" required>
              </div>
              <div class="form-group">
                <label for="jenis_akun">jenis_akun</label>
                <input type="text" class="form-control" id="edit_jenis_akun" name="jenis_akun" placeholder="Jenis Akun" value="{{ old('jenis_akun') }}" required>
              </div>
              <div class="form-group">
                <label for="saldo_normal">Saldo Normal</label>
                <input type="number" class="form-control" id="edit_saldo_normal" name="saldo_normal" placeholder="Saldu Normal" value="{{ old('saldo_normal') }}" required>
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

        function edit(id, akun_id, grup, jenis_akun, saldo_normal){
          $('#edit-form').attr('action', 'setakun/'+id+'/update');
          $('#edit_akun_id').val(akun_id).trigger('change');
          $('#edit_grup').val(grup);
          $('#edit_jenis_akun').val(jenis_akun);
          $('#edit_saldo_normal').val(saldo_normal);
          $('#modal-setakun-edit').modal('show');
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
                fetch(`setakun/${id}/delete`, {
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