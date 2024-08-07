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
            <h1 class="m-0">Siswa</h1>
          </div>
          @if((Auth::user()->instansi_id == $data_instansi->id && in_array(Auth::user()->role, ['TU'])))
          <div class="col-sm-6">
            <a href="{{ route('siswa.create', ['instansi' => $instansi]) }}" class="btn btn-primary float-sm-right">Tambah</a>
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
                  <h3 class="card-title">Siswa</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="row ps-2 pe-2 mb-3">
                    <div class="col-sm-2 ps-0 pe-0">
                        <select id="filterKelas" name="filterKelas" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" title="Kelas">
                            <option value="">Kelas</option>
                            @foreach ($kelas as $item)
                                <option value="{{ $item->id }}" {{ $item->id == request()->input('kelas') ? 'selected' : '' }}>{{ $item->tingkat }}-{{ $item->kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-2 ps-0 pe-0">
                        <select id="filterGender" name="filterGender" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" title="gender">
                            <option value="">Gender</option>
                            <option value="laki-laki" {{ 'laki-laki' == request()->input('gender') ? 'selected' : '' }}>Laki-laki</option>
                            <option value="perempuan" {{ 'perempuan' == request()->input('gender') ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div class="col-sm-2 ps-0 pe-0">
                        <select id="filterStatus" name="filterStatus" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" title="status">
                            <option value="">Status</option>
                            <option value="AKTIF" {{ 'AKTIF' == request()->input('status') ? 'selected' : '' }}>AKTIF</option>
                            <option value="TIDAK AKTIF" {{ 'TIDAK AKTIF' == request()->input('status') ? 'selected' : '' }}>TIDAK AKTIF</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <a href="javascript:void(0);" id="filterBtn" data-base-url="{{ route('siswa.index', ['instansi' => $instansi]) }}" class="btn btn-info">Filter</a>
                        <a href="javascript:void(0);" id="clearBtn" data-base-url="{{ route('siswa.index', ['instansi' => $instansi]) }}" class="btn btn-warning">Clear</a>
                    </div>
                    <div class="col-sm-3 text-sm-left text-md-right">
                        <a href="{{ route('siswa.downloadTemplate', ['instansi' => $instansi]) }}" class="btn btn-secondary"><i class="fas fa-download"></i> Template</a>
                        <a href="javascript:void(0);" id="importBtn" class="btn btn-warning" data-toggle="modal" data-target="#importModal">
                          <i class="fas fa-upload"></i> Import</a>
                    </div>
                  </div>
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="5%">No</th>
                        <th>NIS</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        @if ($instansi !='tk-kb-tpa')
                          <th>No HP Siswa</th>
                        @endif
                        <th>Alamat</th>
                        <th>Nama Wali</th>
                        <th>No HP Wali</th>
                        <th>Status</th>
                        @if((Auth::user()->instansi_id == $data_instansi->id && in_array(Auth::user()->role, ['TU'])))
                        <th width="15%">Aksi</th>
                        @endif
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($siswa as $item)
                          <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nis ?? '-' }}</td>
                            <td>{{ $item->nama_siswa ?? '-' }}</td>
                            <td>{{ $item->kelas->tingkat ?? '-' }}-{{ $item->kelas->kelas ?? '-' }}</td>
                            @if ($instansi !='tk-kb-tpa')
                              <td>{{ $item->nohp_siswa ?? '-' }}</td>
                            @endif
                            <td>{{ $item->alamat_siswa ?? '-' }}</td>
                            <td>{{ $item->nama_wali_siswa ?? '-' }}</td>
                            <td>{{ $item->nohp_wali_siswa ?? '-' }}</td>
                            <td class="text-center">
                                <h5><span class="badge badge-pill {{ $item->status == 'AKTIF' ? 'badge-success' : 'badge-danger' }}">
                                {{ $item->status ?? '-' }}
                                </span></h5>
                            </td>
                            @if((Auth::user()->instansi_id == $data_instansi->id && in_array(Auth::user()->role, ['TU'])))
                            <td class="text-center">
                              <a href="{{ route('siswa.edit', ['siswa' => $item->id, 'instansi' => $instansi]) }}" class="btn bg-warning pt-1 pb-1 pl-2 pr-2 rounded">
                                  <i class="fas fa-edit"></i>
                              </a>
                              <a href="{{ route('siswa.show', ['siswa' => $item->id, 'instansi' => $instansi]) }}" class="btn bg-secondary pt-1 pb-1 pl-2 pr-2 rounded">
                                  <i class="fas fa-eye"></i>
                              </a>
                              <a onclick="remove({{ $item->id }})" class="btn bg-danger pt-1 pb-1 pl-2 pr-2 rounded">
                                  <i class="fas fa-times fa-lg"></i>
                              </a>
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
  </div>
  <!-- /.content-wrapper -->

  <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">Import Siswa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('siswa.import', ['instansi' => $instansi]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="importFile">Select XLSX or CSV file</label>
                        <input type="file" name="file" id="importFile" class="form-control" accept=".xlsx, .csv" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>
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
                fetch(`siswa/${id}/delete`, {
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

            var kelas = $('#filterKelas').val();
            if (kelas) {
                var filterkelas = 'kelas=' + kelas;
                if (first == true) {
                    symbol = '?';
                    first = false;
                } else {
                    symbol = '&';
                }
                urlString += symbol;
                urlString += filterkelas;
            }

            var tempatlahir = $('#filterTempatLahir').val();
            if (tempatlahir) {
                var filtertempatlahir = 'tempatlahir=' + tempatlahir;
                if (first == true) {
                    symbol = '?';
                    first = false;
                } else {
                    symbol = '&';
                }
                urlString += symbol;
                urlString += filtertempatlahir;
            }

            var gender = $('#filterGender').val();
            if (gender) {
                var filtergender = 'gender=' + gender;
                if (first == true) {
                    symbol = '?';
                    first = false;
                } else {
                    symbol = '&';
                }
                urlString += symbol;
                urlString += filtergender;
            }

            var Status = $('#filterStatus').val();
            if (Status) {
                var filterStatus = 'status=' + Status;
                if (first == true) {
                    symbol = '?';
                    first = false;
                } else {
                    symbol = '&';
                }
                urlString += symbol;
                urlString += filterStatus;
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
    </script>
@endsection