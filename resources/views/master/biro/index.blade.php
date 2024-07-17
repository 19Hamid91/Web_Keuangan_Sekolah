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
          @if((Auth::user()->instansi_id == $data_instansi->id && in_array(Auth::user()->role, ['TU', 'BENDAHARA'])))
          <div class="col-sm-6">
            <button class="btn btn-primary float-sm-right" data-target="#modal-biro-create" data-toggle="modal">Tambah</button>
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
                  <h3 class="card-title">Biro</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="5%">No</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Telpon</th>
                        @if((Auth::user()->instansi_id == $data_instansi->id && in_array(Auth::user()->role, ['TU', 'BENDAHARA'])))
                        <th width="15%">Aksi</th>
                        @endif
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($biro as $item)
                          <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama ?? '-' }}</td>
                            <td>{{ $item->alamat ?? '-' }}</td>
                            <td>{{ $item->telpon ?? '-' }}</td>
                            @if((Auth::user()->instansi_id == $data_instansi->id && in_array(Auth::user()->role, ['TU', 'BENDAHARA'])))
                            <td class="text-center">
                              <button onclick="edit('{{ $item->id ?? '-' }}', '{{ $item->nama ?? '-' }}', '{{ $item->alamat ?? '-' }}', '{{ $item->telpon }}')" class="bg-warning pt-1 pb-1 pl-2 pr-2 rounded">
                                  <i class="fas fa-edit"></i>
                              </button>
                              <button onclick="remove({{ $item->id }})" class="bg-danger pt-1 pb-1 pl-2 pr-2 rounded">
                                  <i class="fas fa-times fa-lg"></i>
                              </button>
                          </td>
                          @endif
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
    <div class="modal fade" id="modal-biro-create">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Tambah Data Biro</h4>
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
            <form action="{{ route('biro.store', ['instansi' => $instansi]) }}" method="post">
              @csrf
              <div class="form-group">
                <label for="nama">Nama biro</label>
                <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Biro" value="{{ old('nama') }}" required>
              </div>
              <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea name="alamat" id="alamat" class="form-control"></textarea>
              </div>
              <div class="form-group">
                <label for="telpon">Telpon</label>
                <input type="text" class="form-control" id="telpon" name="telpon" placeholder="Telpon Biro" value="{{ old('telpon') }}" required oninput="validatePhoneNumber(this)">
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
    <div class="modal fade" id="modal-biro-edit">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Edit Data Biro</h4>
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
                <label for="nama">Nama Biro</label>
                <input type="text" class="form-control" id="edit_nama" name="nama" placeholder="Nama Biro" value="{{ old('nama') }}" required>
              </div>
              <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea name="alamat" id="edit_alamat" class="form-control"></textarea>
              </div>
              <div class="form-group">
                <label for="telpon">Telpon</label>
                <input type="text" class="form-control" id="edit_telpon" name="telpon" placeholder="Telpon Biro" value="{{ old('telpon') }}" required oninput="validatePhoneNumber(this)">
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

        function edit(id, nama, alamat, telpon){
          $('#edit-form').attr('action', 'biro/'+id+'/update')
          $('#edit_nama').val(nama)
          $('#edit_alamat').val(alamat)
          $('#edit_telpon').val(telpon)
          $('#modal-biro-edit').modal('show')
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
                fetch(`biro/${id}/delete`, {
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
        $(document).on('input', '#nama, #edit_nama', function() {
          let input = $(this);
          let value = input.val();
          
          let cleanedValue = value.replace(/[^a-zA-Z'\- ]/g, '');
          
          if (cleanedValue !== value) {
              input.val(cleanedValue);
          }
        });

        $(document).on('input', '#edit_telpon, #telpon', function() {
            let input = $(this); 
            let value = input.val();
            
            let cleanedValue = value.replace(/\D/g, '');
            
            if (cleanedValue !== value) {
                input.val(cleanedValue);
            }
        });

        function validatePhoneNumber(input) {
            if (input.value.length > 13) {
                input.value = input.value.slice(0, 13);
            }
        }
    </script>
@endsection