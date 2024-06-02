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
            <button class="btn btn-primary float-sm-right" data-target="#modal-jabatan-create" data-toggle="modal">Tambah</button>
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
                  <h3 class="card-title">Jabatan</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="5%">No</th>
                        <th>Instansi</th>
                        <th>Jabatan</th>
                        <th>Gaji Pokok</th>
                        <th>Tunjangan Jabatan</th>
                        <th>Tunjangan Istri/Suami</th>
                        <th>Tunjangan Anak</th>
                        <th>Uang Makan</th>
                        <th>Uang Lembur</th>
                        <th>Askes</th>
                        <th width="15%">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($jabatans as $item)
                          <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->instansi->nama_instansi ?? '-' }}</td>
                            <td>{{ $item->jabatan ?? '-' }}</td>
                            <td>{{ $item->gaji_pokok ?? '-' }}</td>
                            <td>{{ $item->tunjangan_jabatan ?? '-' }}</td>
                            <td>{{ $item->tunjangan_istrisuami ?? '-' }}</td>
                            <td>{{ $item->tunjangan_anak ?? '-' }}</td>
                            <td>{{ $item->uang_makan ?? '-' }}</td>
                            <td>{{ $item->uang_lembur ?? '-' }}</td>
                            <td>{{ $item->askes ?? '-' }}</td>
                            <td class="text-center">
                              <button onclick="edit('{{ $item->id ?? '-' }}', '{{ $item->jabatan ?? '-' }}', '{{ $item->instansi_id ?? '-' }}', '{{ $item->gaji_pokok ?? '-' }}', '{{ $item->tunjangan_jabatan ?? '-' }}', '{{ $item->tunjangan_istrisuami ?? '-' }}', '{{ $item->tunjangan_anak ?? '-' }}', '{{ $item->uang_makan ?? '-' }}', '{{ $item->uang_lembur ?? '-' }}', '{{ $item->askes ?? '-' }}')" class="bg-warning pt-1 pb-1 pl-2 pr-2 rounded">
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
    <div class="modal fade" id="modal-jabatan-create">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Tambah Data jabatan</h4>
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
            <form action="{{ route('jabatan.store', ['instansi' => $instansi]) }}" method="post">
              @csrf
              <div class="form-group row">
                <div class="col-sm-6">
                  <label for="jabatan">Jabatan</label>
                  <input type="text" class="form-control" id="jabatan" name="jabatan" placeholder="Nama Jabatan" value="{{ old('jabatan') }}" required>
                </div>
                <div class="col-sm-6">
                  <label for="instansi_id">instansi</label>
                  <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" id="instansi_id" name="instansi_id" required>
                    <option value="{{ $data_instansi->id }}">{{ $data_instansi->nama_instansi }}</option>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-6">
                  <label for="gaji_pokok">Gaji Pokok</label>
                  <input type="number" class="form-control" id="gaji_pokok" name="gaji_pokok" placeholder="Gaji Pokok" value="{{ old('gaji_pokok') }}" required>
                </div>
                <div class="col-sm-6">
                <label for="tunjangan_jabatan">Tunjangan Jabatan</label>
                  <input type="number" class="form-control" id="tunjangan_jabatan" name="tunjangan_jabatan" placeholder="Tunjangan Jabatan" value="{{ old('tunjangan_jabatan') }}" required>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-6">
                  <label for="tunjangan_istrisuami">Tunjangan Istri/Suami</label>
                  <input type="number" class="form-control" id="tunjangan_istrisuami" name="tunjangan_istrisuami" placeholder="Tunjangan Istri/Suami" value="{{ old('tunjangan_istrisuami') }}" required>
                </div>
                <div class="col-sm-6">
                  <label for="tunjangan_anak">Tunjangan Anak</label>
                  <input type="number" class="form-control" id="tunjangan_anak" name="tunjangan_anak" placeholder="Tunjangan Anak" value="{{ old('tunjangan_anak') }}" required>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-6">
                  <label for="uang_makan">Uang Makan</label>
                  <input type="number" class="form-control" id="uang_makan" name="uang_makan" placeholder="Uang Makan" value="{{ old('uang_makan') }}" required>
                </div>
                <div class="col-sm-6">
                  <label for="askes">Asuransi Kesehatan</label>
                  <input type="number" class="form-control" id="askes" name="askes" placeholder="Asuransi Kesehatan" value="{{ old('askes') }}" required>
                </div>
              </div>
              @if ($instansi == 'tk')
              <div class="form-group row">
                <div class="col-sm-6">
                  <label for="uang_lembur">Uang Lembur</label>
                  <input type="number" class="form-control" id="uang_lembur" name="uang_lembur" placeholder="Uang Lembur" value="{{ old('uang_lembur') }}" required>
                </div>
              </div>
              @endif
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
    <div class="modal fade" id="modal-jabatan-edit">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Edit Data jabatan</h4>
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
              <div class="form-group row">
                <div class="col-sm-6">
                  <label for="jabatan">Jabatan</label>
                  <input type="text" class="form-control" id="edit_jabatan" name="jabatan" placeholder="Nama Jabatan" value="{{ old('jabatan') }}" required>
                </div>
                <div class="col-sm-6">
                  <label for="instansi_id">instansi</label>
                  <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" id="edit_instansi_id" name="instansi_id" required>
                    <option value="{{ $data_instansi->id }}">{{ $data_instansi->nama_instansi }}</option>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-6">
                  <label for="gaji_pokok">Gaji Pokok</label>
                  <input type="number" class="form-control" id="edit_gaji_pokok" name="gaji_pokok" placeholder="Gaji Pokok" value="{{ old('gaji_pokok') }}" required>
                </div>
                <div class="col-sm-6">
                <label for="tunjangan_jabatan">Tunjangan Jabatan</label>
                  <input type="number" class="form-control" id="edit_tunjangan_jabatan" name="tunjangan_jabatan" placeholder="Tunjangan Jabatan" value="{{ old('tunjangan_jabatan') }}" required>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-6">
                  <label for="tunjangan_istrisuami">Tunjangan Istri/Suami</label>
                  <input type="number" class="form-control" id="edit_tunjangan_istrisuami" name="tunjangan_istrisuami" placeholder="Tunjangan Istri/Suami" value="{{ old('tunjangan_istrisuami') }}" required>
                </div>
                <div class="col-sm-6">
                  <label for="tunjangan_anak">Tunjangan Anak</label>
                  <input type="number" class="form-control" id="edit_tunjangan_anak" name="tunjangan_anak" placeholder="Tunjangan Anak" value="{{ old('tunjangan_anak') }}" required>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-6">
                  <label for="uang_makan">Uang Makan</label>
                  <input type="number" class="form-control" id="edit_uang_makan" name="uang_makan" placeholder="Uang Makan" value="{{ old('uang_makan') }}" required>
                </div>
                <div class="col-sm-6">
                  <label for="askes">Asuransi Kesehatan</label>
                  <input type="number" class="form-control" id="edit_askes" name="askes" placeholder="Asuransi Kesehatan" value="{{ old('askes') }}" required>
                </div>
              </div>
              @if ($instansi == 'tk')
              <div class="form-group row">
                <div class="col-sm-6">
                  <label for="uang_lembur">Uang Lembur</label>
                  <input type="number" class="form-control" id="edit_uang_lembur" name="uang_lembur" placeholder="Uang Lembur" value="{{ old('uang_lembur') }}" required>
                </div>
              </div>
              @endif
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

        function edit(id, jabatan, instansi_id, gaji_pokok, tunjangan_jabatan, tunjangan_istrisuami, tunjangan_anak, uang_makan, uang_lembur, askes){
          $('#edit-form').attr('action', 'jabatan/'+id+'/update')
          $('#edit_instansi_id').val(instansi_id).trigger('change');
          $('#edit_jabatan').val(jabatan)
          $('#edit_gaji_pokok').val(gaji_pokok)
          $('#edit_tunjangan_jabatan').val(tunjangan_jabatan)
          $('#edit_tunjangan_istrisuami').val(tunjangan_istrisuami)
          $('#edit_tunjangan_anak').val(tunjangan_anak)
          $('#edit_uang_makan').val(uang_makan)
          $('#edit_uang_lembur').val(uang_lembur)
          $('#edit_askes').val(askes)
          $('#modal-jabatan-edit').modal('show')
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
                fetch(`jabatan/${id}/delete`, {
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