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
            <button class="btn btn-primary float-sm-right" data-target="#modal-user-create" data-toggle="modal">Tambah</button>
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
                  <h3 class="card-title">User</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="5%">No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>NIP</th>
                        <th>Role</th>
                        <th width="15%">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($user as $item)
                          <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->nip }}</td>
                            <td>{{ $item->role }}</td>
                            <td class="text-center">
                              <button onclick="edit('{{ $item->id }}', '{{ $item->name }}', '{{ $item->email }}', '{{ $item->nip }}', '{{ $item->role }}', '{{ $item->password }}')" class="bg-warning pt-1 pb-1 pl-2 pr-2 rounded">
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
    <div class="modal fade" id="modal-user-create">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Tambah Data User</h4>
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
            <form action="{{ route('user.store') }}" method="post">
              @csrf
              <div class="form-group">
                <label for="name">Nama</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Nama User" value="{{ old('name') }}" required>
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Email User" value="{{ old('email') }}" required>
              </div>
              <div class="form-group">
                <label for="nip">NIP</label>
                <input type="text" class="form-control" id="nip" name="nip" placeholder="NIP" value="{{ old('nip') }}" required>
              </div>
              <div class="form-group">
                  <label>Role</label>
                  <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" id="role" name="role" required>
                    <option value="">Pilih Role</option>
                    <option value="KEPALA SEKOLAH" {{ old('role') == 'KEPALA SEKOLAH' ? 'selected' : '' }}>Kepala Sekolah</option>
                    <option value="BENDAHARA SEKOLAH" {{ old('role') == 'BENDAHARA SEKOLAH' ? 'selected' : '' }}>Bendahara Sekolah</option>
                    <option value="KEPALA YAYASAN" {{ old('role') == 'KEPALA YAYASAN' ? 'selected' : '' }}>Kepala Yayasan</option>
                    <option value="BENDAHARA YAYASAN" {{ old('role') == 'BENDAHARA YAYASAN' ? 'selected' : '' }}>Bendahara Yayasan</option>
                    <option value="TU" {{ old('role') == 'TU' ? 'selected' : '' }}>Tenaga Usaha</option>
                    <option value="SARANA PRASARANA" {{ old('role') == 'SARANA PRASARANA' ? 'selected' : '' }}>Sarana Prasarana</option>
                  </select>
              </div>
              <div class="form-group">
                <label for="password">password</label>
                <input type="text" class="form-control" id="password" name="password" placeholder="password" required>
              </div>
              <span id="passNotMatched" style="display: none" class="text-danger">Password tidak sesuai</span>
              <div class="form-group">
                <label for="repassword">repassword</label>
                <input type="text" class="form-control" id="repassword" name="repassword" placeholder="repassword" required>
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
              <button id="submitBtn" type="submit" class="btn btn-primary" disabled>
                Save
              </button>
            </div>
          </form>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <div class="modal fade" id="modal-user-edit">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Edit Data user</h4>
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
                <label for="name">Nama</label>
                <input type="text" class="form-control" id="edit_name" name="name" placeholder="Nama User" value="{{ old('name') }}" required>
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input type="text" class="form-control" id="edit_email" name="email" placeholder="Email User" value="{{ old('email') }}" required>
              </div>
              <div class="form-group">
                <label for="nip">NIP</label>
                <input type="text" class="form-control" id="edit_nip" name="nip" placeholder="NIP" value="{{ old('nip') }}" required>
              </div>
              <div class="form-group">
                  <label>Role</label>
                  <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" id="edit_role" name="role" required>
                    <option value="">Pilih Role</option>
                    <option value="KEPALA SEKOLAH">Kepala Sekolah</option>
                    <option value="BENDAHARA SEKOLAH">Bendahara Sekolah</option>
                    <option value="KEPALA YAYASAN">Kepala Yayasan</option>
                    <option value="BENDAHARA YAYASAN">Bendahara Yayasan</option>
                    <option value="TU">Tenaga Usaha</option>
                    <option value="SARANA PRASARANA">Sarana Prasarana</option>
                  </select>
              </div>
              <input type="hidden" id="edit_password" name="password">
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

        function edit(id, name, email, nip, role, password){
          $('#edit-form').attr('action', 'user/'+id+'/update')
          $('#edit_name').val(name)
          $('#edit_email').val(email)
          $('#edit_nip').val(nip)
          $('#edit_role').val(role).trigger('change')
          $('#edit_password').val(password)
          $('#modal-user-edit').modal('show')
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
                fetch(`/user/${id}/delete`, {
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
        $('#repassword, #password').on('input', function(){
          var repassword = $('#repassword').val();
          var password = $('#password').val();

          if(repassword === password && password){
              $('#submitBtn').attr('disabled', false);
              $('#passNotMatched').css('display', 'none')
          } else {
              $('#submitBtn').attr('disabled', true);
              if(repassword){
                  $('#passNotMatched').css('display', 'block')
              } else {
                  $('#passNotMatched').css('display', 'none')
              }
          }
        })
    </script>
@endsection