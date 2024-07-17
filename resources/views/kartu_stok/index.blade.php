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
            <h1 class="m-0">Kartu Stok</h1>
          </div>
          @if((Auth::user()->instansi_id == $data_instansi->id && in_array(Auth::user()->role, ['SARPRAS YAYASAN', 'TU'])) || in_array(Auth::user()->role, ['ADMIN']))
          <div class="col-sm-6">
            <a href="{{ route('kartu-stok.create', ['instansi' => $instansi]) }}" class="btn btn-primary float-sm-right">Tambah</a>
            <a href="javascript:void(0);" data-target="#modal-jurnal-create" data-toggle="modal" data-journable_id="{{ 0 }}" data-journable_type="{{ 'App\Models\KartuStok' }}" data-nominal="{{ $totalPerBulan }}" class="btn btn-success mr-1 rounded float-sm-right">
              Jurnal
            </a>
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
                  <h3 class="card-title">Kartu Stok</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="row mb-1">
                    <div class="col-sm-4 col-md-3 col-lg-2">
                      <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="filterAtk" style="width: 100%">
                        <option value="">ATK</option>
                        @foreach ($atks as $item)
                            <option value="{{ $item->id }}" {{ request()->input('atk') == $item->id ? 'selected' : '' }}>{{ $item->nama_atk }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-sm-4 col-md-3 col-lg-2">
                      <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="filterTahun" style="width: 100%">
                        <option value="">Tahun</option>
                        @foreach ($tahun as $item)
                            <option value="{{ $item }}" {{ request()->input('tahun') == $item ? 'selected' : '' }}>{{ $item }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-sm-4 col-md-3 col-lg-2">
                      <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="filterBulan" style="width: 100%">
                        <option value="">Bulan</option>
                        @foreach ($bulan as $key => $value)
                            <option value="{{ $key }}" {{ request()->input('bulan') == $key ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-sm-4 col-md-3 col-lg-6 d-flex justify-content-between">
                      <div>
                        <button class="btn btn-primary" type="button" onClick="filter()">Filter</button>
                        <button class="btn btn-warning" type="button" onClick="clearFilter()">Clear</button>
                      </div>
                      {{-- <div>
                        <button class="btn btn-success" type="button" id="btnExcel" onClick="excel()"><i class="far fa-file-excel"></i></button>
                        <button class="btn btn-danger ml-1" type="button" id="btnPdf" onclick="pdf()"><i class="far fa-file-pdf"></i></button>
                      </div> --}}
                    </div>
                  </div>
                  <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th width="5%">No</th>
                          <th>Atk</th>
                          <th>Tanggal</th>
                          <th>Pengambil/Supplier</th>
                          <th width="5%">Masuk</th>
                          <th>Harga/Unit Masuk</th>
                          <th>Total Masuk</th>
                          <th width="5%">Keluar</th>
                          <th>Harga/Unit Keluar</th>
                          <th>Total Keluar</th>
                          <th width="5%">Saldo</th>
                          <th>Harga/Unit Rata-rata</th>
                          <th>Total Saldo</th>
                          @if((Auth::user()->instansi_id == $data_instansi->id && in_array(Auth::user()->role, ['SARPRAS YAYASAN', 'TU'])) || in_array(Auth::user()->role, ['ADMIN']))
                          <th width="15%">Aksi</th>
                          @endif
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->atk->nama_atk ?? '-' }}</td>
                                <td>{{ $item->tanggal ? formatTanggal($item->tanggal) : '-' }}</td>
                                <td>{{ $item->pengambil ?? '-' }}</td>
                                <td>{{ $item->masuk ?? '-' }}</td>
                                <td>{{ $item->masuk != 0 ? formatRupiah($item->harga_unit_masuk) : '-' }}</td>
                                <td>{{ $item->masuk != 0 ? formatRupiah($item->total_harga_masuk) : '-' }}</td>
                                <td>{{ $item->keluar ?? '-' }}</td>
                                <td>{{ $item->keluar != 0 ? formatRupiah($item->harga_unit_keluar) : '-' }}</td>
                                <td>{{ $item->keluar != 0 ? formatRupiah($item->total_harga_keluar) : '-' }}</td>
                                <td>{{ $item->sisa ?? '-' }}</td>
                                <td>{{ $item->sisa != 0 ? formatRupiah($item->harga_rata_rata) : '-' }}</td>
                                <td>{{ $item->sisa != 0 ? formatRupiah($item->total_harga_stok) : '-' }}</td>
                                @if((Auth::user()->instansi_id == $data_instansi->id && in_array(Auth::user()->role, ['SARPRAS YAYASAN', 'SARPRAS SEKOLAH', 'TU'])) || in_array(Auth::user()->role, ['ADMIN']))
                                  <td class="text-center">
                                    @if(!$item->pembelian_atk_id)
                                    <button onclick="remove({{ $item->id }})" class="bg-danger pt-1 pb-1 pl-2 pr-2 rounded">
                                        <i class="fas fa-times fa-lg"></i>
                                    </button>
                                    @endif
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
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <div class="modal fade" id="modal-jurnal-create">
    <div class="modal-dialog modal-lg">
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
          <div class="row mb-2">
            <div class="col-sm-3 col-md-3 col-lg-3">
              <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="filterTahunNominal" style="width: 100%">
                <option value="">Pilih Tahun</option>
                @foreach ($tahun as $item)
                    <option value="{{ $item }}" {{ request()->input('tahun') == $item ? 'selected' : '' }}>{{ $item }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-sm-3 col-md-3 col-lg-3">
              <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="filterBulanNominal" style="width: 100%">
                <option value="">Pilih Bulan</option>
                @foreach ($bulan as $key => $value)
                    <option value="{{ $key }}" {{ request()->input('bulan') == $key ? 'selected' : '' }}>{{ $value }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-sm-3 col-md-3 col-lg-3">
              <div>
                <button class="btn btn-primary" type="button" onClick="filterNominal()">Filter</button>
              </div>
            </div>
          </div>
          <form id="addForm" action="{{ route('jurnal.store', ['instansi' => $instansi]) }}" method="post">
            @csrf
            <input type="hidden" id="journable_id" name="journable_id" value="">
            <input type="hidden" id="journable_type" name="journable_type" value="">
            <div class="form-group">
              <label for="nominal">Nominal</label>
              <input type="text" class="form-control" id="add_nominal" name="nominal" placeholder="Nominal" value="" readonly>
            </div>
            <div class="form-group">
              <label for="tanggal">Tanggal</label>
              <input type="date" class="form-control" id="add_tanggal" name="tanggal" placeholder="Tanggal" value="{{ old('tanggal') ?? date('Y-m-d') }}" required>
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
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        $(document).ready(function(){
          $('.daterange').daterangepicker();
        })
        $(function () {
            $("#example1").DataTable({
                "responsive": true, 
                "lengthChange": true, 
                "autoWidth": false,
                "buttons": ["excel", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $("#example2").DataTable({
                "responsive": true, 
                "lengthChange": true, 
                "autoWidth": false,
                "buttons": ["excel", "colvis"]
            }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
        });
        function filter() {
          let filterAtk = $('#filterAtk').val();
          let filterAtk2 = $('#filterAtk2').val();
          let filterTahun = $('#filterTahun').val();
          let filterBulan = $('#filterBulan').val();
          let filterTahun2 = $('#filterTahun2').val();
          let filterBulan2 = $('#filterBulan2').val();

          let url = "{{ route('kartu-stok.index', ['instansi' => $instansi]) }}";
          let queryString = '?tahun=' + filterTahun + '&bulan=' + filterBulan + '&atk=' + filterAtk + '&tahun2=' + filterTahun2 + '&bulan2=' + filterBulan2 + '&atk2=' + filterAtk2;
          window.location.href = url + queryString;
      }

      function clearFilter() {
        window.location.href = "{{ route('kartu-stok.index', ['instansi' => $instansi]) }}";
      }

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
        });
        $('#modal-jurnal-create').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var journable_id = button.data('journable_id');
            var journable_type = button.data('journable_type');
            var nominal = button.data('nominal');
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
                fetch(`kartu-stok/${id}/delete`, {
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
        function filterNominal() {
            let filterTahun = $('#filterTahunNominal').val();
            let filterBulan = $('#filterBulanNominal').val();
            $.ajax({
                  url: 'kartu-stok/getNominal', 
                  type: 'GET',
                  data: { 
                    bulan: filterBulan,
                    tahun: filterTahun,
                  }, 
                  headers: {
                      'X-CSRF-TOKEN': csrfToken
                  },
                  success: function(response) {
                    console.log(response)
                    $(document).ready(function() {
                      $('#journable_type').val(filterTipe == 'App\\Models\\KartuStok');
                    });
                    $('#add_nominal').val(formatNumber(response));
                  },
                  error: function(xhr, status, error) {
                      console.error('Error:', error);
                  }
              });
        }
    </script>
@endsection