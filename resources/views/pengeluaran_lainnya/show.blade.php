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
            <h1 class="m-0">Detail Data Pengeluaran Lainnya</h1>
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
                    <h3 class="text-center font-weight-bold">Data Pengeluaran Lainnya</h3>
                    <br><br>
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                        <label>Instansi</label>
                        <select class="form-control select2" style="width: 100%" data-dropdown-css-class="select2-danger" id="instansi_id" name="instansi_id" disabled>
                            <option value="{{ $data_instansi->id }}" {{ old('instansi_id') == $data_instansi->id ? 'selected' : '' }}>{{ $data_instansi->nama_instansi }}</option>
                        </select>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                        <label>Jenis Pengeluaran</label>
                        <select class="form-control select2" style="width: 100%" data-dropdown-css-class="select2-danger" id="jenis_pengeluaran" name="jenis_pengeluaran" disabled>
                            <option value="">Pilih Jenis Pengeluaran</option>
                            <option value="Perbaikan Aset" {{ $pengeluaran_lainnya == 'Perbaikan Aset' ? 'selected' : '' }}>Perbaikan Aset Tetap</option>
                            <option value="Outbond" {{ $pengeluaran_lainnya == 'Outbond' ? 'selected' : '' }}>Outbond</option>
                            <option value="Transport" {{ $pengeluaran_lainnya == 'Transport' ? 'selected' : '' }}>Transport</option>
                            <option value="Honor Dokter" {{ $pengeluaran_lainnya == 'Honor Dokter' ? 'selected' : '' }}>Honor Dokter</option>
                            <option value="Operasional" {{ $pengeluaran_lainnya == 'Operasional' ? 'selected' : '' }}>Operasional</option>
                            <option value="Pemasukan Yayasan" {{ $pengeluaran_lainnya == 'Pemasukan Yayasan' ? 'selected' : '' }}>Pemasukan Yayasan</option>
                            <option value="Lainnya" {{ $pengeluaran_lainnya == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
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
                          <select class="form-control select2 perbaikan" style="width: 100%" data-dropdown-css-class="select2-danger" id="teknisi_id_perbaikan" name="teknisi_id" disabled>
                              <option value="">Pilih Teknisi</option>
                              @foreach ($teknisi as $item)
                                  <option value="{{ $item->id }}" {{ $data->teknisi_id == $item->id ? 'selected' : '' }}>{{ $item->nama }}</option>
                              @endforeach
                          </select>
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="form-group">
                          <label>Aset Tetap</label>
                          <select class="form-control select2 perbaikan" style="width: 100%" data-dropdown-css-class="select2-danger" id="aset_id_perbaikan" name="aset_id" disabled>
                              <option value="">Pilih Aset Tetap</option>
                              @foreach ($aset as $item)
                                  <option value="{{ $item->id }}" {{ $data->aset_id == $item->id ? 'selected' : '' }}>{{ $item->nama_aset }}</option>
                              @endforeach
                          </select>
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="form-group">
                          <label>Tanggal</label>
                          <input type="date" value="{{ $data->tanggal }}" class="form-control perbaikan" name="tanggal" id="tanggal_perbaikan" disabled>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-4">
                          <div class="form-group">
                          <label>Jenis</label>
                          <select class="form-control select2 perbaikan" style="width: 100%" data-dropdown-css-class="select2-danger" id="jenis_perbaikan" name="jenis" disabled>
                              <option value="">Pilih Jenis</option>
                              <option value="Service" {{ $data->jenis == 'Service' ? 'selected' : '' }}>Service</option>
                          </select>
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="form-group">
                          <label>Harga</label>
                          <input type="text" class="form-control text-right perbaikan" name="harga" id="harga_perbaikan" value="{{ $data->harga }}" disabled>
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
                          <select class="form-control select2 outbond" style="width: 100%" data-dropdown-css-class="select2-danger" id="biro_id_outbond" name="biro_id" disabled>
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
                          <input type="date" value="{{ $data->tanggal_pembayaran }}" class="form-control outbond" name="tanggal_pembayaran" id="tanggal_pembayaran_outbond" disabled>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="form-group">
                          <label>Harga Outbond</label>
                          <input type="text" class="form-control text-right outbond" name="harga_outbond" id="harga_outbond" value="{{ $data->harga_outbond }}" disabled>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                          <label>Tanggal Outbond</label>
                          <input type="date" value="{{ $data->tanggal_outbond }}" class="form-control outbond" name="tanggal_outbond" id="tanggal_outbond" disabled>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="form-group">
                          <label>Tempat Outbond</label>
                          <textarea class="form-control outbond" name="tempat_outbond" id="tempat_outbond" disabled>{{ $data->tempat_outbond }}</textarea>
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
                        @if($instansi != 'yayasan')
                        <div class="col-sm-6">
                          <div class="form-group">
                          <label>PJ Kegiatan</label>
                          <select class="form-control select2 operasional" style="width: 100%" data-dropdown-css-class="select2-danger" id="karyawan_id_operasional" name="karyawan_id" disabled>
                              <option value="">Pilih Karyawan</option>
                              @foreach ($karyawan as $item)
                                  <option value="{{ $item->id }}" {{ $data->karyawan_id == $item->id ? 'selected' : '' }}>{{ $item->nama_gurukaryawan }}</option>
                              @endforeach
                          </select>
                          </div>
                        </div>
                        @else
                            <div class="col-sm-6">
                              <div class="form-group">
                              <label>Utilitas</label>
                              <select class="form-control select2 operasional" style="width: 100%" data-dropdown-css-class="select2-danger" id="utilitas_id_operasional" name="karyawan_id" disabled>
                                  <option value="">Pilih Utilitas</option>
                                  @foreach ($utilitas as $item)
                                      <option value="{{ $item->id }}" {{ $data->karyawan_id == $item->id ? 'selected' : '' }}>{{ $item->nama }}</option>
                                  @endforeach
                              </select>
                              </div>
                            </div>
                            @endif
                        <div class="col-sm-6">
                          <div class="form-group">
                          <label>Jenis Operasional</label>
                          <select class="form-control select2 operasional" style="width: 100%" data-dropdown-css-class="select2-danger" id="jenis_operasional" name="jenis" disabled>
                            <option value="">Pilih Jenis</option>
                            @if($instansi != 'yayasan')
                            <option value="Rapat Bersama" {{ $data->jenis == 'Rapat Bersama' ? 'selected' : '' }}>Rapat Bersama                                  </option>
                            <option value="Kegiatan Siswa Rutin Tahunan" {{ $data->jenis == 'Kegiatan Siswa Rutin Tahunan' ? 'selected' : '' }}>Kegiatan Siswa Rutin Tahunan</option>
                            <option value="Kegiatan Siswa Rutin Bulanan" {{ $data->jenis == 'Kegiatan Siswa Rutin Bulanan' ? 'selected' : '' }}>Kegiatan Siswa Rutin Bulanan</option>
                            <option value="Kegiatan Siswa Lainnya" {{ $data->jenis == 'Kegiatan Siswa Lainnya' ? 'selected' : '' }}>Kegiatan siswa lainnya</option>
                            @else
                            <option value="Listrik" {{ $data->jenis == 'Listrik' ? 'selected' : '' }}>Listrik</option>
                            <option value="Air" {{ $data->jenis == 'Air' ? 'selected' : '' }}>Air</option>
                            <option value="Telpon dan Internet" {{ $data->jenis == 'Telpon dan Internet' ? 'selected' : '' }}>Telpon dan Internet</option>
                            @endif
                              </select>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="form-group">
                          <label>Tanggal Pembayaran</label>
                          <input type="date" value="{{ $data->tanggal_pembayaran }}" class="form-control operasional" name="tanggal_pembayaran" id="tanggal_pembayaran_operasional" disabled>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                          <label>Jumlah Tagihan</label>
                          <input type="text" value="{{ $data->jumlah_tagihan }}" class="form-control text-right operasional" name="jumlah_tagihan" id="jumlah_tagihan_operasional" disabled>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>Keterangan</label>
                            <textarea name="keterangan" id="keterangan" class="form-control" disabled>{{ $data->keterangan }}</textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                    {{-- operasional end --}}
                    @endif

                    @if($pengeluaran_lainnya == 'Transport')
                        {{-- transport start --}}
                        <div class="div-transport">
                          <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                              <label>Nama</label>
                              <select class="form-control select2 transport" style="width: 100%" data-dropdown-css-class="select2-danger" id="pengurus_id_lainnya" name="pengurus_id" disabled>
                                <option value="">Pilih Pengurus</option>
                                @foreach ($pengurus as $item)
                                    <option value="{{ $item->id }}" {{ $data->pengurus_id == $item->id ? 'selected' : '' }}>{{ $item->nama_pengurus }}</option>
                                @endforeach
                              </select>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                              <label>Tanggal</label>
                              <input type="date" value="{{ $data->tanggal }}" class="form-control transport" name="tanggal" id="tanggal_transport" disabled>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                              <label>Nominal</label>
                              <input type="text" value="{{ $data->nominal }}" class="form-control text-right transport" name="nominal" id="nominal_transport" disabled>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label>Keterangan</label>
                                <textarea name="keterangan" id="keterangan_transport" class="form-control transport" disabled>{{ $data->keterangan }}</textarea>
                              </div>
                            </div>
                          </div>
                        </div>
                        {{-- transport end --}}
                    @endif

                    @if ($pengeluaran_lainnya == 'Honor Dokter')
                        {{-- honor_dokter start --}}
                        <div class="div-honor_dokter">
                          <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                              <label>Nama</label>
                              <select class="form-control select2 honor_dokter" style="width: 100%" data-dropdown-css-class="select2-danger" id="pengurus_id_lainnya" name="pengurus_id" disabled>
                                <option value="">Pilih Pengurus</option>
                                @foreach ($pengurus as $item)
                                @if($item->jabatan == 'Dokter Klinik')
                                    <option value="{{ $item->id }}" {{ $data->pengurus_id == $item->id ? 'selected' : '' }}>{{ $item->nama_pengurus }}</option>
                                @endif
                                @endforeach
                              </select>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                              <label>Tanggal</label>
                              <input type="date" value="{{$data->tanggal }}" class="form-control honor_dokter" name="tanggal" id="tanggal_honor_dokter" disabled>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                              <label>Total Jam Kerja</label>
                              <input type="text" value="{{ $data->total_jam_kerja }}" class="form-control honor_dokter" name="total_jam_kerja" id="total_jam_kerja_honor_dokter" disabled oninput="calculateHonor()">
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label>Honor Harian</label>
                                <input type="text" name="honor_harian" id="honor_harian_honor_dokter" class="form-control text-right honor_dokter" value="{{ $data->honor_harian }}" disabled oninput="calculateHonor()">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                              <label>Total Honor</label>
                              <input type="text" value="{{ $data->total_honor }}" class="form-control text-right honor_dokter" name="total_honor" id="total_honor_honor_dokter" readonly disabled>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label>Keterangan</label>
                                <textarea name="keterangan" id="keterangan_honor_dokter" class="form-control honor_dokter" disabled>{{ $data->keterangan }}</textarea>
                              </div>
                            </div>
                          </div>
                        </div>
                        {{-- honor_dokter end --}}
                    @endif

                    @if($pengeluaran_lainnya == 'Pemasukan Yayasan')
                        {{-- yayasan start --}}
                        <div class="div-yayasan">
                          <div class="row">
                            <div class="col-sm-4">
                              <div class="form-group">
                              <label>Nama</label>
                              <input type="text" class="form-control yayasan" name="nama" id="nama_yayasan" value="{{$data->nama ?? '' }}" disabled>
                              </div>
                            </div>
                            <div class="col-sm-4">
                              <div class="form-group">
                              <label>Tanggal</label>
                              <input type="date" value="{{ $data->tanggal }}" class="form-control yayasan" name="tanggal" id="tanggal_yayasan" disabled>
                              </div>
                            </div>
                            <div class="col-sm-4">
                              <div class="form-group">
                              <label>Jenis</label>
                              <select class="form-control select2 yayasan" style="width: 100%" data-dropdown-css-class="select2-danger" id="jenis_yayasan" name="jenis" disabled>
                                  <option value="SPP" {{ $data->jenis == 'SPP' ? 'selected' : '' }}>SPP</option>
                                  <option value="JPI" {{ $data->jenis == 'JPI' ? 'selected' : '' }}>JPI</option>
                              </select>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                              <label>Nominal</label>
                              <input type="text" value="{{ $data->total ?? '' }}" class="form-control text-right yayasan" name="total" id="total_yayasan" disabled>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label>Keterangan</label>
                                <textarea name="keterangan" id="keterangan_yayasan" class="form-control yayasan" disabled>{{ $data->keterangan ?? '' }}</textarea>
                              </div>
                            </div>
                          </div>
                        </div>
                        {{-- yayasan end --}}
                        @endif

                    @if($pengeluaran_lainnya == 'Lainnya')
                        {{-- lainnya start --}}
                        <div class="div-lainnya">
                          <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                              <label>Nama</label>
                              <input type="text" value="{{ $data->nama }}" class="form-control lainnya" name="nama" id="nama_lainnya" disabled>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                              <label>Tanggal</label>
                              <input type="date" value="{{ $data->tanggal }}" class="form-control lainnya" name="tanggal" id="tanggal_lainnya" disabled>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                              <label>Nominal</label>
                              <input type="text" value="{{ $data->nominal }}" class="form-control text-right lainnya" name="nominal" id="nominal_lainnya" disabled>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label>Keterangan</label>
                                <textarea name="keterangan" id="keterangan" class="form-control" disabled>{{ $data->keterangan }}</textarea>
                              </div>
                            </div>
                          </div>
                        </div>
                        {{-- lainnya end --}}
                        @endif
                        <div class="row mb-3">
                          <div class="col-sm-6">
                              <label>Bukti <a href="javascript:void(0)" id="clearFile" class="text-danger" onclick="clearFile()" title="Clear Image">clear</a>
                              </label>
                                <input type="file" id="bukti" class="form-control" name="file" accept="image/*" disabled>
                              <p class="text-danger">max 2mb</p>
                              <img id="preview" src="{{ $data->file ? '/storage/' . $data->file : '' }}" alt="Preview" style="max-width: 40%;"/>
                          </div>
                        </div>

                    <div>
                        <a href="{{ route('pengeluaran_lainnya.index', ['instansi' => $instansi]) }}" class="btn btn-secondary" type="button">Batal</a>
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
      $(document).ready(function(){
          if ($('#preview').attr('src') === '') {
              $('#preview').attr('src', defaultImg);
          }
          $('#jenis_pengeluaran').trigger('change')
          $('[id^=harga_], [id^=jumlah_tagihan], #nominal_lainnya, #nominal_transport, [id^=total_], #honor_harian_honor_dokter, #total_yayasan').each(function(){
              let input = $(this);
              let value = input.val();
              let formattedValue = formatNumber(value);

              input.val(formattedValue);
          })
          $(document).on('input', '[id^=harga_], [id^=jumlah_tagihan], #nominal_lainnya, #nominal_transport, #total_yayasan', function() {
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

          $(document).on('change', '#jenis_pengeluaran', function(){
            if($(this).val() == 'Perbaikan Aset') {
              displayPerbaikan(true);
              displayOutbond(false);
              displayOperasional(false);
              displayTransport(false);
              displayHonorDokter(false);
              displayLainnya(false);
              displayYayasan(false);
            } else if($(this).val() == 'Outbond') {
              displayPerbaikan(false);
              displayOutbond(true);
              displayOperasional(false);
              displayTransport(false);
              displayHonorDokter(false);
              displayLainnya(false);
              displayYayasan(false);
            } else if($(this).val() == 'Operasional'){
              displayPerbaikan(false);
              displayOutbond(false);
              displayOperasional(true);
              displayTransport(false);
              displayHonorDokter(false);
              displayLainnya(false);
              displayYayasan(false);
            } else if($(this).val() == 'Transport'){
              displayPerbaikan(false);
              displayOutbond(false);
              displayOperasional(false);
              displayTransport(true);
              displayHonorDokter(false);
              displayLainnya(false);
              displayYayasan(false);
            } else if($(this).val() == 'Honor Dokter'){
              displayPerbaikan(false);
              displayOutbond(false);
              displayOperasional(false);
              displayTransport(false);
              displayHonorDokter(true);
              displayLainnya(false);
              displayYayasan(false);
            } else if($(this).val() == 'Lainnya'){
              displayPerbaikan(false);
              displayOutbond(false);
              displayOperasional(false);
              displayTransport(false);
              displayHonorDokter(false);
              displayLainnya(true);
              displayYayasan(false);
            } else if($(this).val() == 'Pemasukan Yayasan'){
              displayPerbaikan(false);
              displayOutbond(false);
              displayOperasional(false);
              displayTransport(false);
              displayHonorDokter(false);
              displayLainnya(false);
              displayYayasan(true);
            } else {
              displayPerbaikan(false);
              displayOutbond(false);
              displayOperasional(false);
              displayTransport(false);
              displayHonorDokter(false);
              displayLainnya(false);
              displayYayasan(false);
            }
          })
      });

      function displayPerbaikan(isShow) {
        $('.div-perbaikan').toggle(isShow);
        $('.perbaikan').each(function(index, element) {
            $(element).attr('disabled', true);
        });
      }

      function displayOutbond(isShow) {
        $('.div-outbond').toggle(isShow);
        $('.outbond').each(function(index, element) {
            $(element).attr('disabled', true);
        });
      }

      function displayOperasional(isShow) {
        $('.div-operasional').toggle(isShow);
        $('.operasional').each(function(index, element) {
            $(element).attr('disabled', true);
        });
      }

      function displayLainnya(isShow) {
          $('.div-lainnya').toggle(isShow);
          if (isShow) {
              $('.lainnya').removeAttr('disabled');
          } else {
              var lainnyaLength = $('.lainnya').length;
              $('.lainnya').each(function(index, element) {
                  $(element).attr('disabled', true);
              });
          }
      }

      function displayYayasan(isShow) {
          $('.div-yayasan').toggle(isShow);
          if (isShow) {
              $('.yayasan').removeAttr('disabled');
              $('.yayasan').attr('disabled');
          } else {
              var yayasanLength = $('.yayasan').length;
              $('.yayasan').each(function(index, element) {
                  $(element).attr('disabled', true);
              });
          }
      }
    </script>
@endsection