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
            <h1 class="m-0">Pembayaran Siswa</h1>
          </div>
          @if((Auth::user()->instansi_id == $data_instansi->id && in_array(Auth::user()->role, ['BENDAHARA'])) || in_array(Auth::user()->role, ['ADMIN']))
          <div class="col-sm-6">
            <a href="{{ route('pembayaran_siswa.create', ['instansi' => $instansi, 'kelas' => $kelas]) }}" class="btn btn-primary float-sm-right">Tambah</a>
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
                  <h3 class="card-title">Daftar Pembayaran Siswa Kelas {{ $kelas }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Invoice</th>
                            <th>Siswa</th>
                            <th>Tagihan</th>
                            <th>Jumlah Bayar</th>
                            <th>Sisa</th>
                            <th>Tanggal</th>
                            <th class="text-center">Status</th>
                            @if((Auth::user()->instansi_id == $data_instansi->id && in_array(Auth::user()->role, ['BENDAHARA'])) || in_array(Auth::user()->role, ['ADMIN']))
                                <th width="15%">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $invoice => $items)
                            @php
                                $firstItem = $items->first();
                                $totalPembayaran = $items->sum('total');
                                $totalSisa = $items->sum('sisa');
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration ?? '-' }}</td>
                                <td>{{ $invoice ?? '-' }}</td>
                                <td>{{ $firstItem->siswa->nama_siswa ?? '-' }}</td>
                                <td>
                                    @foreach ($items as $item)
                                        {{ $item->tagihan_siswa->jenis_tagihan ?? '-' }} ({{ formatRupiah($item->tagihan_siswa->nominal) }})
                                        @if (!$loop->last)
                                            <br>
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{ $totalPembayaran ? formatRupiah($totalPembayaran) : '-' }}</td>
                                <td>{{ $totalSisa ? formatRupiah($totalSisa) : '-' }}</td>
                                <td>
                                    @foreach ($items as $item)
                                        {{ $item->tanggal ? formatTanggal($item->tanggal) : '-' }}
                                        @if (!$loop->last)
                                            <br>
                                        @endif
                                    @endforeach
                                </td>
                                <td class="text-center">
                                  @foreach ($items as $item)
                                      <span class="badge badge-pill {{ $item->status == 'LUNAS' ? 'badge-success' : 'badge-danger' }}">
                                          {{ $item->status ?? '-' }}
                                      </span>
                                      @if (!$loop->last)
                                          <br>
                                      @endif
                                  @endforeach
                              </td>
                                @if((Auth::user()->instansi_id == $data_instansi->id && in_array(Auth::user()->role, ['BENDAHARA'])) || in_array(Auth::user()->role, ['ADMIN']))
                                    <td class="text-center">
                                        <a href="{{ route('pembayaran_siswa.edit', ['pembayaran_siswa' => $invoice, 'instansi' => $instansi,  'kelas' => $kelas]) }}" class="btn bg-warning pt-1 pb-1 pl-2 pr-2 rounded">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('pembayaran_siswa.show', ['pembayaran_siswa' => $invoice, 'instansi' => $instansi,  'kelas' => $kelas]) }}" class="btn bg-secondary pt-1 pb-1 pl-2 pr-2 rounded">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a onclick="remove('{{ $invoice }}')" class="btn bg-danger pt-1 pb-1 pl-2 pr-2 rounded">
                                            <i class="fas fa-times fa-lg"></i>
                                        </a>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
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
                fetch(`/{{ $instansi }}/pembayaran_siswa/${id}/delete`, {
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