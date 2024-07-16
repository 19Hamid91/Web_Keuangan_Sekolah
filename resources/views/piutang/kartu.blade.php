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
            <h1 class="m-0">Kartu Piutang</h1>
          </div>
          {{-- @if((Auth::user()->instansi_id == $data_instansi->id && in_array(Auth::user()->role, ['BENDAHARA'])) || in_array(Auth::user()->role, ['ADMIN']))
          <div class="col-sm-6">
            <a href="{{ route('tagihan_siswa.create', ['instansi' => $instansi]) }}" class="btn btn-primary float-sm-right">Tambah</a>
            <a href="{{ route('tagihan_siswa.email') }}" class="btn btn-danger float-sm-right mr-1">Kirim Tagihan</a>
          </div>
          @endif --}}
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
                  <h3 class="card-title">Data Kartu Piutang</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="5%">No</th>
                        <th>Siswa</th>
                        <th>Tagihan</th>
                        <th>Cicilan 1</th>
                        <th>Cicilan 2</th>
                        <th>Cicilan 3</th>
                        <th>Cicilan 4</th>
                        <th>Cicilan 5</th>
                        <th>Cicilan 6</th>
                        @if($instansi == 'smp')
                        <th>Cicilan 7</th>
                        <th>Cicilan 8</th>
                        <th>Cicilan 9</th>
                        <th>Cicilan 10</th>
                        <th>Cicilan 11</th>
                        <th>Cicilan 12</th>
                        @endif
                        <th>Sisa Tagihan</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($data as $item)
                      @php
                          $terbayar = 0;
                          $jumlah = 0;
                          $max = $instansi == 'smp' ? 12 : 6;
                          $tagihan;
                      @endphp
                          <tr>
                            <td>{{ $loop->iteration ?? '-' }}</td>
                            <td>{{ $item->nama_siswa ?? '-' }}</td>
                            <td>JPI</td>
                            @foreach ($item->pembayaran as $pembayaran)
                                @if($pembayaran->tagihan_siswa->jenis_tagihan == 'JPI')
                                <td>{{ formatRupiah($pembayaran->total) }}</td>
                                    @php
                                        $terbayar += $pembayaran->total;
                                        $jumlah++;
                                        $tagihan = $pembayaran->tagihan_siswa;
                                    @endphp
                                @endif
                            @endforeach
                            @for ($i = $jumlah; $i < $max; $i++)
                                <td>-</td>
                            @endfor
                            <td>{{ formatRupiah(($tagihan->nominal -  $terbayar)) }}</td>
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