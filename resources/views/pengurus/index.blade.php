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
            <h1 class="m-0">Pengurus</h1>
          </div>
          @if((Auth::user()->instansi_id == $data_instansi->id && in_array(Auth::user()->role, ['BENDAHARA'])) || in_array(Auth::user()->role, ['ADMIN']))
          <div class="col-sm-6">
            <a href="{{ route('pengurus.create', ['instansi' => $instansi]) }}" class="btn btn-primary float-sm-right">Tambah</a>
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
                  <h3 class="card-title">Pengurus</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="row ps-2 pe-2 mb-3">
                    <div class="col-sm-2 ps-0 pe-0">
                        <select id="filterJabatan" name="filterJabatan" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" title="Jabatan">
                            <option value="">Pilih Jabatan</option>
                            @foreach ($jabatan as $item)
                                <option value="{{ $item->id }}" {{ $item->id == request()->input('jabatan') ? 'selected' : '' }}>{{ $item->jabatan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-2">
                      <a href="javascript:void(0);" id="filterBtn" data-base-url="{{ route('pengurus.index', ['instansi' => $instansi]) }}" class="btn btn-info">Filter</a>
                      <a href="javascript:void(0);" id="clearBtn" data-base-url="{{ route('pengurus.index', ['instansi' => $instansi]) }}" class="btn btn-warning">Clear</a>
                    </div>
                  </div>
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="5%">No</th>
                        <th>Nama Pengurus</th>
                        <th>No HP Pengurus</th>
                        <th>Alamat</th>
                        <th>Jabatan</th>
                        <th>Instansi</th>
                        <th>Status</th>
                        <th width="15%">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($pengurus as $item)
                          <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama_pengurus ?? '-' }}</td>
                            <td>{{ $item->no_hp_pengurus ?? '-' }}</td>
                            <td>{{ $item->alamat_pengurus ?? '-' }}</td>
                            <td>{{ $item->jabatan->jabatan ?? '-' }}</td>
                            <td>{{ $item->instansi->nama_instansi ?? '-' }}</td>
                            <td class="text-center">
                                <h5><span class="badge badge-pill {{ $item->status == 'AKTIF' ? 'badge-success' : 'badge-danger' }}">
                                {{ $item->status ?? '-' }}
                                </span></h5>
                            </td>
                            <td class="text-center">
                              <a href="{{ route('pengurus.edit', ['pengurus' => $item->id, 'instansi' => $instansi]) }}" class="btn bg-warning pt-1 pb-1 pl-2 pr-2 rounded">
                                  <i class="fas fa-edit"></i>
                              </a>
                              <a href="{{ route('pengurus.show', ['pengurus' => $item->id, 'instansi' => $instansi]) }}" class="btn bg-secondary pt-1 pb-1 pl-2 pr-2 rounded">
                                  <i class="fas fa-eye"></i>
                              </a>
                              <a onclick="remove({{ $item->id }})" class="btn bg-danger pt-1 pb-1 pl-2 pr-2 rounded">
                                  <i class="fas fa-times fa-lg"></i>
                              </a>
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
                fetch(`pengurus/${id}/delete`, {
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

          var jabatan = $('#filterJabatan').val();
          if (jabatan) {
              var filterjabatan = 'jabatan=' + jabatan;
              if (first == true) {
                  symbol = '?';
                  first = false;
              } else {
                  symbol = '&';
              }
              urlString += symbol;
              urlString += filterjabatan;
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