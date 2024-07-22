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
            <h1 class="m-0">Tambah Data Pengeluaran Lainnya</h1>
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
                    <form id="addForm" action="{{ route('pengeluaran_lainnya.store', ['instansi' => $instansi]) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <h3 class="text-center font-weight-bold">Data Pengeluaran Lainnya</h3>
                        <br><br>
                        <div class="row">
                          <div class="col-sm-6">
                            <div class="form-group">
                            <label>Instansi</label>
                            <select class="form-control select2" style="width: 100%" data-dropdown-css-class="select2-danger" id="instansi_id" name="instansi_id" required>
                                <option value="{{ $data_instansi->id }}" {{ old('instansi_id') == $data_instansi->id ? 'selected' : '' }}>{{ $data_instansi->nama_instansi }}</option>
                            </select>
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="form-group">
                            <label>Jenis Pengeluaran</label>
                            <select class="form-control select2" style="width: 100%" data-dropdown-css-class="select2-danger" id="jenis_pengeluaran" name="jenis_pengeluaran" required>
                                <option value="">Pilih Jenis Pengeluaran</option>
                                <option value="Perbaikan Aset" {{ old('jenis_pengeluaran') == 'Perbaikan Aset' ? 'selected' : '' }}>Perbaikan Aset Tetap</option>
                                @if ($instansi == 'tk-kb-tpa')
                                <option value="Outbond" {{ old('jenis_pengeluaran') == 'Outbond' ? 'selected' : '' }}>Outbond</option>
                                @elseif($instansi == 'yayasan')
                                <option value="Transport" {{ old('jenis_pengeluaran') == 'Transport' ? 'selected' : '' }}>Transport</option>
                                <option value="Honor Dokter" {{ old('jenis_pengeluaran') == 'Honor Dokter' ? 'selected' : '' }}>Honor Dokter</option>
                                @endif
                                <option value="Operasional" {{ old('jenis_pengeluaran') == 'Operasional' ? 'selected' : '' }}>Operasional</option>
                                <option value="Lainnya" {{ old('jenis_pengeluaran') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            </div>
                          </div>
                        </div>

                        {{-- perbaikan start --}}
                        <div class="div-perbaikan">
                          <div class="row">
                            <div class="col-sm-4">
                              <div class="form-group">
                              <label>Teknisi</label>
                              <select class="form-control select2 perbaikan" style="width: 100%" data-dropdown-css-class="select2-danger" id="teknisi_id_perbaikan" name="teknisi_id" required>
                                  <option value="">Pilih Teknisi</option>
                                  @foreach ($teknisi as $item)
                                      <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                  @endforeach
                              </select>
                              </div>
                            </div>
                            <div class="col-sm-4">
                              <div class="form-group">
                              <label>Aset Tetap</label>
                              <select class="form-control select2 perbaikan" style="width: 100%" data-dropdown-css-class="select2-danger" id="aset_id_perbaikan" name="aset_id" required>
                                  <option value="">Pilih Aset Tetap</option>
                                  @foreach ($aset as $item)
                                      <option value="{{ $item->id }}">{{ $item->nama_aset }}</option>
                                  @endforeach
                              </select>
                              </div>
                            </div>
                            <div class="col-sm-4">
                              <div class="form-group">
                              <label>Tanggal</label>
                              <input type="date" value="{{ date('Y-m-d') }}" class="form-control perbaikan" name="tanggal" id="tanggal_perbaikan" required>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-4">
                              <div class="form-group">
                              <label>Jenis</label>
                              <select class="form-control select2 perbaikan" style="width: 100%" data-dropdown-css-class="select2-danger" id="jenis_perbaikan" name="jenis" required>
                                  <option value="">Pilih Jenis</option>
                                  <option value="Service">Service</option>
                              </select>
                              </div>
                            </div>
                            <div class="col-sm-4">
                              <div class="form-group">
                              <label>Harga</label>
                              <input type="text" class="form-control perbaikan" name="harga" id="harga_perbaikan" required>
                              </div>
                            </div>
                          </div>
                        </div>
                        {{-- perbaikan end --}}


                        {{-- outbond start --}}
                        <div class="div-outbond">
                          <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                              <label>Biro</label>
                              <select class="form-control select2 outbond" style="width: 100%" data-dropdown-css-class="select2-danger" id="biro_id_outbond" name="biro_id" required>
                                  <option value="">Pilih Biro</option>
                                  @foreach ($biro as $item)
                                      <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                  @endforeach
                              </select>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                              <label>Tanggal Pembayaran</label>
                              <input type="date" value="{{ date('Y-m-d') }}" class="form-control outbond" name="tanggal_pembayaran" id="tanggal_pembayaran_outbond" required>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                              <label>Harga Outbond</label>
                              <input type="text" class="form-control outbond" name="harga_outbond" id="harga_outbond" required>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                              <label>Tanggal Outbond</label>
                              <input type="date" value="{{ date('Y-m-d') }}" class="form-control outbond" name="tanggal_outbond" id="tanggal_outbond" required>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                              <label>Tempat Outbond</label>
                              <textarea class="form-control outbond" name="tempat_outbond" id="tempat_outbond" required></textarea>
                              </div>
                            </div>
                          </div>
                        </div>
                        {{-- outbond end --}}


                        {{-- operasional start --}}
                        <div class="div-operasional">
                          <div class="row">
                            @if($instansi != 'yayasan')
                            <div class="col-sm-6">
                              <div class="form-group">
                              <label>PJ Kegiatan</label>
                              <select class="form-control select2 operasional" style="width: 100%" data-dropdown-css-class="select2-danger" id="karyawan_id_operasional" name="karyawan_id" required>
                                  <option value="">Pilih Karyawan</option>
                                  @foreach ($karyawan as $item)
                                      <option value="{{ $item->id }}">{{ $item->nama_gurukaryawan }}</option>
                                  @endforeach
                              </select>
                              </div>
                            </div>
                            @else
                            <div class="col-sm-6">
                              <div class="form-group">
                              <label>Utilitas</label>
                              <select class="form-control select2 operasional" style="width: 100%" data-dropdown-css-class="select2-danger" id="utilitas_id_operasional" name="karyawan_id" required>
                                  <option value="">Pilih Utilitas</option>
                                  @foreach ($utilitas as $item)
                                      <option value="{{ $item->id }}" {{ old('karyawan_id') == $item->id ? 'selected' : '' }}>{{ $item->nama }}</option>
                                  @endforeach
                              </select>
                              </div>
                            </div>
                            @endif
                            <div class="col-sm-6">
                              <div class="form-group">
                              <label>Jenis Operasional</label>
                              <select class="form-control select2 operasional" style="width: 100%" data-dropdown-css-class="select2-danger" id="jenis_operasional" name="jenis" required>
                                  <option value="">Pilih Jenis</option>
                                  @if($instansi != 'yayasan')
                                  <option value="Rapat Bersama">Rapat Bersama</option>
                                  <option value="Kegiatan Siswa Rutin Tahunan">Kegiatan Siswa Rutin Tahunan</option>
                                  <option value="Kegiatan Siswa Rutin Bulanan">Kegiatan Siswa Rutin Bulanan</option>
                                  <option value="Kegiatan Siswa Lainnya">Kegiatan siswa lainnya</option>
                                  @endif
                                  <option value="Listrik">Listrik</option>
                                  <option value="Air">Air</option>
                                  <option value="Telpon dan Internet">Telpon dan Internet</option>
                                  </select>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                              <label>Tanggal Pembayaran</label>
                              <input type="date" value="{{ date('Y-m-d') }}" class="form-control operasional" name="tanggal_pembayaran" id="tanggal_pembayaran_operasional" required>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                              <label>Jumlah Tagihan</label>
                              <input type="text" value="" class="form-control operasional" name="jumlah_tagihan" id="jumlah_tagihan_operasional" required>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label>Keterangan</label>
                                <textarea name="keterangan" id="keterangan_operasional" class="form-control operasional" required></textarea>
                              </div>
                            </div>
                          </div>
                        </div>
                        {{-- operasional end --}}


                        {{-- transport start --}}
                        <div class="div-transport">
                          <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                              <label>Nama</label>
                              <select class="form-control select2 transport" style="width: 100%" data-dropdown-css-class="select2-danger" id="pengurus_id_lainnya" name="pengurus_id" required>
                                <option value="">Pilih Pengurus</option>
                                @foreach ($pengurus as $item)
                                @if($item->jabatan != 'Dokter Klinik')
                                    <option value="{{ $item->id }}" {{ old('pengurus_id') == $item->id ? 'selected' : '' }}>{{ $item->nama_pengurus }}</option>
                                @endif
                                @endforeach
                              </select>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                              <label>Tanggal</label>
                              <input type="date" value="{{ date('Y-m-d') }}" class="form-control transport" name="tanggal" id="tanggal_transport" required>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                              <label>Nominal</label>
                              <input type="text" value="" class="form-control transport" name="nominal" id="nominal_transport" required>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label>Keterangan</label>
                                <textarea name="keterangan" id="keterangan_transport" class="form-control transport" required></textarea>
                              </div>
                            </div>
                          </div>
                        </div>
                        {{-- transport end --}}


                        {{-- honor_dokter start --}}
                        <div class="div-honor_dokter">
                          <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                              <label>Nama</label>
                              <select class="form-control select2 honor_dokter" style="width: 100%" data-dropdown-css-class="select2-danger" id="pengurus_id_honor_dokter" name="pengurus_id" required>
                                <option value="">Pilih Pengurus</option>
                                @foreach ($pengurus as $item)
                                @if($item->jabatan == 'Dokter Klinik')
                                    <option value="{{ $item->id }}" {{ old('pengurus_id') == $item->id ? 'selected' : '' }}>{{ $item->nama_pengurus }}</option>
                                @endif
                                @endforeach
                              </select>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                              <label>Tanggal</label>
                              <input type="date" value="{{ date('Y-m-d') }}" class="form-control honor_dokter" name="tanggal" id="tanggal_honor_dokter" required>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                              <label>Total Jam Kerja</label>
                              <input type="text" value="{{ old('total_jam_kerja') }}" class="form-control honor_dokter" name="total_jam_kerja" id="total_jam_kerja_honor_dokter" required oninput="calculateHonor()">
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label>Honor Harian</label>
                                <input type="text" name="honor_harian" id="honor_harian_honor_dokter" class="form-control honor_dokter" value="{{ old('honor_harian') }}" required oninput="calculateHonor()">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                              <label>Total Honor</label>
                              <input type="text" value="{{ old('total_honor') }}" class="form-control honor_dokter" name="total_honor" id="total_honor_honor_dokter" readonly required>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label>Keterangan</label>
                                <textarea name="keterangan" id="keterangan_honor_dokter" class="form-control honor_dokter" required>{{ old('keterangan') }}</textarea>
                              </div>
                            </div>
                          </div>
                        </div>
                        {{-- honor_dokter end --}}


                        {{-- lainnya start --}}
                        <div class="div-lainnya">
                          <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                              <label>Nama</label>
                              <input type="text" value="" class="form-control lainnya" name="nama" id="nama_lainnya" required>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                              <label>Tanggal</label>
                              <input type="date" value="{{ date('Y-m-d') }}" class="form-control lainnya" name="tanggal" id="tanggal_lainnya" required>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                              <label>Nominal</label>
                              <input type="text" value="" class="form-control lainnya" name="nominal" id="nominal_lainnya" required>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label>Keterangan</label>
                                <textarea name="keterangan" id="keterangan_lainnya" class="form-control lainnya" required></textarea>
                              </div>
                            </div>
                          </div>
                        </div>
                        {{-- lainnya end --}}

                        <div class="row mb-3">
                          <div class="col-sm-6">
                              <label>Bukti <a href="javascript:void(0)" id="clearFile" class="text-danger" onclick="clearFile()" title="Clear Image">clear</a>
                              </label>
                                <input type="file" id="bukti" class="form-control" name="file" accept="image/*">
                              <p class="text-danger">max 2mb</p>
                              <img id="preview" src="" alt="Preview" style="max-width: 40%;"/>
                          </div>
                          <div class="col-sm-6" id="divAkun">
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
                        <div>
                            <a href="{{ route('pengeluaran_lainnya.index', ['instansi' => $instansi]) }}" class="btn btn-secondary" type="button">Batal</a>
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
          displayPerbaikan(false);
          displayOutbond(false);
          displayOperasional(false);
          displayTransport(false);
          displayHonorDokter(false);
          displayLainnya(false);
          $(document).on('input', '[id^=harga_], [id^=jumlah_tagihan], #nominal_lainnya, #nominal_transport, [id^=total_], #honor_harian_honor_dokter', function() {
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
              let inputs = $('#addForm').find('[id^=harga_], [id^=jumlah_tagihan], #nominal_lainnya, #nominal_transport, [id^=total_], #honor_harian_honor_dokter, [id^=total], [id^=debit-], [id^=kredit-]');
              inputs.each(function() {
                  let input = $(this);
                  let value = input.val();
                  let cleanedValue = cleanNumber(value);

                  input.val(cleanedValue);
              });

              return true;
          });

          $(document).on('change', '#jenis_pengeluaran', function(){
            if($(this).val() == 'Perbaikan Aset') {
              displayPerbaikan(true);
              displayOutbond(false);
              displayOperasional(false);
              displayTransport(false);
              displayHonorDokter(false);
              displayLainnya(false);
              displayAkun(true);
            } else if($(this).val() == 'Outbond') {
              displayPerbaikan(false);
              displayOutbond(true);
              displayOperasional(false);
              displayTransport(false);
              displayHonorDokter(false);
              displayLainnya(false);
              displayAkun(true);
            } else if($(this).val() == 'Operasional'){
              displayPerbaikan(false);
              displayOutbond(false);
              displayOperasional(true);
              displayTransport(false);
              displayHonorDokter(false);
              displayLainnya(false);
              displayAkun(true);
            } else if($(this).val() == 'Transport'){
              displayPerbaikan(false);
              displayOutbond(false);
              displayOperasional(false);
              displayTransport(true);
              displayHonorDokter(false);
              displayLainnya(false);
              displayAkun(false);
            } else if($(this).val() == 'Honor Dokter'){
              displayPerbaikan(false);
              displayOutbond(false);
              displayOperasional(false);
              displayTransport(false);
              displayHonorDokter(true);
              displayLainnya(false);
              displayAkun(false);
            } else if($(this).val() == 'Lainnya'){
              displayPerbaikan(false);
              displayOutbond(false);
              displayOperasional(false);
              displayTransport(false);
              displayHonorDokter(false);
              displayLainnya(true);
              displayAkun(true);
            } else {
              displayPerbaikan(false);
              displayOutbond(false);
              displayOperasional(false);
              displayTransport(false);
              displayHonorDokter(false);
              displayLainnya(false);
              displayAkun(false);
            }
          })
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

      function displayPerbaikan(isShow) {
          $('.div-perbaikan').toggle(isShow);
          if (isShow) {
              $('.perbaikan').removeAttr('disabled');
              $('.perbaikan').attr('required');
          } else {
              var perbaikanLength = $('.perbaikan').length;
              $('.perbaikan').each(function(index, element) {
                  $(element).attr('disabled', true);
              });
          }
      }

      function displayOutbond(isShow) {
          $('.div-outbond').toggle(isShow);
          if (isShow) {
              $('.outbond').removeAttr('disabled');
              $('.outbond').attr('required');
          } else {
              var outbondLength = $('.outbond').length;
              $('.outbond').each(function(index, element) {
                  $(element).attr('disabled', true);
              });
          }
      }

      function displayOperasional(isShow) {
          $('.div-operasional').toggle(isShow);
          if (isShow) {
              $('.operasional').removeAttr('disabled');
              $('.operasional').attr('required');
          } else {
              var operasionalLength = $('.operasional').length;
              $('.operasional').each(function(index, element) {
                  $(element).attr('disabled', true);
              });
          }
      }

      function displayTransport(isShow) {
          $('.div-transport').toggle(isShow);
          if (isShow) {
              $('.transport').removeAttr('disabled');
              $('.transport').attr('required');
          } else {
              var transportLength = $('.transport').length;
              $('.transport').each(function(index, element) {
                  $(element).attr('disabled', true);
              });
          }
      }

      function displayHonorDokter(isShow) {
          $('.div-honor_dokter').toggle(isShow);
          if (isShow) {
              $('.honor_dokter').removeAttr('disabled');
              $('.honor_dokter').attr('required');
          } else {
              var honor_dokterLength = $('.honor_dokter').length;
              $('.honor_dokter').each(function(index, element) {
                  $(element).attr('disabled', true);
              });
          }
      }

      function displayLainnya(isShow) {
          $('.div-lainnya').toggle(isShow);
          if (isShow) {
              $('.lainnya').removeAttr('disabled');
              $('.lainnya').attr('required');
          } else {
              var lainnyaLength = $('.lainnya').length;
              $('.lainnya').each(function(index, element) {
                  $(element).attr('disabled', true);
                  $(element).attr('disabled', true);
              });
          }
      }

      function displayAkun(isShow){
        $('#divAkun').toggle(isShow);
        if(isShow){
          $('#divAkun select').attr('disabled', false);
        } else {
          $('#divAkun select').attr('disabled', true);
        }
      }

      function calculateHonor(){
        var jam = cleanNumber($('#total_jam_kerja_honor_dokter').val());
        var harian = cleanNumber($('#honor_harian_honor_dokter').val());
        $('#total_honor_honor_dokter').val(formatNumber((jam * harian)));
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