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
            <h1 class="m-0">Tambah Data Tagihan Siswa</h1>
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
                    <form id="addForm" action="{{ route('tagihan_siswa.store', ['instansi' => $instansi]) }}" method="post">
                        @csrf
                        <h3 class="text-center font-weight-bold">Data Tagihan Siswa</h3>
                        <br><br>
                        <div class="row">
                          <div class="col-sm-4">
                              <div class="form-group">
                              <label>Instansi</label>
                              <select class="form-control select2" data-dropdown-css-class="select2-danger" style="width: 100%;" id="instansi_id" name="instansi_id" required>
                                  <option value="{{ $data_instansi->id }}" {{ old('instansi_id') == $data_instansi->id ? 'selected' : '' }}>{{ $data_instansi->nama_instansi }}</option>
                                </select>
                              </div>
                          </div>
                          <div class="col-sm-4">
                              <div class="form-group">
                              <label>Tahun Ajaran</label>
                              <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" id="tahun_ajaran_id" name="tahun_ajaran_id" required>
                                  <option value="{{ $tahun_ajaran->id }}" {{ old('tahun_ajaran_id') == $tahun_ajaran->id ? 'selected' : '' }}>{{ $tahun_ajaran->thn_ajaran }}</option>
                                </select>
                              </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                            <label>Tingkat</label>
                            <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" id="tingkat" name="tingkat" required>
                                @foreach ($tingkat as $item)
                                      <option value="{{ $item }}" {{ old('tingkat') == $item ? 'selected' : '' }}>{{ $item }}</option>
                                  @endforeach
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-3">
                            <div class="form-group">
                            <label>Jenis Tagihan</label>
                            <input type="text" name="jenis_tagihan[]" class="form-control" value="JPI" readonly required>
                            </div>
                          </div>
                          <div class="col-sm-3">
                            <div class="form-group">
                            <label>Jumlah Pembayaran</label>
                            <select class="form-control select2" style="width: 100%" data-dropdown-css-class="select2-danger" id="jumlah_pembayaran_jpi" name="jumlah_pembayaran[]" required>
                              <option value="Per Bulan" {{ old('jumlah_pembayaran.0') == 'Per Bulan' ? 'selected' : ''}}>Per Bulan</option>
                              <option value="Per Tahun" {{ old('jumlah_pembayaran.0') == 'Per Tahun' ? 'selected' : ''}}>Per Tahun</option>
                              <option value="Sekali" {{ old('jumlah_pembayaran.0') == 'Sekali' ? 'selected' : ''}}>Sekali</option>
                            </select>
                            </div>
                          </div>
                          <div class="col-sm-2">
                            <div class="form-group">
                            <label>Nominal</label>
                            <div class="input-group mb-3">
                              <input type="text" id="nominal" name="nominal[]" class="form-control" placeholder="Nominal" value="{{ old('nominal.0') }}" required>
                            </div>
                            </div>
                          </div>
                          <div class="col-sm-2">
                            <div class="form-group">
                            <label>Mulai Bayar</label>
                            <div class="input-group mb-3">
                              <input type="date" name="mulai_bayar[]" class="form-control" placeholder="mulai_bayar" value="{{ old('mulai_bayar.0') ?? date('Y-m-d') }}" required>
                            </div>
                            </div>
                          </div>
                          <div class="col-sm-2">
                            <div class="form-group">
                            <label>Akhir Bayar</label>
                            <div class="input-group mb-3">
                              <input type="date" name="akhir_bayar[]" class="form-control" placeholder="akhir_bayar" value="{{ old('akhir_bayar.0') ?? date('Y-m-d') }}" required>
                            </div>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-3">
                            <div class="form-group">
                            <label>Jenis Tagihan</label>
                            <input type="text" name="jenis_tagihan[]" class="form-control" value="Registrasi" readonly required>
                            </div>
                          </div>
                          <div class="col-sm-3">
                            <div class="form-group">
                            <label>Jumlah Pembayaran</label>
                            <select class="form-control select2" style="width: 100%" data-dropdown-css-class="select2-danger" id="jumlah_pembayaran_reg" name="jumlah_pembayaran[]" required>
                              <option value="Per Bulan" {{ old('jumlah_pembayaran.1') == 'Per Bulan' ? 'selected' : ''}}>Per Bulan</option>
                              <option value="Per Tahun" {{ old('jumlah_pembayaran.1') == 'Per Tahun' ? 'selected' : ''}}>Per Tahun</option>
                              <option value="Sekali" {{ old('jumlah_pembayaran.1') == 'Sekali' ? 'selected' : ''}}>Sekali</option>
                            </select>
                            </div>
                          </div>
                          <div class="col-sm-2">
                            <div class="form-group">
                            <label>Nominal</label>
                            <div class="input-group mb-3">
                              <input type="text" id="nominal" name="nominal[]" class="form-control" placeholder="Nominal" value="{{ old('nominal.1') }}" required>
                            </div>
                            </div>
                          </div>
                          <div class="col-sm-2">
                            <div class="form-group">
                            <label>Mulai Bayar</label>
                            <div class="input-group mb-3">
                              <input type="date" name="mulai_bayar[]" class="form-control" placeholder="mulai_bayar" value="{{ old('mulai_bayar.1') ?? date('Y-m-d') }}" required>
                            </div>
                            </div>
                          </div>
                          <div class="col-sm-2">
                            <div class="form-group">
                            <label>Akhir Bayar</label>
                            <div class="input-group mb-3">
                              <input type="date" name="akhir_bayar[]" class="form-control" placeholder="akhir_bayar" value="{{ old('akhir_bayar.1') ?? date('Y-m-d') }}" required>
                            </div>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-3">
                            <div class="form-group">
                            <label>Jenis Tagihan</label>
                            <input type="text" name="jenis_tagihan[]" class="form-control" value="SPP" readonly required>
                            </div>
                          </div>
                          <div class="col-sm-3">
                            <div class="form-group">
                            <label>Jumlah Pembayaran</label>
                            <select class="form-control select2" style="width: 100%" data-dropdown-css-class="select2-danger" id="jumlah_pembayaran_spp" name="jumlah_pembayaran[]" required>
                              <option value="Per Bulan" {{ old('jumlah_pembayaran.2') == 'Per Bulan' ? 'selected' : ''}}>Per Bulan</option>
                              <option value="Per Tahun" {{ old('jumlah_pembayaran.2') == 'Per Tahun' ? 'selected' : ''}}>Per Tahun</option>
                              <option value="Sekali" {{ old('jumlah_pembayaran.2') == 'Sekali' ? 'selected' : ''}}>Sekali</option>
                            </select>
                            </div>
                          </div>
                          <div class="col-sm-2">
                            <div class="form-group">
                            <label>Nominal</label>
                            <div class="input-group mb-3">
                              <input type="text" id="nominal" name="nominal[]" class="form-control" placeholder="Nominal" value="{{ old('nominal.2') }}" required>
                            </div>
                            </div>
                          </div>
                          <div class="col-sm-2">
                            <div class="form-group">
                            <label>Mulai Bayar</label>
                            <div class="input-group mb-3">
                              <input type="date" name="mulai_bayar[]" class="form-control" placeholder="mulai_bayar" value="{{ old('mulai_bayar.2') ?? date('Y-m-d') }}" required>
                            </div>
                            </div>
                          </div>
                          <div class="col-sm-2">
                            <div class="form-group">
                            <label>Akhir Bayar</label>
                            <div class="input-group mb-3">
                              <input type="date" name="akhir_bayar[]" class="form-control" placeholder="akhir_bayar" value="{{ old('akhir_bayar.2') ?? date('Y-m-d') }}" required>
                            </div>
                            </div>
                          </div>
                        </div>
                        @if($instansi != 'smp')
                        {{-- <div class="row" id="row_overtime">
                          <div class="col-sm-3">
                            <div class="form-group">
                            <label>Jenis Tagihan</label>
                            <input type="text" name="jenis_tagihan[]" class="form-control" value="Overtime" readonly required>
                            </div>
                          </div>
                          <div class="col-sm-3">
                            <div class="form-group">
                            <label>Jumlah Pembayaran</label>
                            <select class="form-control select2" style="width: 100%" data-dropdown-css-class="select2-danger" id="jumlah_pembayaran_overtime" name="jumlah_pembayaran[]" required>
                              <option value="Per Bulan" {{ old('jumlah_pembayaran.3') == 'Per Bulan' ? 'selected' : ''}}>Per Bulan</option>
                              <option value="Per Tahun" {{ old('jumlah_pembayaran.3') == 'Per Tahun' ? 'selected' : ''}}>Per Tahun</option>
                              <option value="Sekali" {{ old('jumlah_pembayaran.3') == 'Sekali' ? 'selected' : ''}}>Sekali</option>
                            </select>
                            </div>
                          </div>
                          <div class="col-sm-2">
                            <div class="form-group">
                            <label>Nominal</label>
                            <div class="input-group mb-3">
                              <input type="text" id="nominal" name="nominal[]" class="form-control" placeholder="Nominal" value="{{ old('nominal.3') }}" required>
                            </div>
                            </div>
                          </div>
                          <div class="col-sm-2">
                            <div class="form-group">
                            <label>Mulai Bayar</label>
                            <div class="input-group mb-3">
                              <input type="date" name="mulai_bayar[]" class="form-control" placeholder="mulai_bayar" value="{{ old('mulai_bayar.3') ?? date('Y-m-d') }}" required>
                            </div>
                            </div>
                          </div>
                          <div class="col-sm-2">
                            <div class="form-group">
                            <label>Akhir Bayar</label>
                            <div class="input-group mb-3">
                              <input type="date" name="akhir_bayar[]" class="form-control" placeholder="akhir_bayar" value="{{ old('akhir_bayar.3') ?? date('Y-m-d') }}" required>
                            </div>
                            </div>
                          </div>
                        </div> --}}
                        <div class="row" id="row_outbond">
                          <div class="col-sm-3">
                            <div class="form-group">
                            <label>Jenis Tagihan</label>
                            <input type="text" name="jenis_tagihan[]" class="form-control" value="Outbond" readonly required>
                            </div>
                          </div>
                          <div class="col-sm-3">
                            <div class="form-group">
                            <label>Jumlah Pembayaran</label>
                            <select class="form-control select2" style="width: 100%" data-dropdown-css-class="select2-danger" id="jumlah_pembayaran_outbond" name="jumlah_pembayaran[]" required>
                              <option value="Per Bulan" {{ old('jumlah_pembayaran.4') == 'Per Bulan' ? 'selected' : ''}}>Per Bulan</option>
                              <option value="Per Tahun" {{ old('jumlah_pembayaran.4') == 'Per Tahun' ? 'selected' : ''}}>Per Tahun</option>
                              <option value="Sekali" {{ old('jumlah_pembayaran.4') == 'Sekali' ? 'selected' : ''}}>Sekali</option>
                            </select>
                            </div>
                          </div>
                          <div class="col-sm-2">
                            <div class="form-group">
                            <label>Nominal</label>
                            <div class="input-group mb-3">
                              <input type="text" id="nominal" name="nominal[]" class="form-control" placeholder="Nominal" value="{{ old('nominal.4') }}" required>
                            </div>
                            </div>
                          </div>
                          <div class="col-sm-2">
                            <div class="form-group">
                            <label>Mulai Bayar</label>
                            <div class="input-group mb-3">
                              <input type="date" name="mulai_bayar[]" class="form-control" placeholder="mulai_bayar" value="{{ old('mulai_bayar.4') ?? date('Y-m-d') }}" required>
                            </div>
                            </div>
                          </div>
                          <div class="col-sm-2">
                            <div class="form-group">
                            <label>Akhir Bayar</label>
                            <div class="input-group mb-3">
                              <input type="date" name="akhir_bayar[]" class="form-control" placeholder="akhir_bayar" value="{{ old('akhir_bayar.4') ?? date('Y-m-d') }}" required>
                            </div>
                            </div>
                          </div>
                        </div>
                        @endif
                        <div>
                            <a href="{{ route('tagihan_siswa.index', ['instansi' => $instansi]) }}" class="btn btn-secondary" type="button">Batal</a>
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
        $('#row_overtime').hide();
      })
      $(document).on('input', '[id^=nominal]', function() {
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
            let inputs = $('#addForm').find('[id^=nominal]');
            inputs.each(function() {
                let input = $(this);
                let value = input.val();
                let cleanedValue = cleanNumber(value);

                input.val(cleanedValue);
            });

            return true;
        });
        $('#tingkat').on('change', function(){
            let tingkat = $(this).val();
            if(tingkat == 'TPA') {
                $('#row_outbond').hide().find(':input').prop('disabled', true);
            } else {
                $('#row_outbond').show().find(':input').prop('disabled', false);
            }
        });
        $('#toggle_overtime').change(function() {
            if ($(this).is(':checked')) {
                $('#row_overtime').show();
            } else {
                $('#row_overtime').hide();
            }
        });
    </script>
@endsection