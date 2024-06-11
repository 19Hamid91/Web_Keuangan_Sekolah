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
            <h1 class="m-0">Edit Data Pengeluaran Lainnya</h1>
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
                    <form id="addForm" action="{{ route('pengeluaran_lainnya.update', ['instansi' => $instansi, 'id' => $data->id, 'pengeluaran_lainnya' => $pengeluaran_lainnya]) }}" method="post">
                        @csrf
                        @method('patch')
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
                            <select class="form-control select2" style="width: 100%" data-dropdown-css-class="select2-danger" id="jenis_pengeluaran" name="jenis_pengeluaran" required disabled>
                                <option value="">Pilih Jenis Pengeluaran</option>
                                <option value="Perbaikan Aset" {{ $pengeluaran_lainnya == 'Perbaikan Aset' ? 'selected' : '' }}>Perbaikan Aset</option>
                                <option value="Outbond" {{ $pengeluaran_lainnya == 'Outbond' ? 'selected' : '' }}>Outbond</option>
                                <option value="Operasional" {{ $pengeluaran_lainnya == 'Operasional' ? 'selected' : '' }}>Operasional</option>
                            </select>
                            </div>
                          </div>
                        </div>

                        @if($pengeluaran_lainnya == 'Perbaikan Aset')
                        {{-- perbaikan start --}}
                        <div class="div-perbaikan">
                          <div class="row">
                            <div class="col-sm-4">
                              <div class="form-group">
                              <label>Teknisi</label>
                              <select class="form-control select2 perbaikan" style="width: 100%" data-dropdown-css-class="select2-danger" id="teknisi_id_perbaikan" name="teknisi_id">
                                  <option value="">Pilih Teknisi</option>
                                  @foreach ($teknisi as $item)
                                      <option value="{{ $item->id }}" {{ $data->teknisi_id == $item->id ? 'selected' : '' }}>{{ $item->nama }}</option>
                                  @endforeach
                              </select>
                              </div>
                            </div>
                            <div class="col-sm-4">
                              <div class="form-group">
                              <label>Aset</label>
                              <select class="form-control select2 perbaikan" style="width: 100%" data-dropdown-css-class="select2-danger" id="aset_id_perbaikan" name="aset_id">
                                  <option value="">Pilih Aset</option>
                                  @foreach ($aset as $item)
                                      <option value="{{ $item->id }}" {{ $data->aset_id == $item->id ? 'selected' : '' }}>{{ $item->nama_aset }}</option>
                                  @endforeach
                              </select>
                              </div>
                            </div>
                            <div class="col-sm-4">
                              <div class="form-group">
                              <label>Tanggal</label>
                              <input type="date" value="{{ $data->tanggal }}" class="form-control perbaikan" name="tanggal" id="tanggal_perbaikan">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-4">
                              <div class="form-group">
                              <label>Jenis</label>
                              <select class="form-control select2 perbaikan" style="width: 100%" data-dropdown-css-class="select2-danger" id="jenis_perbaikan" name="jenis">
                                  <option value="">Pilih Jenis</option>
                                  <option value="Service" {{ $data->jenis == 'Service' ? 'selected' : '' }}>Service</option>
                              </select>
                              </div>
                            </div>
                            <div class="col-sm-4">
                              <div class="form-group">
                              <label>Harga</label>
                              <input type="text" class="form-control perbaikan" name="harga" id="harga_perbaikan" value="{{ $data->harga }}">
                              </div>
                            </div>
                          </div>
                        </div>
                        {{-- perbaikan end --}}
                        @endif

                        @if($pengeluaran_lainnya == 'Outbond')
                        {{-- outbond start --}}
                        <div class="div-outbond">
                          <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                              <label>Biro</label>
                              <select class="form-control select2 outbond" style="width: 100%" data-dropdown-css-class="select2-danger" id="biro_id_outbond" name="biro_id">
                                  <option value="">Pilih Biro</option>
                                  @foreach ($biro as $item)
                                      <option value="{{ $item->id }}" {{ $data->biro_id == $item->id ? 'selected' : '' }}>{{ $item->nama }}</option>
                                  @endforeach
                              </select>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                              <label>Tanggal Pembayaran</label>
                              <input type="date" value="{{ $data->tanggal_pembayaran }}" class="form-control outbond" name="tanggal_pembayaran" id="tanggal_pembayaran_outbond">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                              <label>Harga Outbond</label>
                              <input type="text" class="form-control outbond" name="harga_outbond" id="harga_outbond" value="{{ $data->harga_outbond }}">
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                              <label>Tanggal Outbond</label>
                              <input type="date" value="{{ $data->tanggal_outbond }}" class="form-control outbond" name="tanggal_outbond" id="tanggal_outbond">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                              <label>Tempat Outbond</label>
                              <textarea class="form-control outbond" name="tempat_outbond" id="tempat_outbond">{{ $data->tempat_outbond }}</textarea>
                              </div>
                            </div>
                          </div>
                        </div>
                        {{-- outbond end --}}
                        @endif

                        @if($pengeluaran_lainnya == 'Operasional')
                        {{-- operasional start --}}
                        <div class="div-operasional">
                          <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                              <label>Karyawan</label>
                              <select class="form-control select2 operasional" style="width: 100%" data-dropdown-css-class="select2-danger" id="karyawan_id_operasional" name="karyawan_id">
                                  <option value="">Pilih Karyawan</option>
                                  @foreach ($karyawan as $item)
                                      <option value="{{ $item->id }}" {{ $data->karyawan_id == $item->id ? 'selected' : '' }}>{{ $item->nama_gurukaryawan }}</option>
                                  @endforeach
                              </select>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                              <label>Jenis</label>
                              <select class="form-control select2 operasional" style="width: 100%" data-dropdown-css-class="select2-danger" id="jenis_operasional" name="jenis">
                                  <option value="">Pilih Jenis</option>
                                  <option value="Rapat Bersama" {{ $data->jenis == 'Rapat Bersama' ? 'selected' : '' }}>Rapat Bersama                                  </option>
                                  <option value="Kegiatan Siswa Rutin Tahunan" {{ $data->jenis == 'Kegiatan Siswa Rutin Tahunan' ? 'selected' : '' }}>Kegiatan Siswa Rutin Tahunan</option>
                                  <option value="Kegiatan Siswa Rutin Bulanan" {{ $data->jenis == 'Kegiatan Siswa Rutin Bulanan' ? 'selected' : '' }}>Kegiatan Siswa Rutin Bulanan</option>
                                  <option value="Kegiatan Siswa Lainnya" {{ $data->jenis == 'Kegiatan Siswa Lainnya' ? 'selected' : '' }}>Kegiatan siswa lainnya</option>
                                  </select>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                              <label>Tanggal Pembayaran</label>
                              <input type="date" value="{{ $data->tanggal_pembayaran }}" class="form-control operasional" name="tanggal_pembayaran" id="tanggal_pembayaran_operasional">
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                              <label>Jumlah Tagihan</label>
                              <input type="text" value="{{ $data->jumlah_tagihan }}" class="form-control operasional" name="jumlah_tagihan" id="jumlah_tagihan_operasional">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label>Keterangan</label>
                                <textarea name="keterangan" id="keterangan" class="form-control">{{ $data->keterangan }}</textarea>
                              </div>
                            </div>
                          </div>
                        </div>
                        {{-- operasional end --}}
                        @endif

                        <div>
                            <a href="{{ route('pengeluaran_lainnya.index', ['instansi' => $instansi]) }}" class="btn btn-secondary" type="button">Back</a>
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
          $('#jenis_pengeluaran').trigger('change')
          $('[id^=harga_], [id^=jumlah_tagihan_operasional]').each(function(){
              let input = $(this);
              let value = input.val();
              let formattedValue = formatNumber(value);

              input.val(formattedValue);
          })
          $(document).on('input', '[id^=harga_], [id^=jumlah_tagihan]', function() {
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
              let inputs = $('#addForm').find('[id^=harga_], [id^=jumlah_tagihan]');
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
              console.log('aset')
              displayPerbaikan(true);
              displayOutbond(false);
              displayOperasional(false);
            } else if($(this).val() == 'Outbond') {
              console.log('out')
              displayPerbaikan(false);
              displayOutbond(true);
              displayOperasional(false);
            } else if($(this).val() == 'Lainnya'){
              console.log('lain')
              displayPerbaikan(false);
              displayOutbond(false);
              displayOperasional(true);
            } else {
              console.log('else')
              displayPerbaikan(false);
              displayOutbond(false);
              displayOperasional(false);
            }
          })
      });

      function displayPerbaikan(isShow) {
          $('.div-perbaikan').toggle(isShow);
          if (isShow) {
              $('.perbaikan').removeAttr('disabled');
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
          } else {
              var operasionalLength = $('.operasional').length;
              $('.operasional').each(function(index, element) {
                  $(element).attr('disabled', true);
              });
          }
      }
    </script>
@endsection