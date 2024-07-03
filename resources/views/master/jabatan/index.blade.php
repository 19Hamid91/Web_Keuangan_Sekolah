@extends('layout')
@section('css')
    <style>
      input[type="checkbox"] {
            transform: scale(1.5);
        }
    </style>
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
            <button class="btn btn-primary float-sm-right" data-target="#modal-jabatan-create" data-toggle="modal">Tambah</button>
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
                  <h3 class="card-title">Jabatan</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="5%">No</th>
                        <th>Jabatan</th>
                        <th>Status</th>
                        <th>Gaji Pokok</th>
                        <th>Tunjangan Jabatan</th>
                        <th>Tunjangan Istri/Suami</th>
                        <th>Tunjangan Anak</th>
                        <th>Tunjangan Pendidikan</th>
                        <th>Transport</th>
                        @if($instansi == 'tk-kb-tpa')
                        <th>Uang Lembur</th>
                        @endif
                        <th>Instansi</th>
                        @if((Auth::user()->instansi_id == $data_instansi->id && in_array(Auth::user()->role, ['BENDAHARA'])) || in_array(Auth::user()->role, ['ADMIN']))
                        <th width="15%">Aksi</th>
                        @endif
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($jabatans as $item)
                          <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->jabatan ?? '-' }}</td>
                            <td>{{ $item->status ?? '-' }}</td>
                            <td>{{ $item->gaji_pokok ? formatRupiah($item->gaji_pokok) : 0 }}</td>
                            <td>{{ $item->tunjangan_jabatan ? formatRupiah($item->tunjangan_jabatan) : 0 }}</td>
                            <td>{{ $item->tunjangan_istrisuami ? formatRupiah($item->tunjangan_istrisuami) : 0 }}</td>
                            <td>{{ $item->tunjangan_anak ? formatRupiah($item->tunjangan_anak) : 0 }}</td>
                            <td>{{ $item->tunjangan_pendidikan ? formatRupiah($item->tunjangan_pendidikan) : 0 }}</td>
                            <td>{{ $item->transport ? formatRupiah($item->transport) : 0 }}</td>
                            @if($instansi == 'tk-kb-tpa')
                            <td>{{ $item->uang_lembur ? formatRupiah($item->uang_lembur) : 0 }}</td>
                            @endif
                            <td>{{ $item->instansi->nama_instansi ?? '-' }}</td>
                            @if((Auth::user()->instansi_id == $data_instansi->id && in_array(Auth::user()->role, ['BENDAHARA'])) || in_array(Auth::user()->role, ['ADMIN']))
                            <td class="text-center">
                              <button onclick="edit({{ $item }})" class="bg-warning pt-1 pb-1 pl-2 pr-2 rounded">
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
    <div class="modal fade" id="modal-jabatan-create">
      <div class="modal-dialog modal-lg">
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
            <form id="addForm" action="{{ route('jabatan.store', ['instansi' => $instansi]) }}" method="post">
              @csrf
              <div class="form-group row">
                <div class="col-sm-4">
                  <label for="instansi_id">Instansi</label>
                  <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" id="instansi_id" name="instansi_id" required>
                    <option value="{{ $data_instansi->id }}">{{ $data_instansi->nama_instansi }}</option>
                  </select>
                </div>
                <div class="col-sm-4">
                  <label for="status">Status</label>
                  <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" id="status" name="status" required>
                    <option value="Karyawan Tetap">Karyawan Tetap</option>
                    <option value="Karyawan Tidak Tetap">Karyawan Tidak Tetap</option>
                  </select>
                </div>
                <div class="col-sm-4">
                  <label for="jabatan">Jabatan</label>
                  <input type="text" class="form-control" id="jabatan" name="jabatan" placeholder="Nama Jabatan" value="{{ old('jabatan') }}" required>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-4">
                  <label for="gaji_pokok">Gaji Pokok</label>
                  <input type="text" class="form-control" id="gaji_pokok" name="gaji_pokok" placeholder="Gaji Pokok" value="{{ old('gaji_pokok') ?? 0 }}" required>
                </div>
                <div class="col-sm-4">
                <label for="tunjangan_jabatan">Tunjangan Jabatan</label>
                  <input type="text" class="form-control" id="tunjangan_jabatan" name="tunjangan_jabatan" placeholder="Tunjangan Jabatan" value="{{ old('tunjangan_jabatan') ?? 0 }}" required>
                </div>
                <div class="col-sm-4">
                  <label for="tunjangan_istrisuami">Tunjangan Istri/Suami</label>
                  <input type="text" class="form-control" id="tunjangan_istrisuami" name="tunjangan_istrisuami" placeholder="Tunjangan Istri/Suami" value="{{ old('tunjangan_istrisuami') ?? 0 }}" required>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-4">
                  <label for="tunjangan_anak">Tunjangan Anak</label>
                  <input type="text" class="form-control" id="tunjangan_anak" name="tunjangan_anak" placeholder="Tunjangan Anak" value="{{ old('tunjangan_anak') ?? 0 }}" required>
                </div>
                <div class="col-sm-4">
                  <label for="tunjangan_pendidikan">Tunjangan Pendidikan</label>
                  <input type="text" class="form-control" id="tunjangan_pendidikan" name="tunjangan_pendidikan" placeholder="Tunjangan Pendidikan" value="{{ old('tunjangan_pendidikan') ?? 0 }}" required>
                </div>
                <div class="col-sm-4">
                  <label for="dana_pensiun">Dana Pensiun</label>
                  <input type="text" class="form-control" id="dana_pensiun" name="dana_pensiun" placeholder="Dana Pensiun" value="{{ old('dana_pensiun') ?? 0 }}" required>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-4">
                  <label for="transport">Transport</label>
                  <input type="text" class="form-control" id="transport" name="transport" placeholder="Transport" value="{{ old('transport') ?? 0 }}" required>
                </div>
                @if ($instansi == 'tk-kb-tpa')
                <div class="col-sm-4">
                  <label for="uang_lembur">Uang Lembur</label>
                  <input type="text" class="form-control" id="uang_lembur" name="uang_lembur" placeholder="Uang Lembur" value="{{ old('uang_lembur') ?? 0 }}" required>
                </div>
                @endif
              </div>
              <div class="form-group row border p-1">
                <div class="col-sm-2 d-flex align-items-center justify-content-center mt-2">
                  <input type="checkbox" id="toggleBpjsKes" name="toggleBpjsKes">
                </div>
                <div class="col-sm-5">
                  <label for="bpjs_kes_sekolah">BPJS Kesehatan Sekolah</label><i class="fas fa-info-circle ml-1" data-toggle="tooltip" data-persen="4" title=" 4% dari UMK (Rp 3.243.975)"></i>
                  <input type="text" class="form-control" id="bpjs_kes_sekolah" name="bpjs_kes_sekolah" placeholder="BPJS Kesehatan" value="{{ old('bpjs_kes_sekolah') ?? 0 }}" readonly>
                </div>
                <div class="col-sm-5">
                  <label for="bpjs_kes_pribadi">BPJS Kesehatan Pribadi</label><i class="fas fa-info-circle ml-1" data-toggle="tooltip" data-persen="1" title=" 1% dari UMK (Rp 3.243.975)"></i>
                  <input type="text" class="form-control" id="bpjs_kes_pribadi" name="bpjs_kes_pribadi" placeholder="BPJS Kesehatan" value="{{ old('bpjs_kes_pribadi') ?? 0 }}" readonly>
                </div>
              </div>
              <div class="form-group row border p-1">
                <div class="col-sm-2 d-flex align-items-center justify-content-center mt-2">
                  <input type="checkbox" id="toggleBpjsKtk" name="toggleBpjsKtk">
                </div>
                <div class="col-sm-5">
                  <label for="bpjs_ktk_sekolah">BPJS Ketenagakerjaan Sekolah</label><i class="fas fa-info-circle ml-1" data-toggle="tooltip" data-persen="6.24" title="6,24% dari UMK (Rp 3.243.975)"></i>
                  <input type="text" class="form-control" id="bpjs_ktk_sekolah" name="bpjs_ktk_sekolah" placeholder="BPJS Ketenagakerjaan" value="{{ old('askes') ?? 0 }}" readonly>
                </div>
                <div class="col-sm-5">
                  <label for="bpjs_ktk_pribadi">BPJS Ketenagakerjaan pribadi</label><i class="fas fa-info-circle ml-1" data-toggle="tooltip" data-persen="3" title="3% dari UMK (Rp 3.243.975)"></i>
                  <input type="text" class="form-control" id="bpjs_ktk_pribadi" name="bpjs_ktk_pribadi" placeholder="BPJS Ketenagakerjaan" value="{{ old('askes') ?? 0 }}" readonly>
                </div>
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
    <div class="modal fade" id="modal-jabatan-edit">
      <div class="modal-dialog modal-lg">
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
                <div class="col-sm-4">
                  <label for="instansi_id">Instansi</label>
                  <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" id="edit_instansi_id" name="instansi_id" required>
                    <option value="{{ $data_instansi->id }}">{{ $data_instansi->nama_instansi }}</option>
                  </select>
                </div>
                <div class="col-sm-4">
                  <label for="status">Status</label>
                  <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" id="edit_status" name="status" required>
                    <option value="Karyawan Tetap">Karyawan Tetap</option>
                    <option value="Karyawan Tidak Tetap">Karyawan Tidak Tetap</option>
                  </select>
                </div>
                <div class="col-sm-4">
                  <label for="jabatan">Jabatan</label>
                  <input type="text" class="form-control" id="edit_jabatan" name="jabatan" placeholder="Nama Jabatan" value="{{ old('jabatan') }}" required>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-4">
                  <label for="gaji_pokok">Gaji Pokok</label>
                  <input type="text" class="form-control" id="edit_gaji_pokok" name="gaji_pokok" placeholder="Gaji Pokok" value="{{ old('gaji_pokok') ?? 0 }}" required>
                </div>
                <div class="col-sm-4">
                <label for="tunjangan_jabatan">Tunjangan Jabatan</label>
                  <input type="text" class="form-control" id="edit_tunjangan_jabatan" name="tunjangan_jabatan" placeholder="Tunjangan Jabatan" value="{{ old('tunjangan_jabatan') ?? 0 }}" required>
                </div>
                <div class="col-sm-4">
                  <label for="tunjangan_istrisuami">Tunjangan Istri/Suami</label>
                  <input type="text" class="form-control" id="edit_tunjangan_istrisuami" name="tunjangan_istrisuami" placeholder="Tunjangan Istri/Suami" value="{{ old('tunjangan_istrisuami') ?? 0 }}" required>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-4">
                  <label for="tunjangan_anak">Tunjangan Anak</label>
                  <input type="text" class="form-control" id="edit_tunjangan_anak" name="tunjangan_anak" placeholder="Tunjangan Anak" value="{{ old('tunjangan_anak') ?? 0 }}" required>
                </div>
                <div class="col-sm-4">
                  <label for="tunjangan_pendidikan">Tunjangan Pendidikan</label>
                  <input type="text" class="form-control" id="edit_tunjangan_pendidikan" name="tunjangan_pendidikan" placeholder="Tunjangan Pendidikan" value="{{ old('tunjangan_pendidikan') ?? 0 }}" required>
                </div>
                <div class="col-sm-4">
                  <label for="dana_pensiun">Dana Pensiun</label>
                  <input type="text" class="form-control" id="edit_dana_pensiun" name="dana_pensiun" placeholder="Dana Pensiun" value="{{ old('dana_pensiun') ?? 0 }}" required>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-4">
                  <label for="transport">Transport</label>
                  <input type="text" class="form-control" id="edit_transport" name="transport" placeholder="Transport" value="{{ old('transport') ?? 0 }}" required>
                </div>
              @if ($instansi == 'tk-kb-tpa')
                <div class="col-sm-4">
                  <label for="uang_lembur">Uang Lembur</label>
                  <input type="text" class="form-control" id="edit_uang_lembur" name="uang_lembur" placeholder="Uang Lembur" value="{{ old('uang_lembur') ?? 0 }}" required>
                </div>
                @endif
              </div>
              <div class="form-group row border p-1">
                <div class="col-sm-2 d-flex align-items-center justify-content-center mt-2">
                  <input type="checkbox" id="edit_toggleBpjsKes" name="toggleBpjsKes">
                </div>
                <div class="col-sm-5">
                  <label for="bpjs_kes_sekolah">BPJS Kesehatan Sekolah</label><i class="fas fa-info-circle ml-1" data-toggle="tooltip" data-persen="4" title=" 4% dari UMK (Rp 3.243.975)"></i>
                  <input type="text" class="form-control" id="edit_bpjs_kes_sekolah" name="bpjs_kes_sekolah" placeholder="BPJS Kesehatan" value="{{ old('bpjs_kes_sekolah') ?? 0 }}" readonly>
                </div>
                <div class="col-sm-5">
                  <label for="bpjs_kes_pribadi">BPJS Kesehatan Pribadi</label><i class="fas fa-info-circle ml-1" data-toggle="tooltip" data-persen="1" title=" 1% dari UMK (Rp 3.243.975)"></i>
                  <input type="text" class="form-control" id="edit_bpjs_kes_pribadi" name="bpjs_kes_pribadi" placeholder="BPJS Kesehatan" value="{{ old('bpjs_kes_pribadi') ?? 0 }}" readonly>
                </div>
              </div>
              <div class="form-group row border p-1">
                <div class="col-sm-2 d-flex align-items-center justify-content-center mt-2">
                  <input type="checkbox" id="edit_toggleBpjsKtk" name="toggleBpjsKtk">
                </div>
                <div class="col-sm-5">
                  <label for="bpjs_ktk_sekolah">BPJS Ketenagakerjaan Sekolah</label><i class="fas fa-info-circle ml-1" data-toggle="tooltip" data-persen="6,24" title="6,24% dari UMK (Rp 3.243.975)"></i>
                  <input type="text" class="form-control" id="edit_bpjs_ktk_sekolah" name="bpjs_ktk_sekolah" placeholder="BPJS Ketenagakerjaan" value="{{ old('askes') ?? 0 }}" readonly>
                </div>
                <div class="col-sm-5">
                  <label for="bpjs_ktk_pribadi">BPJS Ketenagakerjaan pribadi</label><i class="fas fa-info-circle ml-1" data-toggle="tooltip" data-persen="3" title="3% dari UMK (Rp 3.243.975)"></i>
                  <input type="text" class="form-control" id="edit_bpjs_ktk_pribadi" name="bpjs_ktk_pribadi" placeholder="BPJS Ketenagakerjaan" value="{{ old('askes') ?? 0 }}" readonly>
                </div>
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
      $(document).ready(function () {
          $('[data-toggle="tooltip"]').tooltip();
          toggleInputs('#toggleBpjsKes', ['#bpjs_kes_sekolah', '#bpjs_kes_pribadi']);
          toggleInputs('#toggleBpjsKtk', ['#bpjs_ktk_sekolah', '#bpjs_ktk_pribadi']);
          toggleInputs('#edit_toggleBpjsKes', ['#edit_bpjs_kes_sekolah', '#edit_bpjs_kes_pribadi']);
          toggleInputs('#edit_toggleBpjsKtk', ['#edit_bpjs_ktk_sekolah', '#edit_bpjs_ktk_pribadi']);
      });
       $(document).on('input', '[id^=gaji_pokok],[id^=tunjangan_], [id^=uang_], [id^=bpjs], [id^=edit_bpjs], [id^=edit_gaji_pokok],[id^=edit_tunjangan_], [id^=edit_uang_], [id^=edit_askes], #dana_pensiun, #edit_dana_pensiun, #transport, #edit_transport', function() {
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
            let inputs = $('#addForm, #edit-form').find('[id^=gaji_pokok],[id^=tunjangan_], [id^=uang_], [id^=bpjs], [id^=edit_bpjs], [id^=edit_gaji_pokok],[id^=edit_tunjangan_], [id^=edit_uang_], [id^=edit_askes], #dana_pensiun, #edit_dana_pensiun, #transport, #edit_transport');
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
                "buttons": ["excel", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });

        function edit(item){
          $('#edit-form').attr('action', 'jabatan/'+item.id+'/update')
          $('#edit_instansi_id').val(item.instansi_id).trigger('change');
          $('#edit_status').val(item.status).trigger('change');
          $('#edit_jabatan').val(item.jabatan)
          $('#edit_gaji_pokok').val(formatNumber(item.gaji_pokok))
          $('#edit_tunjangan_jabatan').val(formatNumber(item.tunjangan_jabatan))
          $('#edit_tunjangan_istrisuami').val(formatNumber(item.tunjangan_istrisuami))
          $('#edit_tunjangan_anak').val(formatNumber(item.tunjangan_anak))
          $('#edit_tunjangan_pendidikan').val(formatNumber(item.tunjangan_pendidikan))
          $('#edit_dana_pensiun').val(formatNumber(item.dana_pensiun))
          $('#edit_transport').val(formatNumber(item.transport))
          if('{{ $instansi }}' == 'tk-kb-tpa'){
            $('#edit_uang_lembur').val(formatNumber(item.uang_lembur))
          }
          if(item.bpjs_kes_sekolah){
            $('#edit_toggleBpjsKes').attr('checked', true)
          }
          if(item.bpjs_ktk_sekolah){
            $('#edit_toggleBpjsKtk').attr('checked', true)
          }
          $('#edit_bpjs_kes_sekolah').val(formatNumber(item.bpjs_kes_sekolah))
          $('#edit_bpjs_ktk_sekolah').val(formatNumber(item.bpjs_ktk_sekolah))
          $('#edit_bpjs_kes_pribadi').val(formatNumber(item.bpjs_kes_pribadi))
          $('#edit_bpjs_ktk_pribadi').val(formatNumber(item.bpjs_ktk_pribadi))
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

        function toggleInputs(toggleId, inputIds) {
            const UMK = 3243969; // Nilai tetap untuk UMK

            $(toggleId).change(function() {
                var isChecked = $(this).is(':checked');

                inputIds.forEach(function(inputId) {
                    var $input = $(inputId);
                    var persen = parseFloat($input.siblings('i').attr('data-persen'));

                    if (isChecked) {
                        var calculatedValue = (persen / 100) * UMK;
                        
                        var decimalPart = calculatedValue % 1;
                        if (decimalPart >= 0.5) {
                            calculatedValue = Math.ceil(calculatedValue);
                        } else {
                            calculatedValue = Math.floor(calculatedValue);
                        }

                        $input.val(formatNumber(calculatedValue));
                    } else {
                        $input.val(0);
                    }
                });
            });
        }
    </script>
@endsection