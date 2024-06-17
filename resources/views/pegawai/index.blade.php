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
            <h1 class="m-0">Guru & Karyawan</h1>
          </div>
          <div class="col-sm-6">
            <a href="{{ route('pegawai.create', ['instansi' => $instansi]) }}" class="btn btn-primary float-sm-right">Tambah</a>
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
                  <h3 class="card-title">Guru & Karyawan</h3>
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
                    <div class="col-sm-2 ps-0 pe-0">
                        <select id="filterTempatLahir" name="filterTempatLahir" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" title="Tempat Lahir">
                            <option value="">Pilih Tempat Lahir</option>
                            @foreach ($tempatlahir as $item)
                                <option value="{{ $item }}" {{ $item == request()->input('tempatlahir') ? 'selected' : '' }}>{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-2 ps-0 pe-0">
                        <select id="filterStatus" name="filterStatus" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" title="Status">
                            <option value="">Pilih Status</option>
                            <option value="Menikah" {{ 'Menikah' == request()->input('status') ? 'selected' : '' }}>Menikah</option>
                            <option value="Belum Menikah" {{ 'Belum Menikah' == request()->input('status') ? 'selected' : '' }}>Belum Menikah</option>
                        </select>
                    </div>
                    <div class="col-sm-2 ps-0 pe-0">
                        <select id="filterGender" name="filterGender" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" title="Gender">
                            <option value="">Pilih Gender</option>
                            <option value="laki-laki" {{ 'laki-laki' == request()->input('gender') ? 'selected' : '' }}>Laki-laki</option>
                            <option value="perempuan" {{ 'perempuan' == request()->input('gender') ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div class="col-sm-2 ps-0 pe-0">
                        <select id="filterAnak" name="filterAnak" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" title="Anak">
                            <option value="">Jumlah Anak</option>
                            <option value="Punya Anak" {{ 'Punya Anak' == request()->input('anak') ? 'selected' : '' }}>Punya Anak</option>
                            <option value="Tidak Punya Anak" {{ 'Tidak Punya Anak"' == request()->input('anak') ? 'selected' : '' }}>Tidak Punya Anak</option>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <a href="javascript:void(0);" id="filterBtn" data-base-url="{{ route('pegawai.index', ['instansi' => $instansi]) }}" class="btn btn-info">Filter</a>
                        <a href="javascript:void(0);" id="clearBtn" data-base-url="{{ route('pegawai.index', ['instansi' => $instansi]) }}" class="btn btn-warning">Clear</a>
                    </div>
                  </div>
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="5%">No</th>
                        <th>Instansi</th>
                        <th>Nama</th>
                        <th>NIP</th>
                        <th>No HP</th>
                        <th>Alamat</th>
                        <th>Jabatan</th>
                        <th>Status Kawin</th>
                        <th>Jumlah Anak</th>
                        <th>Status</th>
                        <th width="15%">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($pegawai as $item)
                          <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->instansi->nama_instansi ?? '-' }}</td>
                            <td>{{ $item->nama_gurukaryawan ?? '-' }}</td>
                            <td>{{ $item->nip ?? '-' }}</td>
                            <td>{{ $item->no_hp_gurukaryawan ?? '-' }}</td>
                            <td>{{ $item->alamat_gurukaryawan ?? '-' }}</td>
                            <td>{{ $item->jabatan->jabatan ?? '-' }}</td>
                            <td>{{ $item->status_kawin ?? '-' }}</td>
                            <td>{{ $item->jumlah_anak ?? '-' }}</td>
                            <td class="text-center">
                                <h5><span class="badge badge-pill {{ $item->status == 'AKTIF' ? 'badge-success' : 'badge-danger' }}">
                                {{ $item->status ?? '-' }}
                                </span></h5>
                            </td>
                            <td class="text-center">
                              <a href="{{ route('pegawai.edit', ['pegawai' => $item->id, 'instansi' => $instansi]) }}" class="btn bg-warning pt-1 pb-1 pl-2 pr-2 rounded">
                                  <i class="fas fa-edit"></i>
                              </a>
                              <a href="{{ route('pegawai.show', ['pegawai' => $item->id, 'instansi' => $instansi]) }}" class="btn bg-secondary pt-1 pb-1 pl-2 pr-2 rounded">
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
                fetch(`pegawai/${id}/delete`, {
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

            var status = $('#filterStatus').val();
            if (status) {
                var filterstatus = 'status=' + status;
                if (first == true) {
                    symbol = '?';
                    first = false;
                } else {
                    symbol = '&';
                }
                urlString += symbol;
                urlString += filterstatus;
            }

            var anak = $('#filterAnak').val();
            if (anak) {
                var filteranak = 'anak=' + anak;
                if (first == true) {
                    symbol = '?';
                    first = false;
                } else {
                    symbol = '&';
                }
                urlString += symbol;
                urlString += filteranak;
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