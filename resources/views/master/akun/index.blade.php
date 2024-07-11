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
          @if((Auth::user()->instansi_id == $data_instansi->id && in_array(Auth::user()->role, ['BENDAHARA'])) || in_array(Auth::user()->role, ['ADMIN']))
          <div class="col-sm-6">
            <button class="btn btn-primary float-sm-right" data-target="#modal-akun-create" data-toggle="modal">Tambah</button>
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
                  <h3 class="card-title">Akun</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="row ps-2 pe-2">
                    <div class="col-sm-2 ps-0 pe-0 mb-3">
                        <select id="filterTipe" name="filterTipe" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" title="tipe">
                            <option value="">Tipe</option>
                            @foreach ($tipe as $item)
                                <option value="{{ $item }}" {{ $item == request()->input('tipe') ? 'selected' : '' }}>{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-2 ps-0 pe-0">
                        <select id="filterJenis" name="filterJenis" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" title="jenis">
                            <option value="">Jenis</option>
                            @foreach ($jenis as $item)
                                <option value="{{ $item }}" {{ $item == request()->input('jenis') ? 'selected' : '' }}>{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-2 ps-0 pe-0">
                        <select id="filterKelompok" name="filterKelompok" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" title="kelompok">
                            <option value="">kelompok</option>
                            @foreach ($kelompok as $item)
                                <option value="{{ $item }}" {{ $item == request()->input('kelompok') ? 'selected' : '' }}>{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <a href="javascript:void(0);" id="filterBtn" data-base-url="{{ route('akun.index', ['instansi' => $instansi]) }}" class="btn btn-info">Filter</a>
                        <a href="javascript:void(0);" id="clearBtn" data-base-url="{{ route('akun.index', ['instansi' => $instansi]) }}" class="btn btn-warning">Clear</a>
                    </div>
                  </div>
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="5%">No</th>
                        <th>Kode</th>
                        <th>Nama Akun</th>
                        <th>Tipe</th>
                        <th>Kelompok</th>
                        <th>Posisi</th>
                        <th>Saldo Awal</th>
                        @if((Auth::user()->instansi_id == $data_instansi->id && in_array(Auth::user()->role, ['BENDAHARA'])) || in_array(Auth::user()->role, ['ADMIN']))
                        <th width="15%">Aksi</th>
                        @endif
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($akun as $item)
                          <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->kode ?? '-' }}</td>
                            <td>{{ $item->nama ?? '-' }}</td>
                            <td>{{ $item->tipe ?? '-' }}</td>
                            <td>{{ $item->kelompok ?? '-' }}</td>
                            <td>{{ $item->posisi ?? '-' }}</td>
                            <td>{{ $item->saldo_awal ? formatRupiah($item->saldo_awal) : 0 }}</td>
                            @if((Auth::user()->instansi_id == $data_instansi->id && in_array(Auth::user()->role, ['BENDAHARA'])) || in_array(Auth::user()->role, ['ADMIN']))
                            <td class="text-center">
                              <button onclick="edit('{{ $item->id ?? '-' }}', '{{ $item->kode ?? '-' }}', '{{ $item->nama ?? '-' }}', '{{ $item->tipe ?? '-' }}', '{{ $item->jenis ?? '-' }}', '{{ $item->kelompok ?? '-' }}', '{{ $item->saldo_awal ?? '-' }}')" class="bg-warning pt-1 pb-1 pl-2 pr-2 rounded">
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
    <div class="modal fade" id="modal-akun-create">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Tambah Data Akun</h4>
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
            <form id="addForm" action="{{ route('akun.store', ['instansi' => $instansi]) }}" method="post">
              @csrf
              <div class="form-group">
                <label for="kode">Kode Akun</label>
                <input type="text" class="form-control" id="kode" name="kode" placeholder="Kode Akun" value="{{ old('kode') }}" required oninput="validateKode(this)">
              </div>
              <div class="form-group">
                <label for="nama">Nama Akun</label>
                <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Akun" value="{{ old('nama') }}" required>
              </div>
              <div class="form-group">
                <label for="nama">Tipe</label>
                <input type="text" class="form-control" id="tipe" name="tipe" placeholder="Tipe" value="{{ old('tipe') }}" required>
              </div>
              <div class="form-group">
                <label for="nama">Jenis</label>
                <input type="text" class="form-control" id="jenis" name="jenis" placeholder="Jenis" value="{{ old('jenis') }}" required>
              </div>
              <div class="form-group">
                <label for="nama">Kelompok</label>
                <input type="text" class="form-control" id="kelompok" name="kelompok" placeholder="Kelompok" value="{{ old('kelompok') }}" required>
              </div>
              <div class="form-group">
                <label for="saldo_awal">Saldo Awal</label>
                <input type="text" class="form-control" id="saldo_awal" name="saldo_awal" placeholder="Saldo Awal" value="{{ old('saldo_awal') }}" required>
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
    <div class="modal fade" id="modal-akun-edit">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Edit Data Akun</h4>
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
                <input type="text" class="form-control" id="edit_kode" name="kode" placeholder="Kode Akun" required  oninput="validateKode(this)">
              </div>
              <div class="form-group">
                <label for="nama">Nama Akun</label>
                <input type="text" class="form-control" id="edit_nama" name="nama" placeholder="Nama Akun" required>
              </div>
              <div class="form-group">
                <label for="nama">Tipe</label>
                <input type="text" class="form-control" id="edit_tipe" name="tipe" placeholder="Tipe" value="{{ old('tipe') }}" required>
              </div>
              <div class="form-group">
                <label for="nama">Jenis</label>
                <input type="text" class="form-control" id="edit_jenis" name="jenis" placeholder="Jenis" value="{{ old('jenis') }}" required>
              </div>
              <div class="form-group">
                <label for="nama">Kelompok</label>
                <input type="text" class="form-control" id="edit_kelompok" name="kelompok" placeholder="Kelompok" value="{{ old('kelompok') }}" required>
              </div>
              <div class="form-group">
                <label for="saldo_awal">Saldo Awal</label>
                <input type="text" class="form-control" id="edit_saldo_awal" name="saldo_awal" placeholder="Saldo Awal" value="{{ old('saldo_awal') }}" required>
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
        $(document).on('input', '[id^=saldo_awal],[id^=edit_saldo_awal]', function() {
            let input = $(this);
            let value = input.val();
            let cursorPosition = input[0].selectionStart;
            
            if (!isNumeric(cleanNumber(value))) {
            value = value.replace(/[^\d]/g, "");
            }

            let originalLength = value.length;

            value = cleanNumber(value);
            let formattedValue = formatNumber(value);
            
            input.val(formattedValue);

            let newLength = formattedValue.length;
            let lengthDifference = newLength - originalLength;
            input[0].setSelectionRange(cursorPosition + lengthDifference, cursorPosition + lengthDifference);
        });
        $('#addForm, #edit-form').on('submit', function(e) {
            let inputs = $('#addForm, #edit-form').find('[id^=saldo_awal],[id^=edit_saldo_awal]');
            inputs.each(function() {
                let input = $(this);
                let value = input.val();
                let cleanedValue = cleanNumber(value);

                input.val(cleanedValue);
            });

            return true;
        });
        $(function () {
            $("#example1").DataTable({
                "responsive": true, 
                "lengthChange": true, 
                "autoWidth": false,
                "buttons": ["excel"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });

        function edit(id, kode, nama, tipe, jenis, kelompok, saldo_awal){
          $('#edit-form').attr('action', 'akun/'+id+'/update')
          $('#edit_kode').val(kode)
          $('#edit_nama').val(nama)
          $('#edit_tipe').val(tipe)
          $('#edit_jenis').val(jenis)
          $('#edit_kelompok').val(kelompok)
          $('#edit_saldo_awal').val(formatNumber(saldo_awal))
          $('#modal-akun-edit').modal('show')
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
                fetch(`akun/${id}/delete`, {
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

            var tipe = $('#filterTipe').val();
            if (tipe) {
                var filtertipe = 'tipe=' + tipe;
                if (first == true) {
                    symbol = '?';
                    first = false;
                } else {
                    symbol = '&';
                }
                urlString += symbol;
                urlString += filtertipe;
            }

            var jenis = $('#filterJenis').val();
            if (jenis) {
                var filterjenis = 'jenis=' + jenis;
                if (first == true) {
                    symbol = '?';
                    first = false;
                } else {
                    symbol = '&';
                }
                urlString += symbol;
                urlString += filterjenis;
            }

            var kelompok = $('#filterKelompok').val();
            if (kelompok) {
                var filterkelompok = 'kelompok=' + kelompok;
                if (first == true) {
                    symbol = '?';
                    first = false;
                } else {
                    symbol = '&';
                }
                urlString += symbol;
                urlString += filterkelompok;
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
        $(document).on('input', '#tipe, #edit_tipe, #jenis, #edit_jenis, #kelompok, #edit_kelompok', function() {
          let input = $(this);
          let value = input.val();
          
          let cleanedValue = value.replace(/[^a-zA-Z' ]/g, '');
          
          if (cleanedValue !== value) {
              input.val(cleanedValue);
          }
        });
        $(document).on('input', '#kode, #edit_kode', function() {
          let input = $(this);
          let value = input.val();
          
          let cleanedValue = value.replace(/[^0-9-]/g, '');
          
          if (cleanedValue !== value) {
              input.val(cleanedValue);
          }
        });
        function validateKode(input) {
            if (input.value.length > 6) {
                input.value = input.value.slice(0, 6);
            }
        }
    </script>
@endsection