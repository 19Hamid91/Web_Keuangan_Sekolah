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
            <a href="javascript:void(0);" data-target="#modal-jurnal-create" data-toggle="modal" data-journable_id="{{ 0 }}" data-journable_type="{{ 'App\Models\PembayaranSiswa' }}" data-nominal="{{ $totalPerBulan }}" class="btn btn-success mr-1 rounded float-sm-right">
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
                  <h3 class="card-title">Daftar Pembayaran Siswa Kelas {{ $kelas }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="row mb-1">
                    <div class="col-sm-6 col-md-4 col-lg-2">
                      <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="filterTahun" style="width: 100%">
                        <option value="">Pilih Tahun</option>
                        @foreach ($tahun as $item)
                            <option value="{{ $item }}" {{ request()->input('tahun') == $item ? 'selected' : '' }}>{{ $item }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-2">
                      <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="filterBulan" style="width: 100%">
                        <option value="">Pilih Bulan</option>
                        @foreach ($bulan as $key => $value)
                            <option value="{{ $key }}" {{ request()->input('bulan') == $key ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-8 d-flex justify-content-between">
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
                                <td class="text-right">
                                    @foreach ($items as $item)
                                        {{ $item->tagihan_siswa->jenis_tagihan ?? '-' }} ({{ $item->tagihan_siswa ? formatRupiah($item->tagihan_siswa->nominal) : '-' }})
                                        @if (!$loop->last)
                                            <br>
                                        @endif
                                    @endforeach
                                </td>
                                <td class="text-right">{{ $totalPembayaran ? formatRupiah($totalPembayaran) : '-' }}</td>
                                <td class="text-right">{{ $totalSisa ? formatRupiah($totalSisa) : '-' }}</td>
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
                                        <a href="{{ route('pembayaran_siswa.cetak', ['pembayaran_siswa' => $invoice, 'instansi' => $instansi]) }}" class="btn bg-success pt-1 pb-1 pl-2 pr-2 rounded" target="_blank">
                                          <i class="fas fa-download"></i>
                                        </a>
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
              <div class="form-group col-6">
                <label for="nominal">Nominal</label>
                <input type="text" class="form-control text-right" id="add_nominal" name="nominal" placeholder="Nominal" value="" readonly>
              </div>
              <div class="form-group col-6">
                <label for="nominal">JPI</label>
                <input type="text" class="form-control text-right" id="jpi" name="jpi" placeholder="JPI" value="" readonly>
              </div>
            </div>
            <div class="row">
              @if($instansi == 'tk-kb-tpa')
              <div class="form-group col-4">
                <label for="nominal">Registrasi</label>
                <input type="text" class="form-control text-right" id="registrasi" name="registrasi" placeholder="Registrasi" value="" readonly>
              </div>
              <div class="form-group col-4">
                <label for="nominal">SPP</label>
                <input type="text" class="form-control text-right" id="spp" name="spp" placeholder="SPP" value="" readonly>
              </div>
              <div class="form-group col-4">
                <label for="nominal">Outbond</label>
                <input type="text" class="form-control text-right" id="outbond" name="outbond" placeholder="Outbond" value="" readonly>
              </div>
              @else
              <div class="form-group col-6">
                <label for="nominal">Registrasi</label>
                <input type="text" class="form-control text-right" id="registrasi" name="registrasi" placeholder="Registrasi" value="" readonly>
              </div>
              <div class="form-group col-6">
                <label for="nominal">SPP</label>
                <input type="text" class="form-control text-right" id="spp" name="spp" placeholder="SPP" value="" readonly>
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
                              <input type="text" id="debit-0" name="debit[]" class="form-control text-right" placeholder="Nominal Debit" value="" oninput="calculate()">
                          </td>
                          <td>
                              <input type="text" id="kredit-0" name="kredit[]" class="form-control text-right" placeholder="Nominal Kredit" value="" oninput="calculate()">
                          </td>
                          <td>
                              <button class="btn btn-success" id="addRow">+</button>
                          </td>
                      </tr>
                  </tbody>
                  <tfoot>
                      <tr>
                          <td class="text-right pr-3">Total</td>
                          <td><input type="text" id="debit_keseluruhan" name="debit_keseluruhan" class="form-control text-right" required readonly></td>
                          <td><input type="text" id="kredit_keseluruhan" name="kredit_keseluruhan" class="form-control text-right" required readonly></td>
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
                            <input type="text" id="debit-${rowCount}" name="debit[]" class="form-control text-right" placeholder="Nominal Debit" value="" oninput="calculate()">
                        </td>
                        <td>
                            <input type="text" id="kredit-${rowCount}" name="kredit[]" class="form-control text-right" placeholder="Nominal Kredit" value="" oninput="calculate()">
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
        function filter() {
            let filterTahun = $('#filterTahun').val();
            let filterBulan = $('#filterBulan').val();

            let url = "{{ route('pembayaran_siswa.index', ['instansi' => $instansi, 'kelas' => $kelas]) }}";
            let queryString = '?tahun=' + filterTahun + '&bulan=' + filterBulan;
            window.location.href = url + queryString;
        }

        function clearFilter() {
          window.location.href = "{{ route('pembayaran_siswa.index', ['instansi' => $instansi, 'kelas' => $kelas]) }}";
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
                  url: '/{{ $instansi }}/pembayaran_siswa/getNominal', 
                  type: 'GET',
                  data: { 
                    tanggal: filterTanggal,
                    tingkat: "{{ $kelas }}",
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
                    $('#jpi').val(formatNumber(response.jpi));
                    if (response.jpi !== 0) data.push(response.jpi);
                    $('#registrasi').val(formatNumber(response.registrasi));
                    if (response.registrasi !== 0) data.push(response.registrasi);
                    $('#spp').val(formatNumber(response.spp));
                    if (response.spp !== 0) data.push(response.spp);
                    if("{{ $instansi == 'tk-kb-tpa' }}"){
                      $('#outbond').val(formatNumber(response.outbond));
                      if (response.outbond !== 0) data.push(response.outbond);
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
                        <input type="text" id="debit-${rowIndex}" name="debit[]" class="form-control text-right" placeholder="Nominal Debit" value="${formatNumber(item)}" oninput="calculate()">
                    </td>
                    <td>
                        <input type="text" id="kredit-${rowIndex}" name="kredit[]" class="form-control text-right" placeholder="Nominal Kredit" value="" oninput="calculate()">
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
                        <input type="text" id="debit-${rowIndex}" name="debit[]" class="form-control text-right" placeholder="Nominal Debit" value="${formatNumber(item)}" oninput="calculate()">
                    </td>
                    <td>
                        <input type="text" id="kredit-${rowIndex}" name="kredit[]" class="form-control text-right" placeholder="Nominal Kredit" value="" oninput="calculate()">
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
                      <input type="text" id="debit-${rowIndex}" name="debit[]" class="form-control text-right" placeholder="Nominal Debit" value="" oninput="calculate()">
                  </td>
                  <td>
                      <input type="text" id="kredit-${rowIndex}" name="kredit[]" class="form-control text-right" placeholder="Nominal Kredit" value="${formatNumber(item)}" oninput="calculate()">
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