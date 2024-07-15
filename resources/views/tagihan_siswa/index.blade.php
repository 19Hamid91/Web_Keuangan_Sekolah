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
            <h1 class="m-0">Tagihan Siswa</h1>
          </div>
          @if((Auth::user()->instansi_id == $data_instansi->id && in_array(Auth::user()->role, ['BENDAHARA'])) || in_array(Auth::user()->role, ['ADMIN']))
          <div class="col-sm-6">
            <a href="{{ route('tagihan_siswa.create', ['instansi' => $instansi]) }}" class="btn btn-primary float-sm-right">Tambah</a>
            <a href="{{ route('tagihan_siswa.email') }}" class="btn btn-danger float-sm-right mr-1">Kirim Tagihan</a>
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
                  <h3 class="card-title">Daftar Tagihan Siswa</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="5%">No</th>
                        <th>Tahun Ajaran</th>
                        <th>Tingkat</th>
                        <th>Periode</th>
                        <th>Jenis</th>
                        <th>Mulai Bayar</th>
                        <th>Akhir Bayar</th>
                        <th>Nominal</th>
                        @if((Auth::user()->instansi_id == $data_instansi->id && in_array(Auth::user()->role, ['BENDAHARA'])) || in_array(Auth::user()->role, ['ADMIN']))
                        <th width="15%">Aksi</th>
                        @endif
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($tagihan_siswa as $item)
                      @if(count($item->tagihan) > 0)
                          <tr>
                            <td>{{ $loop->iteration ?? '-' }}</td>
                            <td>{{ $item->tagihan[0]->tahun_ajaran->thn_ajaran ?? '-' }}</td>
                            <td>{{ $item->tingkat ?? '-' }}</td>
                            <td class="m-0 p-0">
                              <table class="w-100">
                                @foreach ($item->tagihan as $tagihan)
                                    <tr>
                                      <td>{{ $tagihan->periode ?? '-' }}</td>
                                    </tr>
                                @endforeach
                              </table>
                            </td>
                            <td class="m-0 p-0">
                              <table class="w-100">
                                @foreach ($item->tagihan as $tagihan)
                                    <tr>
                                      <td>{{ $tagihan->jenis_tagihan ?? '-' }}</td>
                                    </tr>
                                @endforeach
                              </table>
                            </td>
                            <td class="m-0 p-0">
                              <table class="w-100">
                                @foreach ($item->tagihan as $tagihan)
                                    <tr>
                                      <td>{{ $tagihan->mulai_bayar ? formatTanggal($tagihan->mulai_bayar) : '-' }}</td>
                                    </tr>
                                @endforeach
                              </table>
                            </td>
                            <td class="m-0 p-0">
                              <table class="w-100">
                                @foreach ($item->tagihan as $tagihan)
                                    <tr>
                                      <td>{{ $tagihan->akhir_bayar ? formatTanggal($tagihan->akhir_bayar) : '-' }}</td>
                                    </tr>
                                @endforeach
                              </table>
                            </td>
                            <td class="m-0 p-0">
                              <table class="w-100">
                                @foreach ($item->tagihan as $tagihan)
                                    <tr>
                                      <td>{{ $tagihan->nominal ? formatRupiah($tagihan->nominal) : '-' }}</td>
                                    </tr>
                                @endforeach
                              </table>
                            </td>
                            @if((Auth::user()->instansi_id == $data_instansi->id && in_array(Auth::user()->role, ['BENDAHARA'])) || in_array(Auth::user()->role, ['ADMIN']))
                            <td class="text-center">
                              <a href="{{ route('tagihan_siswa.edit', ['tagihan_siswa' => $item->tingkat, 'instansi' => $instansi]) }}" class="btn bg-warning pt-1 pb-1 pl-2 pr-2 rounded">
                                  <i class="fas fa-edit"></i>
                              </a>
                              <a href="{{ route('tagihan_siswa.show', ['tagihan_siswa' => $item->tingkat, 'instansi' => $instansi]) }}" class="btn bg-secondary pt-1 pb-1 pl-2 pr-2 rounded">
                                  <i class="fas fa-eye"></i>
                              </a>
                              <a onclick="remove('{{ $item->tingkat }}')" class="btn bg-danger pt-1 pb-1 pl-2 pr-2 rounded">
                                  <i class="fas fa-times fa-lg"></i>
                              </a>
                            </td>
                            @endif
                          </tr>
                      @endif
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
                fetch(`tagihan_siswa/${id}/delete`, {
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