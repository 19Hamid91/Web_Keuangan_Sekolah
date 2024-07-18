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
            <h1 class="m-0">Pemasukan Lainnya</h1>
          </div>
          @if((Auth::user()->instansi_id == $data_instansi->id && in_array(Auth::user()->role, ['BENDAHARA'])) || in_array(Auth::user()->role, ['ADMIN']))
          <div class="col-sm-6">
            <a href="{{ route('pemasukan_lainnya.create', ['instansi' => $instansi]) }}" class="btn btn-primary float-sm-right">Tambah</a>
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
                  <h3 class="card-title">Daftar Pemasukan Lainnya</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="row ps-2 pe-2 mb-3">
                    <div class="col-sm-2 ps-0 pe-0">
                        <select id="filterJenis" name="filterJenis" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" title="Jenis">
                            <option value="Lainnya" {{ $jenis == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            @if($instansi == 'yayasan')
                            <option value="Donasi" {{ $jenis == 'Donasi' ? 'selected' : '' }}>Donasi</option>
                            <option value="Sewa Kantin" {{ $jenis == 'Sewa Kantin' ? 'selected' : '' }}>Sewa Kantin</option>
                            @elseif($instansi == 'tk-kb-tpa')
                            <option value="Overtime" {{ $jenis == 'Overtime' ? 'selected' : '' }}>Overtime</option>
                            @endif
                          </select>
                    </div>
                  </div>
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="5%">No</th>
                        <th>Invoice</th>
                        <th>Sumber</th>
                        <th>Jenis</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Keterangan</th>
                        @if((Auth::user()->instansi_id == $data_instansi->id && in_array(Auth::user()->role, ['BENDAHARA'])) || in_array(Auth::user()->role, ['ADMIN']))
                        <th width="15%">Aksi</th>
                        @endif
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($data as $item)
                          <tr>
                            <td>{{ $loop->iteration ?? '-' }}</td>
                            <td>{{ $item->invoice ?? '-' }}</td>
                            <td>{{ isset($item->donasi->id) ? $item->donasi->nama : $item->donatur }}</td>
                            <td>{{ $item->jenis ?? '-' }}</td>
                            <td>{{ $item->tanggal ? formatTanggal($item->tanggal) : '-' }}</td>
                            <td>{{ $item->total ? formatRupiah($item->total) : '-' }}</td>
                            <td>{{ $item->keterangan ?? '-' }}</td>
                            @if((Auth::user()->instansi_id == $data_instansi->id && in_array(Auth::user()->role, ['BENDAHARA'])) || in_array(Auth::user()->role, ['ADMIN']))
                            <td class="text-center">
                              <a href="{{ route('pemasukan_lainnya.cetak', ['id' => $item->id, 'instansi' => $instansi]) }}" class="btn bg-success pt-1 pb-1 pl-2 pr-2 rounded" target="_blank">
                                <i class="fas fa-download"></i>
                              </a>
                              <a href="{{ route('pemasukan_lainnya.edit', ['pemasukan_lainnya' => $item->id, 'instansi' => $instansi]) }}" class="btn bg-warning pt-1 pb-1 pl-2 pr-2 rounded">
                                  <i class="fas fa-edit"></i>
                              </a>
                              <a href="{{ route('pemasukan_lainnya.show', ['pemasukan_lainnya' => $item->id, 'instansi' => $instansi]) }}" class="btn bg-secondary pt-1 pb-1 pl-2 pr-2 rounded">
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
                fetch(`pemasukan_lainnya/${id}/delete`, {
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

        $('#filterJenis').change(function(){
          var jenis = $(this).val();
          if(!jenis) return false; 
          let url = "{{ route('pemasukan_lainnya.index', ['instansi' => $instansi]) }}";
          url = '?jenis=' + jenis;
          window.location.href = url;
        })
    </script>
@endsection