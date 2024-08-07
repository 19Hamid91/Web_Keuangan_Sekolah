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
          @if((Auth::user()->instansi_id == $data_instansi->id && in_array(Auth::user()->role, ['TU'])))
          <div class="col-sm-6">
            <button class="btn btn-primary float-sm-right" data-target="#modal-kelas-create" data-toggle="modal">Tambah</button>
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
                  <h3 class="card-title">Kelas</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="row ps-2 pe-2 mb-3">
                    <div class="col-sm-2 ps-0 pe-0">
                        <select id="filterNamaKelas" name="filterNamaKelas" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" title="jenis">
                            <option value="">Kelas</option>
                            @foreach ($namakelas as $item)
                                <option value="{{ $item }}" {{ $item == request()->input('namakelas') ? 'selected' : '' }}>{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <a href="javascript:void(0);" id="filterBtn" data-base-url="{{ route('kelas.index', ['instansi' => $instansi]) }}" class="btn btn-info">Filter</a>
                        <a href="javascript:void(0);" id="clearBtn" data-base-url="{{ route('kelas.index', ['instansi' => $instansi]) }}" class="btn btn-warning">Clear</a>
                    </div>
                  </div>
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="5%">No</th>
                        <th>Id Kelas</th>
                        <th>Tingkat</th>
                        <th>Nama Kelas</th>
                        @if((Auth::user()->instansi_id == $data_instansi->id && in_array(Auth::user()->role, ['TU'])))
                        <th width="15%">Aksi</th>
                        @endif
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($kelas as $item)
                          <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->id ?? '-' }}</td>
                            <td>{{ $item->tingkat ?? '-' }}</td>
                            <td>{{ $item->tingkat ?? '-' }}-{{ $item->kelas ?? '-' }}</td>
                            @if((Auth::user()->instansi_id == $data_instansi->id && in_array(Auth::user()->role, ['TU'])))
                            <td class="text-center">
                              <button onclick="edit('{{ $item->id ?? '-' }}', '{{ $item->kelas ?? '-' }}', '{{ $item->tingkat ?? '-' }}', '{{ $item->instansi_id ?? '-' }}')" class="bg-warning pt-1 pb-1 pl-2 pr-2 rounded">
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
            <form action="{{ route('kelas.store', ['instansi' => $instansi]) }}" method="post">
              @csrf
              <div class="form-group">
                <label for="tingkat">Tingkat</label>
                <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" id="tingkat" name="tingkat" required>
                  <option value="">Tingkat</option>
                  @if ($instansi == 'smp')
                  <option value="7">7</option>
                  <option value="8">8</option>
                  <option value="9">9</option>
                  @else
                  <option value="KB A">KB A</option>
                  <option value="KB B">KB B</option>
                  <option value="TK A">TK A</option>
                  <option value="TK B">TK B</option>
                  <option value="TPA">TPA</option>
                  @endif
              </select>
              </div>
              <div class="form-group">
                <label for="kelas">Nama Kelas</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="prefix-kelas"></span>
                  </div>
                  <input type="text" id="kelas" name="kelas" class="form-control" placeholder="Nama Kelas" required>
                </div>
              </div>
              <div class="form-group">
                  <label>Instansi</label>
                  <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" id="instansi_id" name="instansi_id" required>
                      <option value="{{ $data_instansi->id }}" {{ old('instansi_id') == $data_instansi->id ? 'selected' : '' }}>{{ $data_instansi->nama_instansi }}</option>
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
                <label for="tingkat">Tingkat</label>
                <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" id="edit_tingkat" name="tingkat" required>
                  <option value="">Tingkat</option>
                  @if ($instansi == 'smp')
                  <option value="7">7</option>
                  <option value="8">8</option>
                  <option value="9">9</option>
                  @else
                  <option value="KB A">KB A</option>
                  <option value="KB B">KB B</option>
                  <option value="TK A">TK A</option>
                  <option value="TK B">TK B</option>
                  <option value="TPA">TPA</option>
                  @endif
              </select>
              </div>
              <div class="form-group">
                <label for="kelas">Nama Kelas</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="prefix-edit_kelas"></span>
                  </div>
                  <input type="text" id="edit_kelas" name="kelas" class="form-control" placeholder="Nama Kelas" required>
                </div>
              </div>
              <div class="form-group">
                  <label>Instansi</label>
                  <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" id="edit_instansi_id" name="instansi_id">
                      <option value="{{ $data_instansi->id }}">{{ $data_instansi->nama_instansi }}</option>
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

        function edit(id, nama, tingkat, instansi_id){
          $('#edit-form').attr('action', 'kelas/'+id+'/update')
          $('#edit_kelas').val(nama)
          $('#edit_tingkat').val(tingkat).trigger('change')
          $('#edit_instansi_id').val(instansi_id).trigger('change')
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
                fetch(`kelas/${id}/delete`, {
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

        $('[id^=filterBtn]').click(function(){
            var baseUrl = $(this).data('base-url');
            var urlString = baseUrl;
            var first = true;
            var symbol = '';

            var namakelas = $('#filterNamaKelas').val();
            if (namakelas) {
                var filternamakelas = 'namakelas=' + namakelas;
                if (first == true) {
                    symbol = '?';
                    first = false;
                } else {
                    symbol = '&';
                }
                urlString += symbol;
                urlString += filternamakelas;
            }

            window.location.href = urlString;
        });
        $('[id^=clearBtn]').click(function(){
            var baseUrl = $(this).data('base-url');
            var url = window.location.href;
            if(url.indexOf('?') !== -1){
                window.location.href = baseUrl;
            }
            return 0;
        });
        $('#tingkat').on('change', function(){
          var tingkat = $(this).val();
          $('#prefix-kelas').text(tingkat + '-');
        })
        $('#edit_tingkat').on('change', function(){
          var tingkat = $(this).val();
          $('#prefix-edit_kelas').text(tingkat + '-');
        })
    </script>
@endsection