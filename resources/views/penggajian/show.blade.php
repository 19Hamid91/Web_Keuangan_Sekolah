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
            <h1 class="m-0">Detail Data Penggajian</h1>
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
                        <h3 class="text-center font-weight-bold">Data Penggajian</h3>
                        <br><br>
                        <div class="row">
                          <div class="col-sm-4">
                            <div class="form-group">
                            <label>Karyawan</label>
                            <select class="form-control select2" style="width: 100%" data-dropdown-css-class="select2-danger" id="karyawan_id" name="karyawan_id" required disabled>
                                <option value="">Pilih Karyawan</option>
                                @foreach ($karyawans as $item)
                                    <option value="{{ $item->id }}" {{ $data->karyawan_id == $item->id ? 'selected' : '' }}>({{ $item->nip }}) {{ $item->nama_gurukaryawan }}</option>
                                @endforeach
                            </select>
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                            <label>Jabatan</label>
                            <select class="form-control select2" style="width: 100%" data-dropdown-css-class="select2-danger" id="jabatan_id" name="jabatan_id" required disabled>
                              <option value="">Jabatan</option>
                            </select>
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                            <label>Periode</label>
                            <select class="form-control select2" style="width: 100%" data-dropdown-css-class="select2-danger" id="presensi_karyawan_id" name="presensi_karyawan_id" required disabled>
                                <option value="">Periode</option>
                            </select>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <div class="table-responsive">
                              <table class="table table-bordered w-100">
                                <thead>
                                  <tr>
                                    <th>Jenis</th>
                                    <th>Nominal</th>
                                    <th>Jumlah</th>
                                    <th>Total</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <th>Gaji Pokok</th>
                                    <td><input type="text" id="gaji_pokok" class="form-control" required readonly></td>
                                    <td><input type="text" id="jumlah_gaji_pokok" class="form-control" required readonly value="0"></td>
                                    <td><input type="text" id="total_gaji_pokok" class="form-control" required readonly></td>
                                  </tr>
                                  <tr>
                                    <th>Tunjangan Jabatan</th>
                                    <td><input type="text" id="tunjangan_jabatan" class="form-control" required readonly></td>
                                    <td><input type="text" id="jumlah_tunjangan_jabatan" class="form-control" required readonly value="0"></td>
                                    <td><input type="text" id="total_tunjangan_jabatan" class="form-control" required readonly></td>
                                  </tr>
                                  <tr>
                                    <th>Tunjangan Suami/Istri</th>
                                    <td><input type="text" id="tunjangan_istrisuami" class="form-control" required readonly></td>
                                    <td><input type="text" id="jumlah_tunjangan_istrisuami" class="form-control" required readonly value="0"></td>
                                    <td><input type="text" id="total_tunjangan_istrisuami" class="form-control" required readonly></td>
                                  </tr>
                                  <tr>
                                    <th>Tunjangan Anak</th>
                                    <td><input type="text" id="tunjangan_anak" class="form-control" required readonly></td>
                                    <td><input type="text" id="jumlah_tunjangan_anak" class="form-control" required readonly value="0"></td>
                                    <td><input type="text" id="total_tunjangan_anak" class="form-control" required readonly></td>
                                  </tr>
                                  <tr>
                                    <th>Uang Makan</th>
                                    <td><input type="text" id="uang_makan" class="form-control" required readonly></td>
                                    <td><input type="text" id="jumlah_uang_makan" class="form-control" required readonly value="0"></td>
                                    <td><input type="text" id="total_uang_makan" class="form-control" required readonly></td>
                                  </tr>
                                  <tr>
                                    <th>Uang Lembur</th>
                                    <td><input type="text" id="uang_lembur" class="form-control" required readonly></td>
                                    <td><input type="text" id="jumlah_uang_lembur" class="form-control" required readonly value="0"></td>
                                    <td><input type="text" id="total_uang_lembur" class="form-control" required readonly></td>
                                  </tr>
                                  <tr>
                                    <th>Askes</th>
                                    <td><input type="text" id="askes" class="form-control" required readonly></td>
                                    <td><input type="text" id="jumlah_askes" class="form-control" required readonly value="0"></td>
                                    <td><input type="text" id="total_askes" class="form-control" required readonly></td>
                                  </tr>
                                  <tr>
                                    <th>BPJS</th>
                                    <td><input type="text" id="bpjs" class="form-control" value="{{ $data->potongan_bpjs }}" required readonly></td>
                                    <td><input type="text" id="jumlah_bpjs" class="form-control" required readonly value="1"></td>
                                    <td><input type="text" id="total_bpjs" name="potongan_bpjs" class="form-control" value="{{ $data->potongan_bpjs }}" required readonly></td>
                                  </tr>
                                  <tr>
                                    <th colspan="3" class="text-right">Total Gaji</th>
                                    <td><input type="text" id="gaji_total" name="total_gaji" class="form-control" required readonly></td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                        <div>
                            <a href="{{ route('penggajian.index', ['instansi' => $instansi]) }}" class="btn btn-secondary" type="button">Back</a>
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
@endsection
@section('js')
    <script>
      var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      var data;
      var allowedKeys = ['gaji_pokok', 'tunjangan_jabatan', 'tunjangan_istrisuami', 'tunjangan_anak', 'uang_makan', 'uang_lembur', 'askes'];

      $(document).ready(function(){
        $('#karyawan_id').trigger('change');
        $('#bpjs').val(formatNumber($('#bpjs').val()))
          $(document).on('input', '[id^=bpjs], [id^=jumlah_]', function() {
              let input = $(this);
              let value = input.val();
              
              if (!isNumeric(cleanNumber(value))) {
              value = value.replace(/[^\d]/g, "");
              }

              value = cleanNumber(value);
              let formattedValue = formatNumber(value);
              
              input.val(formattedValue);

              let id = input.attr('id');
              if (id == 'jumlah_bpjs' || id == 'bpjs') {
                  let valueBpjs = cleanNumber($('#bpjs').val()); // Assuming there's an input with ID 'bpjs'
                  let jumlah = cleanNumber($('#jumlah_bpjs').val());
                  $('#total_bpjs').val(formatNumber(valueBpjs * jumlah));
              }

              multiply();
          });
          $('#addForm').on('submit', function(e) {
              let inputs = $('#addForm').find('[id^=gaji_total], [id^=total_bpjs]');
              inputs.each(function() {
                  let input = $(this);
                  let value = input.val();
                  let cleanedValue = cleanNumber(value);

                  input.val(cleanedValue);
              });

              return true;
          });
      })
      $('#karyawan_id').on('change', function() {
          var karyawan_id = $(this).val();
          if (karyawan_id) {
              $.ajax({
                  url: '/findKaryawan', 
                  type: 'GET',
                  data: { karyawan_id: karyawan_id }, 
                  headers: {
                      'X-CSRF-TOKEN': csrfToken
                  },
                  success: function(response) {
                      processData(response);
                  },
                  error: function(xhr, status, error) {
                      console.error('Error:', error);
                  }
              });
          } else {
              resetNominal();
              resetJumlah();
              multiply();
              $('#jumlah_tunjangan_anak').val(0);
          }
      });

      $('#presensi_karyawan_id').on('change', function(){
          if (data) {
              var presensi_id = $(this).val();
              if(presensi_id){
                var selectedPresensi = data.presensi.find(function(item) {
                    return item.id == presensi_id;
                });
                if (selectedPresensi) {
                  $('#jumlah_gaji_pokok').val(1);
                  $('#jumlah_tunjangan_jabatan').val(1);
                  $('#jumlah_tunjangan_istrisuami').val(data.status_kawin == 'Menikah' ? 1 : 0);
                  
                  $('#jumlah_uang_makan').val(1);
                  $('#jumlah_uang_lembur').val(selectedPresensi.lembur);
                  $('#jumlah_askes').val(1);
                }
              } else {
                resetJumlah();
              }
              multiply()
          }
      });

      function processData(responseData) {
          data = responseData;
          if (data) {
              $('#jabatan_id').attr('disabled', true);
              $('#presensi_karyawan_id').attr('disabled', true);
              
              $('#jabatan_id').empty();
              $('#jabatan_id').append('<option value="' + data.jabatan.id + '">' + data.jabatan.jabatan + '</option>');

              allowedKeys.forEach(function(key) {
                  $('#' + key).val(formatNumber(data.jabatan[key]));
              });

              $('#jumlah_tunjangan_anak').val(data.jumlah_anak);

              $('#presensi_karyawan_id').empty();
              $('#presensi_karyawan_id').append('<option value="">Pilih Periode</option>');
              data.presensi.forEach(function(item) {
                  var isSelected = {{ $data->presensi_karyawan_id }} == item.id ? 'selected' : '';
                  $('#presensi_karyawan_id').append('<option value="' + item.id + '"'+isSelected+'>' + item.bulan + ' ' + item.tahun + '</option>');
              });

              $('#presensi_karyawan_id').trigger('change');
          }
      }

      function resetNominal() {
          // Reset UI elements
          $('#jabatan_id').empty();
          $('#jabatan_id').append('<option value="">Jabatan</option>');
          $('#jabatan_id').val('').attr('disabled', true);

          $('#presensi_karyawan_id').empty();
          $('#presensi_karyawan_id').append('<option value="">Periode</option>');
          $('#presensi_karyawan_id').val('').attr('disabled', true);

          allowedKeys.forEach(function(key) {
              $('#' + key).val(0);
          });
      }

      function resetJumlah() {
        $('#jumlah_gaji_pokok').val(0);
        $('#jumlah_tunjangan_jabatan').val(0);
        $('#jumlah_tunjangan_istrisuami').val(0);
        
        $('#jumlah_uang_makan').val(0);
        $('#jumlah_uang_lembur').val(0);
        $('#jumlah_askes').val(0);
      }

      function multiply(){
        allowedKeys.forEach(function(key) {
            var nominal = cleanNumber($('#' + key).val());
            var jumlah = $('#jumlah_' + key).val();
            var total = nominal * jumlah;
            $('#total_' + key).val(formatNumber(total));
        });

        var allTotal = $('[id^=total_]');
        var total_gaji = 0;
        allTotal.each(function() {
            if($(this).attr('id') != 'total_bpjs'){
              total_gaji += parseInt(cleanNumber($(this).val()));
            } else {
              total_gaji -= parseInt(cleanNumber($(this).val()) || 0);
            }
        });
        $('#gaji_total').val(formatNumber(total_gaji));
      }

    </script>
@endsection