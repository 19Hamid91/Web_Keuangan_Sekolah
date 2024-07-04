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
            <h1 class="m-0">Pemasukan Yayasan</h1>
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
                  <h3 class="card-title">Daftar Pemasukan Yayasan</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="row ps-2 pe-2">
                    <div class="col-sm-2 ps-0 pe-0 mb-3">
                        <select id="filterInstansi" name="filterInstansi" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" title="Instansi">
                            <option value="">Pilih Instansi</option>
                            <option value="SMP" {{ 'SMP' == request()->input('instansi') ? 'selected' : '' }}>SMP</option>
                            <option value="TK-KB-TPA" {{ 'TK-KB-TPA' == request()->input('instansi') ? 'selected' : '' }}>TK-KB-TPA</option>
                        </select>
                    </div>
                    <div class="col-sm-2 ps-0 pe-0">
                        <select id="filterJenis" name="filterJenis" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" title="Jenis">
                            <option value="">Pilih Jenis</option>
                            <option value="SPP" {{ 'SPP' == request()->input('jenis') ? 'selected' : '' }}>SPP</option>
                            <option value="JPI" {{ 'JPI' == request()->input('jenis') ? 'selected' : '' }}>JPI</option>
                        </select>
                    </div>
                    <div class="col-sm-2 ps-0 pe-0">
                        <select id="filterTipe" name="filterTipe" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" title="Tipe Pembayaran">
                            <option value="">Pilih Tipe Pembayaran</option>
                            <option value="Cash" {{ 'Cash' == request()->input('tipe') ? 'selected' : '' }}>Cash</option>
                            <option value="Transfer" {{ 'Transfer' == request()->input('tipe') ? 'selected' : '' }}>Transfer</option>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <a href="javascript:void(0);" id="filterBtn" data-base-url="{{ route('pemasukan_yayasan.index', ['instansi' => $instansi]) }}" class="btn btn-info">Filter</a>
                        <a href="javascript:void(0);" id="clearBtn" data-base-url="{{ route('pemasukan_yayasan.index', ['instansi' => $instansi]) }}" class="btn btn-warning">Clear</a>
                    </div>
                  </div>
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="5%">No</th>
                        <th>NIS</th>
                        <th>Siswa</th>
                        <th>Jenis</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Tipe Pembayaran</th>
                        <th>Instansi</th>
                        {{-- <th width="15%">Aksi</th> --}}
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($data as $item)
                          <tr>
                            <td>{{ $loop->iteration ?? '-' }}</td>
                            <td>{{ $item->siswa->nis ?? '-' }}</td>
                            <td>{{ $item->siswa->nama_siswa ?? '-' }}</td>
                            <td>{{ $item->tagihan_siswa->jenis_tagihan ?? '-' }}</td>
                            <td>{{ $item->tanggal ? formatTanggal($item->tanggal) : '-' }}</td>
                            @if ($item->tagihan_siswa->jenis_tagihan == 'SPP')
                                <td>{{ $item->total ? formatRupiah(($item->total * 0.25)) : '-' }}</td>
                            @else
                                <td>{{ $item->total ? formatRupiah($item->total) : '-' }}</td>
                            @endif
                            <td>{{ $item->tipe_pembayaran ?? '-' }}</td>
                            <td>{{ $item->siswa->instansi->nama_instansi ?? '-' }}</td>
                            {{-- <td class="text-center"> --}}
                              {{-- <a href="{{ route('pemasukan_yayasan.edit', ['pemasukan_yayasan' => $item->id, 'instansi' => $instansi]) }}" class="btn bg-warning pt-1 pb-1 pl-2 pr-2 rounded">
                                  <i class="fas fa-edit"></i>
                              </a>
                              <a href="{{ route('pemasukan_yayasan.show', ['pemasukan_yayasan' => $item->id, 'instansi' => $instansi]) }}" class="btn bg-secondary pt-1 pb-1 pl-2 pr-2 rounded">
                                  <i class="fas fa-eye"></i>
                              </a>
                              <a onclick="remove({{ $item->id }})" class="btn bg-danger pt-1 pb-1 pl-2 pr-2 rounded">
                                  <i class="fas fa-times fa-lg"></i>
                              </a> --}}
                            {{-- </td> --}}
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
                fetch(`pemasukan_yayasan/${id}/delete`, {
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

            var instansi = $('#filterInstansi').val();
            if (instansi) {
                var filterinstansi = 'instansi=' + instansi;
                if (first == true) {
                    symbol = '?';
                    first = false;
                } else {
                    symbol = '&';
                }
                urlString += symbol;
                urlString += filterinstansi;
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