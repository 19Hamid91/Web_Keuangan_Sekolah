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
            <h1 class="m-0">Tambah Data Pemasukan Lainnya</h1>
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
                    <form id="addForm" action="{{ route('pemasukan_lainnya.store', ['instansi' => $instansi]) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <h3 class="text-center font-weight-bold">Data Pemasukan Lainnya</h3>
                        <br><br>
                        <div class="row">
                          <div class="col-sm-4">
                            <div class="form-group">
                            <label>Instansi</label>
                            <select class="form-control select2" style="width: 100%" data-dropdown-css-class="select2-danger" id="instansi_id" name="instansi_id" required>
                                <option value="{{ $data_instansi->id }}" {{ old('instansi_id') == $data_instansi->id ? 'selected' : '' }}>{{ $data_instansi->nama_instansi }}</option>
                            </select>
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                            <label>Jenis</label>
                            <select class="form-control select2" style="width: 100%" data-dropdown-css-class="select2-danger" id="jenis" name="jenis" required>
                                <option value="">Pilih Jenis</option>
                                @if($instansi == 'yayasan')
                                <option value="Donasi">Donasi</option>
                                <option value="Sewa Kantin">Sewa Kantin</option>
                                @elseif($instansi == 'tk-kb-tpa')
                                <option value="Overtime">Overtime</option>
                                @endif
                                <option value="Lainnya">Lainnya</option>
                            </select>
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                            <label>Tanggal</label>
                            <div class="input-group mb-3">
                              <input type="date" name="tanggal" class="form-control" placeholder="Tanggal" value="{{ old('tanggal') ?? date('Y-m-d') }}" required>
                            </div>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                            <div id="divDonaturId" class="col-sm-4" style="display: none">
                                <div class="form-group">
                                <label>Sumber</label>
                                <select class="form-control select2" style="width: 100%" data-dropdown-css-class="select2-danger" id="donatur_id" name="donatur_id">
                                    <option value="">Pilih Donatur</option>
                                    @foreach ($donaturs as $donatur)
                                        <option value="{{ $donatur->id }}">{{ $donatur->nama }}</option>      
                                    @endforeach
                                </select>
                                </div>
                            </div>
                            <div id="divDonatur" class="col-sm-4">
                                <div class="form-group">
                                <label>Sumber</label>
                                <input type="text" id="donatur" name="donatur" class="form-control" placeholder="Sumber">
                                </div>
                            </div>
                            <div id="divPenyewaKantin" class="col-sm-4">
                                <div class="form-group">
                                <label>Sumber</label>
                                <select class="form-control select2" style="width: 100%" data-dropdown-css-class="select2-danger" id="penyewa_id" name="penyewa_id">
                                  <option value="">Pilih Penyewa</option>
                                  @foreach ($penyewa_kantin as $penyewa)
                                      <option value="{{ $penyewa->id }}">{{ $penyewa->nama }}</option>      
                                  @endforeach
                              </select>
                                </div>
                            </div>
                          <div class="col-sm-4">
                              <div class="form-group">
                              <label>Total</label>
                              <input type="text" id="total" name="total" class="form-control" placeholder="Total Bayar" required value="0">
                              </div>
                          </div>
                          <div class="col-sm-4">
                              <div class="form-group">
                              <label>Keterangan</label>
                              <textarea class="form-control" name="keterangan" id="keterangan"></textarea>
                              </div>
                          </div>
                        </div>
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
                            <a href="{{ route('pemasukan_lainnya.index', ['instansi' => $instansi]) }}" class="btn btn-secondary" type="button">Batal</a>
                            <button type="submit" class="btn btn-success">Save</button>
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
      })
      $(document).on('input', '[id^=total], [id^=debit-], [id^=kredit-]', function() {
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
            let inputs = $('#addForm').find('[id^=total], [id^=debit-], [id^=kredit-]');
            inputs.each(function() {
                let input = $(this);
                let value = input.val();
                let cleanedValue = cleanNumber(value);

                input.val(cleanedValue);
            });

            return true;
        });
      $('#jenis').on('change', function(){
        let jenis = $(this).val();
        let instansi = "{{ $instansi }}"
        if(jenis == 'Donasi' && instansi == 'yayasan'){
          $('#divDonaturId').css('display', 'block');
          $('#divDonaturId').attr('required', true);
          
          $('#divDonatur').css('display', 'none');
          $('#divDonatur').attr('required', false);

          $('#divPenyewaKantin').css('display', 'none');
          $('#divPenyewaKantin').attr('required', false);
        } else if(jenis == 'Sewa Kantin' && instansi == 'yayasan'){
          $('#divDonaturId').css('display', 'none');
          $('#divDonaturId').attr('required', false);
          
          $('#divDonatur').css('display', 'none');
          $('#divDonatur').attr('required', false);

          $('#divPenyewaKantin').css('display', 'block');
          $('#divPenyewaKantin').attr('required', true);
        } else if (jenis == 'Donasi' && instansi != 'yayasan'){
          $('#divDonaturId').css('display', 'none');
          $('#divDonaturId').attr('required', false);
          
          $('#divDonatur').css('display', 'block');
          $('#divDonatur').attr('required', true);

          $('#divPenyewaKantin').css('display', 'none');
          $('#divPenyewaKantin').attr('required', false);
        } else {
          $('#divDonaturId').css('display', 'none');
          $('#divDonaturId').attr('required', false);
          
          $('#divDonatur').css('display', 'block');
          $('#divDonatur').attr('required', true);

          $('#divPenyewaKantin').css('display', 'none');
          $('#divPenyewaKantin').attr('required', false);
        }
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