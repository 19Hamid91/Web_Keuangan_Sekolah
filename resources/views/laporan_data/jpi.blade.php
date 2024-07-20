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
            <h1 class="m-0">Laporan JPI</h1>
          </div>
        </div>
      </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Export All</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="row ps-2 pe-2">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <a href="{{ route('laporan_data.print_jpi', ['instansi' => $instansi, 'export' => 'pdf']) }}" class="btn btn-danger w-100">PDF</a>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <a href="{{ route('laporan_data.print_jpi', ['instansi' => $instansi, 'export' => 'excel']) }}" class="btn btn-success w-100">EXCEL</a>
                    </div>
                  </div>
                </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Export With Filter</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <form action="{{ route('laporan_data.print_jpi', ['instansi' => $instansi]) }}" method="get">
                  @csrf
                <div class="row ps-2 pe-2 mb-3">
                  <div class="col-sm-3 ps-0 pe-0">
                    <input type="date" class="form-control" name="filterDateStart" id="filterDateStart" value="{{ request()->input('dateStart') }}" title="Tanggal Awal">
                  </div>
                  <div class="col-sm-3 ps-0 pe-0">
                    <input type="date" class="form-control" name="filterDateEnd" id="filterDateEnd" value="{{ request()->input('dateEnd') }}" title="Tanggal Akhir">
                  </div>
                  <div class="col-sm-3 ps-0 pe-0">
                      <select id="filterTipe" name="filterTipe" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" title="Tipe Pembayaran">
                          <option value="">Pilih Tipe Pembayaran</option>
                          <option value="Cash" {{ 'Cash' == request()->input('tipe') ? 'selected' : '' }}>Cash</option>
                          <option value="Transfer" {{ 'Transfer' == request()->input('tipe') ? 'selected' : '' }}>Transfer</option>
                      </select>
                  </div>
                  <div class="col-sm-3 ps-0 pe-0">
                      <select id="filterKelas" name="filterKelas" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" title="kelas Pembayaran">
                          <option value="">Pilih Kelas</option>
                          @foreach ($kelas as $item)
                              <option value="{{ $item->id }}">{{ $item->tingkat }}-{{ $item->kelas }}</option>
                          @endforeach
                      </select>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6 col-md-6 col-sm-6">
                      <button type="submit" class="btn btn-danger w-100" name="export" value="pdf">PDF</button>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6">
                      <button type="submit" class="btn btn-success w-100" name="export" value="excel">EXCEL</button>
                  </div>
                </div>
              </form>
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