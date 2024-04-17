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
          <div class="col-sm-6">
            <button class="btn btn-primary float-sm-right" data-target="#modal-transaksi-create" data-toggle="modal">Tambah</button>
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
                  <h3 class="card-title">Transaksi</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="5%">No</th>
                        <th>Akun</th>
                        <th>Kode Transaksi</th>
                        <th>Nama Transaksi</th>
                        <th>Jenis Transaksi</th>
                        <th width="15%">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($transaksi as $item)
                          <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->akun->nama_akun ?? '-' }}</td>
                            <td>{{ $item->kode ?? '-' }}</td>
                            <td>{{ $item->nama_transaksi ?? '-' }}</td>
                            <td class="text-center">
                              <h5><span class="badge badge-pill {{ $item->jenis_transaksi == 'PEMASUKAN' ? 'badge-success' : 'badge-danger' ?? '-' }}">
                              {{ $item->jenis_transaksi ?? '-' }}
                              </span></h5>
                          </td>
                            <td class="text-center">
                              <button onclick="edit('{{ $item->id ?? '-' }}', '{{ $item->kode_akun ?? '-' }}', '{{ $item->kode ?? '-' }}', '{{ $item->nama_transaksi ?? '-' }}', '{{ $item->jenis_transaksi ?? '-' }}')" class="bg-warning pt-1 pb-1 pl-2 pr-2 rounded">
                                  <i class="fas fa-edit"></i>
                              </button>
                              <button onclick="remove({{ $item->id }})" class="bg-danger pt-1 pb-1 pl-2 pr-2 rounded">
                                  <i class="fas fa-times fa-lg"></i>
                              </button>
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

    {{-- Modal Start --}}
    <div class="modal fade" id="modal-transaksi-create">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Tambah Data Transaksi</h4>
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
            <form action="{{ route('transaksi.store') }}" method="post">
              @csrf
              <div class="form-group">
                <label>Akun</label>
                <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" id="kode_akun" name="kode_akun" required>
                  <option value="">Pilih Akun</option>
                  @foreach ($akun as $item)
                      <option value="{{ $item->kode }}" {{ old('kode_akun') == $item->kode ? 'selected' : '' }}>{{ $item->nama_akun }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="kode">Kode</label>
                <input type="text" class="form-control" id="kode" name="kode" placeholder="Kode Transaksi" value="{{ old('kode') }}" required>
              </div>
              <div class="form-group">
                <label for="nama_transaksi">Nama</label>
                <input type="text" class="form-control" id="nama_transaksi" name="nama_transaksi" placeholder="Nama Transaksi" value="{{ old('nama_transaksi') }}" required>
              </div>
              <div class="form-group">
                <label>Jenis Transaksi</label>
                <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" id="jenis_transaksi" name="jenis_transaksi" required>
                  <option value="">Pilih Jenis Transaksi</option>
                  <option value="PEMASUKAN" {{ old('jenis_transaksi') == 'PEMASUKAN' ? 'selected' : '' }}>Pemasukan</option>
                  <option value="PENGELUARAN" {{ old('jenis_transaksi') == 'PENGELUARAN' ? 'selected' : '' }}>Pengeluaran</option>
                </select>
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
    <div class="modal fade" id="modal-transaksi-edit">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Edit Data Transaksi</h4>
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
                <label>Akun</label>
                <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" id="edit_kode_akun" name="kode_akun" required>
                  <option value="">Pilih Akun</option>
                  @foreach ($akun as $item)
                      <option value="{{ $item->kode }}">{{ $item->nama_akun }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="kode">Kode</label>
                <input type="text" class="form-control" id="edit_kode" name="kode" placeholder="Kode Transaksi" required>
              </div>
              <div class="form-group">
                <label for="nama_transaksi">Nama</label>
                <input type="text" class="form-control" id="edit_nama_transaksi" name="nama_transaksi" placeholder="Nama Transaksi" required>
              </div>
              <div class="form-group">
                <label>Jenis Transaksi</label>
                <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" id="edit_jenis_transaksi" name="jenis_transaksi" required>
                  <option value="">Pilih Jenis Transaksi</option>
                  <option value="PEMASUKAN">Pemasukan</option>
                  <option value="PENGELUARAN">Pengeluaran</option>
                </select>
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
        $(function () {
            $("#example1").DataTable({
                "responsive": true, 
                "lengthChange": true, 
                "autoWidth": false,
                "buttons": ["excel", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });

        function edit(id, kode_akun, kode, nama_transaksi, jenis_transaksi){
          $('#edit-form').attr('action', 'transaksi/'+id+'/update')
          $('#edit_kode_akun').val(kode_akun).trigger('change')
          $('#edit_kode').val(kode)
          $('#edit_nama_transaksi').val(nama_transaksi)
          $('#edit_jenis_transaksi').val(jenis_transaksi).trigger('change')
          $('#modal-transaksi-edit').modal('show')
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
                fetch(`/transaksi/${id}/delete`, {
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