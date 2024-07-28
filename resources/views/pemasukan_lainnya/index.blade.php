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
            <a href="javascript:void(0);" data-target="#modal-jurnal-create" data-toggle="modal" data-journable_id="{{ 0 }}" data-journable_type="{{ 'App\Models\PemasukanLainnya' }}" class="btn btn-success mr-1 rounded float-sm-right">
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
            <div class="col-sm-4 col-md-4 col-lg-4">
              <input class="form-control" type="date" name="tanggal" id="filterTanggal">
            </div>
            <div class="col-sm-4 col-md-4 col-lg-4">
              <div>
                <button class="btn btn-primary" type="button" onClick="filterNominal()">Filter</button>
              </div>
            </div>
          </div>
          <form id="addForm" action="{{ route('jurnal.store', ['instansi' => $instansi]) }}" method="post">
            @csrf
            <input type="hidden" id="journable_id" name="journable_id" value="">
            <input type="hidden" id="journable_type" name="journable_type" value="">
            <div class="row">
              @if($instansi == 'tk-kb-tpa')
              <div class="form-group col-4">
                <label for="nominal">Nominal</label>
                <input type="text" class="form-control" id="add_nominal" name="nominal" placeholder="Nominal" value="" readonly>
              </div>
              <div class="form-group col-4">
                <label for="nominal">Lainnya</label>
                <input type="text" class="form-control" id="lainnya" name="lainnya" placeholder="Lainnya" value="" readonly>
              </div>
              <div class="form-group col-4">
                <label for="nominal">Overtime</label>
                <input type="text" class="form-control" id="overtime" name="overtime" placeholder="Overtime" value="" readonly>
              </div>
              @elseif($instansi == 'yayasan')
              <div class="form-group col-6">
                <label for="nominal">Nominal</label>
                <input type="text" class="form-control" id="add_nominal" name="nominal" placeholder="Nominal" value="" readonly>
              </div>
              <div class="form-group col-6">
                <label for="nominal">Lainnya</label>
                <input type="text" class="form-control" id="lainnya" name="lainnya" placeholder="Lainnya" value="" readonly>
              </div>
              <div class="form-group col-6">
                <label for="nominal">Donasi</label>
                <input type="text" class="form-control" id="donasi" name="donasi" placeholder="Donasi" value="" readonly>
              </div>
              <div class="form-group col-6">
                <label for="nominal">Sewa Kantin</label>
                <input type="text" class="form-control" id="sewa_kantin" name="sewa_kantin" placeholder="Sewa Kantin" value="" readonly>
              </div>
              @else
              <div class="form-group col-6">
                <label for="nominal">Nominal</label>
                <input type="text" class="form-control" id="add_nominal" name="nominal" placeholder="Nominal" value="" readonly>
              </div>
              <div class="form-group col-6">
                <label for="nominal">Lainnya</label>
                <input type="text" class="form-control" id="lainnya" name="lainnya" placeholder="Lainnya" value="" readonly>
              </div>
              @endif
            </div>
            <div class="form-group">
              <label for="tanggal">Tanggal</label>
              <input type="date" class="form-control" id="add_tanggal" name="tanggal" placeholder="Tanggal" value="{{ old('tanggal') ?? date('Y-m-d') }}" required>
            </div>
            <div class="form-group">
              <label for="keterangan">Keterangan</label>
              <textarea name="keterangan" id="add_keterangan" class="form-control" required>{{ old('keterangan') }}</textarea>
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

        var rowCount = 1;
        $(document).on('click', '#addRow', function(e){
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
            calculate();
        });
        $('#modal-jurnal-create').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var journable_id = button.data('journable_id');
            var journable_type = button.data('journable_type');
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
          var nominal = cleanNumber($('#add_nominal').val());
          if(allDebit == allKredit && nominal == allDebit){
            reminder.addClass('d-none')
            saveBtn.attr('disabled', false)
          } else {
            reminder.removeClass('d-none')
            saveBtn.attr('disabled', true)
          }
        }
        function filterNominal() {
            let filterTanggal = $('#filterTanggal').val();
            $.ajax({
                  url: '/{{ $instansi }}/pemasukan_lainnya/getNominal', 
                  type: 'GET',
                  data: { 
                    tanggal: filterTanggal,
                  }, 
                  headers: {
                      'X-CSRF-TOKEN': csrfToken
                  },
                  success: function(response) {
                    $(document).ready(function() {
                      $('#journable_type').val('App\\Models\\PembayaranSiswa');
                    });
                    var data = [];
                    $('#add_nominal').val(formatNumber(response.total));
                    $('#lainnya').val(formatNumber(response.lainnya));
                    if (response.lainnya !== 0) data.push(response.lainnya);
                    if("{{ $instansi == 'yayasan' }}"){
                      $('#donasi').val(formatNumber(response.donasi));
                      if (response.donasi !== 0) data.push(response.donasi);
                      $('#sewa_kantin').val(formatNumber(response.sewa_kantin));
                      if (response.sewa_kantin !== 0) data.push(response.sewa_kantin);
                    }
                    if("{{ $instansi == 'tk-kb-tpa' }}"){
                      $('#overtime').val(formatNumber(response.overtime));
                      if (response.overtime !== 0) data.push(response.overtime);
                    }
                    populateJurnal(data);
                  },
                  error: function(xhr, status, error) {
                      console.error('Error:', error);
                  }
              });
        }
        function populateJurnal(data){
          var body = $('#body_akun')
          body.empty();
          rowIndex = 0;
          data.map(function(item){
            if(rowIndex == 0){
              var row1 = `
                <tr id="row_${rowIndex}" class="mt-1">
                    <td>
                        <select name="akun[]" id="akun_${rowIndex}" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%" required>
                            <option value="">Pilih Akun</option>
                            @foreach ($akuns as $akun)
                                <option value="{{ $akun->id }}">{{ $akun->kode }} - {{ $akun->nama }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="text" id="debit-${rowIndex}" name="debit[]" class="form-control" placeholder="Nominal Debit" value="${formatNumber(item)}" oninput="calculate()">
                    </td>
                    <td>
                        <input type="text" id="kredit-${rowIndex}" name="kredit[]" class="form-control" placeholder="Nominal Kredit" value="" oninput="calculate()">
                    </td>
                    <td>
                        <button class="btn btn-success" id="addRow">+</button>
                    </td>
                </tr>
              `;
            } else {
              var row1 = `
                <tr id="row_${rowIndex}" class="mt-1">
                    <td>
                        <select name="akun[]" id="akun_${rowIndex}" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%" required>
                            <option value="">Pilih Akun</option>
                            @foreach ($akuns as $akun)
                                <option value="{{ $akun->id }}">{{ $akun->kode }} - {{ $akun->nama }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="text" id="debit-${rowIndex}" name="debit[]" class="form-control" placeholder="Nominal Debit" value="${formatNumber(item)}" oninput="calculate()">
                    </td>
                    <td>
                        <input type="text" id="kredit-${rowIndex}" name="kredit[]" class="form-control" placeholder="Nominal Kredit" value="" oninput="calculate()">
                    </td>
                    <td>
                        <button class="btn btn-danger removeRow" type="button">-</button>
                    </td>
                </tr>
              `;
            }
            rowIndex++;
            var row2 = `
              <tr id="row_${rowIndex}" class="mt-1">
                  <td>
                      <select name="akun[]" id="akun_${rowIndex}" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%" required>
                          <option value="">Pilih Akun</option>
                          @foreach ($akuns as $akun)
                              <option value="{{ $akun->id }}">{{ $akun->kode }} - {{ $akun->nama }}</option>
                          @endforeach
                      </select>
                  </td>
                  <td>
                      <input type="text" id="debit-${rowIndex}" name="debit[]" class="form-control" placeholder="Nominal Debit" value="" oninput="calculate()">
                  </td>
                  <td>
                      <input type="text" id="kredit-${rowIndex}" name="kredit[]" class="form-control" placeholder="Nominal Kredit" value="${formatNumber(item)}" oninput="calculate()">
                  </td>
                  <td>
                      <button class="btn btn-danger removeRow" type="button">-</button>
                  </td>
              </tr>
            `;
          body.append(row1);
          body.append(row2);
          rowIndex++;
          })
          calculate();
        }
    </script>
@endsection