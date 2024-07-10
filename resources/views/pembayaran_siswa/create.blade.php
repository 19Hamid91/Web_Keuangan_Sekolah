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
            <h1 class="m-0">Tambah Data Pembayaran Siswa</h1>
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
                <!-- /.card-header -->
                <div class="card-body">
                    <form id="form" action="{{ route('pembayaran_siswa.store', ['instansi' => $instansi, 'kelas' => $kelas]) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <h3 class="text-center font-weight-bold">Data Pembayaran Siswa</h3>
                        <br><br>
                        <div class="row">
                          <div class="col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group">
                              <label>Tahun</label>
                              <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="tahun" style="width: 100%">
                                <option value="">Pilih Tahun</option>
                                @foreach ($tahun as $item)
                                    <option value="{{ $item }}" {{ request()->input('tahun') == $item ? 'selected' : '' }}>{{ $item }}</option>
                                @endforeach
                              </select>
                            </div>
                          </div>
                          <div class="col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group">
                              <label>Bulan</label>
                              <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="bulan" style="width: 100%">
                                <option value="">Pilih Bulan</option>
                                @foreach ($bulan as $key => $value)
                                    <option value="{{ $key }}" {{ request()->input('bulan') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                              </select>
                            </div>
                          </div>
                          <div class="col-sm-3 col-md-3 col-lg-3">
                            <div class="form-group">
                            <label>Siswa</label>
                            <select class="form-control select2" style="width: 100%" data-dropdown-css-class="select2-danger" id="siswa_id" name="siswa_id" required>
                                <option value="">Pilih Siswa</option>
                                @foreach ($siswa as $item)
                                    <option value="{{ $item->id }}" {{ old('siswa_id') == $item->id ? 'selected' : '' }} data-instansi="{{ $item->instansi_id }}" data-kelas="{{ $item->kelas_id }}">({{ $item->nis }}) {{ $item->nama_siswa }}</option>
                                @endforeach
                            </select>
                            </div>
                          </div>
                          <div class="col-sm-1 col-md-1 col-lg-1 d-flex align-items-center mt-3">
                            <button type="button" class="btn btn-primary" id="getTagihanSiswa"><i class="fas fa-search"></i></button>
                          </div>
                        </div>
                        <div id="listTagihan"></div>
                        <div class="row">
                          <div class="col-sm-4">
                              <label>Tipe Pembayaran</label>
                              <select class="form-control select2" style="width: 100%" data-dropdown-css-class="select2-danger" id="tipe_pembayaran" name="tipe_pembayaran" required>
                                <option value="Cash">Cash</option>
                                <option value="Transfer">Transfer</option>
                            </select>
                          </div>
                          <div class="col-sm-4">
                              <label>Total Tagihan</label>
                              <input type="text" id="tagihan" class="form-control" name="tagihan" disabled>
                          </div>
                          <div class="col-sm-4">
                              <label>Total Bayar</label>
                              <input type="text" id="total" class="form-control" name="total" required>
                              <p class="text-danger d-none" id="nominalWarning"></p>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-4">
                            <label>Bukti <a href="javascript:void(0)" id="clearFile" class="text-danger" onclick="clearFile()" title="Clear Image">clear</a>
                            </label>
                              <input type="file" id="bukti" class="form-control" name="file" accept="image/*">
                            <p class="text-danger">max 2mb</p>
                            <img id="preview" src="" alt="Preview" style="max-width: 40%;"/>
                          </div>
                        </div>
                        <hr>
                        <div class="row">
                          <div class="col-sm-6">
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
                                                <button class="btn btn-success" type="button" id="addRow">+</button>
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
                        </div>
                        <div>
                            <a href="{{ route('pembayaran_siswa.index', ['instansi' => $instansi, 'kelas' => $kelas]) }}" class="btn btn-secondary" type="button">Batal</a>
                            <button type="submit" id="btnSave" class="btn btn-success">Save</button>
                        </div>
                    </form>
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
      var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      $(document).ready(function(){
        if ($('#preview').attr('src') === '') {
              $('#preview').attr('src', defaultImg);
          }
      })
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
      $(document).on('input', '[id^=total], [id^=sisa], [id^=debit-], [id^=kredit-]', function() {
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
      $('#form').on('submit', function(e) {
          let inputs = $('#form').find('[id^=total], [id^=sisa], [id^=debit-], [id^=kredit-]');
          inputs.each(function() {
              let input = $(this);
              let value = input.val();
              let cleanedValue = cleanNumber(value);

              input.val(cleanedValue);
          });

          return true;
      });
      $('#tagihan_siswa_id').on('change', function(){
        let nominal = $(this).find(':selected').data('nominal');
        $('#total').val(formatNumber(nominal));
        $('#tagihan').val(formatNumber(nominal));
      });
      $('#total').on('input', function(){
        let bayar = cleanNumber($(this).val());
        let nominal = $('#tagihan_siswa_id').find(':selected').data('nominal');
        $('#sisa').val(formatNumber((parseInt(nominal) - parseInt(bayar))));
      });
      $('#getTagihanSiswa').on('click', function(){
        var siswa_id = $('#siswa_id').val();
        var tahun = $('#tahun').val();
        var bulan = $('#bulan').val();
        if(!siswa_id || !tahun || !bulan) {
          toastr.error('Siswa, tahun, bulan harus diisi', {
              closeButton: true,
              tapToDismisss: false,
              rtl: false,
              progressBar: true
          });
          return;
        }
        $.ajax({
            url: "/{{ $instansi }}/pembayaran_siswa/getTagihanSiswa",
            type: 'GET',
            data: { 
              tahun: tahun,
              bulan: bulan,
              siswa_id: siswa_id,
              }, 
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
              if(response.length != 0){
                populateTagihan(response);
              }
            },
            error: function(xhr, status, error) {
              toastr.error(error, {
                  closeButton: true,
                  tapToDismisss: false,
                  rtl: false,
                  progressBar: true
              });
            }
        });
      })

      function populateTagihan(data) {
          $('#listTagihan').empty();
          var max = 0;
          var jpi = 0;
          data.forEach((item, index) => {
              const row = `
              <div class="row mb-2">
                  <div class="col-sm-3">
                      <div class="form-group">
                          <input type="text" name="jenis_tagihan[]" class="form-control" value="${item.jenis_tagihan}" readonly>
                          <input type="hidden" name="tagihan_id[]" class="form-control" value="${item.id}">
                      </div>
                  </div>
                  <div class="col-sm-3">
                      <div class="form-group">
                          <div class="input-group mb-3">
                              <input type="date" name="mulai_bayar[]" class="form-control" value="${item.mulai_bayar}" readonly>
                          </div>
                      </div>
                  </div>
                  <div class="col-sm-3">
                      <div class="form-group">
                          <div class="input-group mb-3">
                              <input type="date" name="akhir_bayar[]" class="form-control" value="${item.akhir_bayar}" readonly>
                          </div>
                      </div>
                  </div>
                  <div class="col-sm-3">
                      <div class="form-group">
                          <div class="input-group mb-3">
                              <input type="text" name="nominal[]" class="form-control" placeholder="Nominal" value="${formatNumber(item.nominal)}" readonly>
                          </div>
                      </div>
                  </div>
              </div>
              `;
              $('#listTagihan').append(row);
              max += parseInt(item.nominal);
              if(item.jenis_tagihan == 'JPI'){
                jpi += parseInt(item.nominal);
              }
          });
          min = max - jpi;
          $('#total').val(formatNumber(max))
          $('#tagihan').val(formatNumber(max))
          $('#total').on('input', function() {
            var totalValue = parseInt(cleanNumber($(this).val()));
              if (totalValue < min) {
                $('#nominalWarning').removeClass('d-none')
                $('#nominalWarning').text('Nominal terlalu sedikit');
                $('#btnSave').attr('disabled', true);
              } else if (totalValue > max) {
                $('#nominalWarning').removeClass('d-none')
                $('#nominalWarning').text('Nominal terlalu besar');
                $('#btnSave').attr('disabled', true);
              } else {
                $('#nominalWarning').addClass('d-none')
                $('#nominalWarning').text();
                $('#btnSave').attr('disabled', false);
              }
          });
      }
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