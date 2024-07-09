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
                        <th width="15%">Aksi</th>
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
                            <td class="text-center">
                              <a href="javascript:void(0);" data-target="#modal-jurnal-create" data-toggle="modal" data-journable_id="{{ $item->id }}" data-journable_type="{{ 'App\Models\PembayaranSiswa' }}" class="btn bg-warning pt-1 pb-1 pl-2 pr-2 rounded">
                                  Jurnal
                              </a>
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
  </div>
  <!-- /.content-wrapper -->
  <div class="modal fade" id="modal-jurnal-create">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Data Jurnal</h4>
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
          <form id="addForm" action="{{ route('jurnal.store', ['instansi' => $instansi]) }}" method="post">
            @csrf
            <input type="hidden" id="journable_id" name="journable_id" value="">
            <input type="hidden" id="journable_type" name="journable_type" value="">
            <div class="form-group">
              <label for="tanggal">Tanggal</label>
              <input type="date" class="form-control" id="add_tanggal" name="tanggal" placeholder="tanggal" value="{{ old('tanggal') ?? date('Y-m-d') }}" required>
            </div>
            <div class="form-group">
              <label for="keterangan">Keterangan</label>
              <textarea name="keterangan" id="add_keterangan" class="form-control">{{ old('keterangan') }}</textarea>
            </div>
            <div>
              <table style="min-width: 100%">
                  <thead>
                      <tr>
                          <th>Akun</th>
                          <th>Debit</th>
                          <th>Kredit</th>
                          <th></th>
                      </tr>
                  </thead>
                  <tbody id="body_akun">
                      <tr id="row_0" class="mt-1">
                          <td>
                            <select name="akun[]" id="akun_0" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%" required>
                              <option value="">Pilih Akun</option>
                              @foreach ($akuns as $akun)
                                  <option value="{{ $akun->id }}" {{ old('akun.0') == $akun->id ? 'selected' : '' }}>{{ $akun->kode }} - {{ $akun->nama }}</option>
                              @endforeach
                            </select>
                          </td>
                          <td>
                              <input type="text" id="debit-0" name="debit[]" class="form-control" placeholder="Nominal Debit" value="" oninput="calculate()">
                          </td>
                          <td>
                              <input type="text" id="kredit-0" name="kredit[]" class="form-control" placeholder="Nominal Kredit" value="" oninput="calculate()">
                          </td>
                          <td>
                              <button class="btn btn-success" id="addRow">+</button>
                          </td>
                      </tr>
                  </tbody>
                  <tfoot>
                      <tr>
                          <td class="text-right pr-3">Total</td>
                          <td><input type="text" id="debit_keseluruhan" name="debit_keseluruhan" class="form-control" required readonly></td>
                          <td><input type="text" id="kredit_keseluruhan" name="kredit_keseluruhan" class="form-control" required readonly></td>
                      </tr>
                  </tfoot>
              </table>
              <p class="text-danger d-none" id="notMatch">Jumlah Belum Sesuai</p>
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
            <button type="submit" class="btn btn-primary" id="saveBtn">
              Save
            </button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
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
        $(document).on('input', '[id^=debit-], [id^=kredit-]', function() {
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
        $(document).on('submit', '#addForm', function(e) {
            let inputs = $(this).find('[id^=debit], [id^=kredit], [id^=nominal_debit], [id^=nominal_kredit]');
            inputs.each(function() {
                let input = $(this);
                let value = input.val();
                let cleanedValue = cleanNumber(value);

                input.val(cleanedValue);
            });

            return true;
            $('#btnEdit').removeClass('d-none');
            $('#btnSave, #btnClose').addClass('d-none');
            $('[id^=nama_akun_]').attr('disabled', true)
        });
        var rowCount = 1;
        $('#addRow').on('click', function(e){
            e.preventDefault();
            if($('[id^=row_]').length <= 10){
                var newRow = `
                    <tr id="row_${rowCount}">
                        <td>
                          <select name="akun[]" id="akun_${rowCount}" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%" required>
                            <option value="">Pilih Akun</option>
                            @foreach ($akuns as $akun)
                                <option value="{{ $akun->id }}">{{ $akun->kode }} - {{ $akun->nama }}</option>
                            @endforeach
                          </select>
                        </td>
                        <td>
                            <input type="text" id="debit-${rowCount}" name="debit[]" class="form-control" placeholder="Nominal Debit" value="" oninput="calculate()">
                        </td>
                        <td>
                            <input type="text" id="kredit-${rowCount}" name="kredit[]" class="form-control" placeholder="Nominal Kredit" value="" oninput="calculate()">
                        </td>
                        <td>
                            <button class="btn btn-danger removeRow" id="removeRow">-</button>
                        </td>
                    </tr>
                `;
                $('#body_akun').append(newRow); 
                rowCount++;
    
                $('.select2').select2();
            }
        });
        $(document).on('click', '.removeRow', function() {
            $(this).closest('tr').remove();
        });
        $('#modal-jurnal-create').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var journable_id = button.data('journable_id'); // Extract info from data-* attributes
            var journable_type = button.data('journable_type'); // Extract info from data-* attributes
            var modal = $(this);
            modal.find('#journable_id').val(journable_id);
            modal.find('#journable_type').val(journable_type);
        });
        function calculate(){
          var inputDebit = $('[id^=debit-]');
          var inputKredit = $('[id^=kredit-]');
          var total_debit = 0;
          var total_kredit = 0;
          inputDebit.each(function() {
              total_debit += parseInt(cleanNumber($(this).val())) || 0;
          });
          inputKredit.each(function() {
            total_kredit += parseInt(cleanNumber($(this).val())) || 0;
          });
          $('#debit_keseluruhan').val(formatNumber(total_debit))
          $('#kredit_keseluruhan').val(formatNumber(total_kredit))
          isMatch()
        }
        function isMatch(){
          var allDebit = cleanNumber($('#debit_keseluruhan').val());
          var allKredit = cleanNumber($('#kredit_keseluruhan').val());
          var reminder = $('#notMatch');
          var saveBtn = $('#saveBtn');
          if(allDebit == allKredit){
            reminder.addClass('d-none')
            saveBtn.attr('disabled', false)
          } else {
            reminder.removeClass('d-none')
            saveBtn.attr('disabled', true)
          }
        }
    </script>
@endsection