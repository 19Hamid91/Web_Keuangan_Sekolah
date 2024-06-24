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
            <h1 class="m-0">Edit Data Tagihan Siswa</h1>
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
                    <form id="form" action="{{ route('tagihan_siswa.update', ['instansi' => $instansi, 'tagihan_siswa' => $data->id]) }}" method="post">
                        @csrf
                        @method('patch')
                        <h3 class="text-center font-weight-bold">Data Tagihan Siswa</h3>
                        <br><br>
                        <div class="row">
                          <div class="col-sm-4">
                              <div class="form-group">
                              <label>Instansi</label>
                              <select class="form-control select2" data-dropdown-css-class="select2-danger" style="width: 100%;" id="instansi_id" name="instansi_id" required>
                                  <option value="{{ $data_instansi->id }}" {{ $data->instansi_id == $data_instansi->id ? 'selected' : '' }}>{{ $data_instansi->nama_instansi }}</option>
                                </select>
                              </div>
                          </div>
                          <div class="col-sm-4">
                              <div class="form-group">
                              <label>Tahun Ajaran</label>
                              <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" id="tahun_ajaran_id" name="tahun_ajaran_id" required>
                                  <option value="{{ $tahun_ajaran->id }}" {{ $data->tahun_ajaran_id == $tahun_ajaran->id ? 'selected' : '' }}>{{ $tahun_ajaran->thn_ajaran }}</option>
                                </select>
                              </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                            <label>Kelas</label>
                            <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" id="kelas_id" name="kelas_id" required>
                                @foreach ($kelas as $item)
                                      <option value="{{ $item->id }}" {{ $data->kelas_id == $item->id ? 'selected' : '' }}>{{ $item->kelas }} - {{ $item->grup_kelas }}</option>
                                  @endforeach
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-4">
                            <div class="form-group">
                            <label>Jenis Tagihan</label>
                            <select class="form-control select2" style="width: 100%" data-dropdown-css-class="select2-danger" id="jenis_tagihan" name="jenis_tagihan" required>
                                <option value="">Pilih Jenis Tagihan</option>
                                <option value="SPP" {{ $data->jenis_tagihan == "SPP" ? 'selected' : '' }}>SPP</option>
                                <option value="JPI" {{ $data->jenis_tagihan == "JPI" ? 'selected' : '' }}>JPI</option>
                                <option value="Registrasi" {{ $data->jenis_tagihan == "Registrasi" ? 'selected' : '' }}>Registrasi</option>
                                @if($instansi == 'tk-kb-tpa')
                                <option value="Outbond" {{ $data->jenis_tagihan == "Outbond" ? 'selected' : '' }}>Outbond</option>
                                <option value="Overtime" {{ $data->jenis_tagihan == "Overtime" ? 'selected' : '' }}>Overtime</option>
                                @endif
                            </select>
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                            <label>Jumlah Pembayaran</label>
                            <div class="input-group mb-3">
                              <input type="number" name="jumlah_pembayaran" class="form-control" placeholder="Jumlah Pembayaran" value="{{ $data->jumlah_pembayaran ?? 1 }}" required>
                              <div class="input-group-append">
                                <span class="input-group-text">kali</span>
                              </div>
                            </div>
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                            <label>Nominal</label>
                            <div class="input-group mb-3">
                              <input type="text" id="nominal" name="nominal" class="form-control" placeholder="Nominal" value="{{ $data->nominal ?? 0 }}" required>
                            </div>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-6">
                            <div class="form-group">
                            <label>Mulai Bayar</label>
                            <div class="input-group mb-3">
                              <input type="date" name="mulai_bayar" class="form-control" placeholder="mulai_bayar" value="{{ $data->mulai_bayar ?? date('Y-m-d') }}" required>
                            </div>
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="form-group">
                            <label>Akhir Bayar</label>
                            <div class="input-group mb-3">
                              <input type="date" name="akhir_bayar" class="form-control" placeholder="akhir_bayar" value="{{ $data->akhir_bayar ?? date('Y-m-d') }}" required>
                            </div>
                            </div>
                          </div>
                        </div>
                        <div>
                            <a href="{{ route('tagihan_siswa.index', ['instansi' => $instansi, 'tagihan_siswa' => $data->id]) }}" class="btn btn-secondary" type="button">Batal</a>
                            <button type="submit" class="btn btn-success">Update</button>
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
        $('[id^=nominal]').each(function(){
              let input = $(this);
              let value = input.val();
              let formattedValue = formatNumber(value);

              input.val(formattedValue);
          })
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
        $('#form').on('submit', function(e) {
            let inputs = $('#form').find('[id^=nominal]');
            inputs.each(function() {
                let input = $(this);
                let value = input.val();
                let cleanedValue = cleanNumber(value);

                input.val(cleanedValue);
            });

            return true;
        });
    </script>
@endsection