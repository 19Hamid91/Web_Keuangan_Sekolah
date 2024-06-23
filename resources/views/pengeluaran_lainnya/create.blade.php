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
                          <div class="col-sm-4">
                            <div class="form-group">
                            <label>Akun</label>
                            <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" id="akun_id" name="akun_id" required>
                              <option value="">Pilih Akun</option>
                                @foreach ($akun as $item)
                                  <option value="{{ $item->id }}">{{ $item->kode }} {{  $item->nama }}</option>
                                @endforeach
                              </select>
                            </div>
                        </div>
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
                            <label>Jenis Pengeluaran</label>
                            <select class="form-control select2" style="width: 100%" data-dropdown-css-class="select2-danger" id="jenis_pengeluaran" name="jenis_pengeluaran" required>
                                <option value="">Pilih Jenis Pengeluaran</option>
                                <option value="Perbaikan Aset">Perbaikan Aset Tetap</option>
                                @if ($instansi == 'tk-kb-tpa')
                                <option value="Outbond">Outbond</option>
                                @endif
                                <option value="Operasional">Operasional</option>
                                <option value="Lainnya">Lainnya</option>
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
                            <div class="col-sm-6">
                              <div class="form-group">
                              <label>Karyawan</label>
                              <select class="form-control select2 operasional" style="width: 100%" data-dropdown-css-class="select2-danger" id="karyawan_id_operasional" name="karyawan_id" required>
                                  <option value="">Pilih Karyawan</option>
                                  @foreach ($karyawan as $item)
                                      <option value="{{ $item->id }}">{{ $item->nama_gurukaryawan }}</option>
                                  @endforeach
                              </select>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                              <label>Jenis</label>
                              <select class="form-control select2 operasional" style="width: 100%" data-dropdown-css-class="select2-danger" id="jenis_operasional" name="jenis" required>
                                  <option value="">Pilih Jenis</option>
                                  <option value="Rapat Bersama">Rapat Bersama                                  </option>
                                  <option value="Kegiatan Siswa Rutin Tahunan">Kegiatan Siswa Rutin Tahunan</option>
                                  <option value="Kegiatan Siswa Rutin Bulanan">Kegiatan Siswa Rutin Bulanan</option>
                                  <option value="Kegiatan Siswa Lainnya">Kegiatan siswa lainnya</option>
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
          displayLainnya(false);
          $(document).on('input', '[id^=harga_], [id^=jumlah_tagihan], #nominal_lainnya', function() {
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
              let inputs = $('#addForm').find('[id^=harga_], [id^=jumlah_tagihan], #nominal_lainnya');
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
              displayLainnya(false);
            } else if($(this).val() == 'Outbond') {
              displayPerbaikan(false);
              displayOutbond(true);
              displayOperasional(false);
              displayLainnya(false);
            } else if($(this).val() == 'Operasional'){
              displayPerbaikan(false);
              displayOutbond(false);
              displayOperasional(true);
              displayLainnya(false);
            } else if($(this).val() == 'Lainnya'){
              displayPerbaikan(false);
              displayOutbond(false);
              displayOperasional(false);
              displayLainnya(true);
            } else {
              displayPerbaikan(false);
              displayOutbond(false);
              displayOperasional(false);
              displayLainnya(false);
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
    </script>
@endsection