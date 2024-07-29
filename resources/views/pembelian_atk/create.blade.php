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
            <h1 class="m-0">Tambah Pembelian Atk</h1>
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
                    <form id="addForm" action="{{ route('pembelian-atk.store', ['instansi' => $instansi]) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <h3 class="text-center font-weight-bold">Data Pembelian Atk</h3>
                        <br><br>
                        <div class="row">
                          <div class="col-sm-6">
                              <div class="form-group">
                              <label>Supplier</label>
                              <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" name="supplier_id" required>
                                  <option value="">Pilih Supplier</option>
                                  @foreach ($suppliers as $item)
                                      <option value="{{ $item->id }}" {{ old('supplier_id') == $item->id ? 'selected' : '' }}>{{ $item->nama_supplier }}</option>
                                  @endforeach
                              </select>
                              </div>
                          </div>
                          <div class="col-sm-6">
                              <div class="form-group">
                              <label>Tanggal Beli</label>
                              <input type="date" name="tgl_beliatk" class="form-control" placeholder="Tanggal Beli atk" value="{{ old('tgl_beliatk') ?? date('Y-m-d') }}" required>
                              </div>
                          </div>
                      </div>
                      <hr>
                      <div>
                          <table style="min-width: 100%">
                              <thead>
                                  <tr>
                                      <th>ATK</th>
                                      <th>Satuan</th>
                                      <th>Jumlah</th>
                                      <th>Harga Satuan</th>
                                      <th>Harga Total</th>
                                      <th></th>
                                  </tr>
                              </thead>
                              <tbody id="body_komponen">
                                  <tr id="row1_0" class="mt-1">
                                      <td>
                                          <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" name="atk_id[]" id="atk_id-0" required>
                                              <option value="">Pilih ATK</option>
                                              @foreach ($atks as $item)
                                                  <option value="{{ $item->id }}">{{ $item->nama_atk }}</option>
                                              @endforeach
                                          </select>
                                      </td>
                                      <td>
                                          <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" name="satuan[]" id="satuan-0" required>
                                            <option value="pcs" {{ old('satuan') == 'pcs' ? 'selected' : '' }}>pcs</option>
                                            <option value="rem" {{ old('satuan') == 'rem' ? 'selected' : '' }}>rem</option>
                                            <option value="box" {{ old('satuan') == 'box' ? 'selected' : '' }}>box</option>
                                            <option value="lusin" {{ old('satuan') == 'lusin' ? 'selected' : '' }}>lusin</option>
                                            <option value="kodi" {{ old('satuan') == 'kodi' ? 'selected' : '' }}>kodi</option>
                                            <option value="pack" {{ old('satuan') == 'pack' ? 'selected' : '' }}>pack</option>
                                          </select>
                                      </td>
                                      <td>
                                          <input type="text" id="jumlah_atk-0" name="jumlah_atk[]" class="form-control" placeholder="Jumlah atk" value="{{ old('jumlah_atk') }}" required oninput="calculatePrice(0)">
                                      </td>
                                      <td>
                                          <input type="text" id="hargasatuan_atk-0" name="hargasatuan_atk[]" class="form-control text-right" placeholder="Harga Satuan" value="{{ old('hargasatuan_atk') }}" required oninput="calculatePrice(0)">
                                      </td>
                                      {{-- <td> --}}
                                          <input type="hidden" id="diskon-0" name="diskon[]" class="form-control" placeholder="Diskon" value="0" required oninput="calculatePrice(0)">
                                      {{-- </td>
                                      <td> --}}
                                          <input type="hidden" id="ppn-0" name="ppn[]" class="form-control" placeholder="PPN" value="0" required oninput="calculatePrice(0)">
                                      {{-- </td> --}}
                                      <td>
                                          <input type="text" id="harga_total-0" name="harga_total[]" class="form-control text-right" placeholder="Harga Total" value="{{ old('harga_total') }}" required>
                                      </td>
                                      <td>
                                          <button class="btn btn-success" id="addRow1">+</button>
                                      </td>
                                  </tr>
                              </tbody>
                              <tfoot>
                                  <tr>
                                      <td colspan="4" class="text-right pr-3">Total</td>
                                      <td><input type="text" id="total" name="total" class="form-control" required readonly></td>
                                  </tr>
                              </tfoot>
                          </table>
                      </div>
                      <hr>
                      <div class="row">
                          <div class="col-sm-6">
                              <label>Bukti <a href="javascript:void(0)" id="clearFile" class="text-danger" onclick="clearFile()" title="Clear Image">clear</a>
                              </label>
                                <input type="file" id="bukti" class="form-control" name="file" accept="image/*">
                              <p class="text-danger">max 2mb</p>
                              <img id="preview" src="" alt="Preview" style="max-width: 40%;"/>
                          </div>
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
                                              <input type="text" id="debit-0" name="debit[]" class="form-control text-right" placeholder="Nominal Debit" value="" oninput="calculate()">
                                          </td>
                                          <td>
                                              <input type="text" id="kredit-0" name="kredit[]" class="form-control text-right" placeholder="Nominal Kredit" value="" oninput="calculate()">
                                          </td>
                                          <td>
                                              <button class="btn btn-success" type="button" id="addRow">+</button>
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
                      </div>
                        <div>
                            <a href="{{ route('pembelian-atk.index', ['instansi' => $instansi]) }}" class="btn btn-secondary" type="button">Batal</a>
                            <button type="submit" class="btn btn-success" id="saveBtn">Save</button>
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
      $(document).ready(function(){
        if ($('#preview').attr('src') === '') {
            $('#preview').attr('src', defaultImg);
        }
        var rowCount = 1;
        $('#addRow1').on('click', function(e){
            e.preventDefault();
            if($('[id^=row1_]').length <= 15){
                var newRow = `
                    <tr id="row1_${rowCount}">
                        <td>
                            <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" name="atk_id[]" id="atk_id-${rowCount}" required>
                                <option value="">Pilih ATK</option>
                                @foreach ($atks as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_atk }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" name="satuan[]" id="satuan-${rowCount}" required>
                                <option value="pcs">pcs</option>
                                <option value="rem">rem</option>
                                <option value="box">box</option>
                            </select>
                        </td>
                        <td>
                            <input type="text" id="jumlah_atk-${rowCount}" name="jumlah_atk[]" class="form-control" placeholder="Jumlah atk" value="" required oninput="calculatePrice(${rowCount})">
                        </td>
                        <td>
                            <input type="text" id="hargasatuan_atk-${rowCount}" name="hargasatuan_atk[]" class="form-control text-right" placeholder="Harga Satuan" value="" required oninput="calculatePrice(${rowCount})">
                        </td>
                            <input type="hidden" id="diskon-${rowCount}" name="diskon[]" class="form-control" placeholder="Diskon" value="0" required oninput="calculatePrice(${rowCount})">
                            <input type="hidden" id="ppn-${rowCount}" name="ppn[]" class="form-control" placeholder="PPN" value="0" required oninput="calculatePrice(${rowCount})">
                        <td>
                            <input type="text" id="harga_total-${rowCount}" name="harga_total[]" class="form-control text-right" placeholder="Harga Total" value="" required>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger removeRow1">-</button>
                        </td>
                    </tr>
                `;
                $('#body_komponen').append(newRow); 
                rowCount++;
    
                $('.select2').select2();
            }
        });

        $(document).on('click', '.removeRow1', function() {
            $(this).closest('tr').remove();
        });
      })
        $(document).on('input', '[id^=jumlah_atk], [id^=hargasatuan_atk], [id^=harga_total], [id^=debit-], [id^=kredit-]', function() {
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
        $('#addForm').on('submit', function(e) {
            let inputs = $('#addForm').find('[id^=jumlah_atk], [id^=hargasatuan_atk], [id^=harga_total], #total, [id^=debit-], [id^=kredit-]');
            inputs.each(function() {
                let input = $(this);
                let value = input.val();
                let cleanedValue = cleanNumber(value);

                input.val(cleanedValue);
            });

            return true;
        });
        $('#bukti').on('change', function() {
          const file = $(this)[0].files[0];
          if (file.size > 2 * 1024 * 1024) { 
              toastr.warning('Ukuran file tidak boleh lebih dari 2mb', {
                  closeButton: true,
                  tapToDismiss: false,
                  rtl: false,
                  progressBar: true
              });
              $(this).val(''); 
              return;
          }
          if (file) {
              const reader = new FileReader();
              reader.onload = function(e) {
                  $('#preview').attr('src', e.target.result);
              }
              reader.readAsDataURL(file);
          }
        });

        function clearFile(){
            $('#bukti').val('');
            $('#preview').attr('src', defaultImg);
        };
        function calculatePrice(id){
            validatePersen($('#diskon-' + id))
            validatePersen($('#ppn-' + id))
            var jumlah = cleanNumber($('#jumlah_atk-' + id).val())
            var harga_satuan = cleanNumber($('#hargasatuan_atk-' + id).val())
            var diskon = $('#diskon-' + id).val()
            var ppn = $('#ppn-' + id).val()

            var total = jumlah * harga_satuan;
            var total_after_diskon = total * ((100 - diskon) / 100);
            var total_ppn = total_after_diskon * ppn / 100;
            var final_total = total_after_diskon + total_ppn;
            $('#harga_total-' + id).val(formatNumber(final_total))

            var all_final_total = $('input[name="harga_total[]"]');
                var total_keseluruhan = 0;
                all_final_total.each(function() {
                    total_keseluruhan += parseInt(cleanNumber($(this).val())) || 0;
                });
            $('#total').val(formatNumber(total_keseluruhan))
            if(total_keseluruhan !== 0){
                var data = [];
                data.push(total_keseluruhan)
                populateJurnal(data);
            }
        }
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
        var total = cleanNumber($('#total').val());
        if(allDebit == allKredit && total == allDebit){
          reminder.addClass('d-none')
          saveBtn.attr('disabled', false)
        } else {
          reminder.removeClass('d-none')
          saveBtn.attr('disabled', true)
        }
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