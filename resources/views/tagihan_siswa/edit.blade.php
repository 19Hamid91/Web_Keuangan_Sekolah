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
                    <form id="form" action="{{ route('tagihan_siswa.update', ['instansi' => $instansi, 'tagihan_siswa' => $data[0]->tingkat]) }}" method="post">
                        @csrf
                        @method('patch')
                        <h3 class="text-center font-weight-bold">Data Tagihan Siswa</h3>
                        <br><br>
                        <div class="row">
                          <div class="col-sm-4">
                              <div class="form-group">
                              <label>Instansi</label>
                              <select class="form-control select2" data-dropdown-css-class="select2-danger" style="width: 100%;" id="instansi_id" name="instansi_id" required>
                                  <option value="{{ $data_instansi->id }}" {{ $data[0]->instansi_id == $data_instansi->id ? 'selected' : '' }}>{{ $data_instansi->nama_instansi }}</option>
                                </select>
                              </div>
                          </div>
                          <div class="col-sm-4">
                              <div class="form-group">
                              <label>Tahun Ajaran</label>
                              <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" id="tahun_ajaran_id" name="tahun_ajaran_id" required>
                                  <option value="{{ $tahun_ajaran->id }}" {{ $data[0]->tahun_ajaran_id == $tahun_ajaran->id ? 'selected' : '' }}>{{ $tahun_ajaran->thn_ajaran }}</option>
                                </select>
                              </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                            <label>Tingkat</label>
                            <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" id="tingkat" name="tingkat" required>
                                @foreach ($tingkat as $item)
                                      <option value="{{ $item }}" {{ $data[0]->tingkat == $item ? 'selected' : '' }}>{{ $item }}</option>
                                  @endforeach
                              </select>
                            </div>
                          </div>
                        </div>
                        @foreach ($data as $index => $tagihan)
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Jenis Tagihan</label>
                                    <input type="text" name="jenis_tagihan[]" class="form-control" value="{{ $tagihan->jenis_tagihan }}" readonly required>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Jumlah Pembayaran</label>
                                    <select class="form-control select2" style="width: 100%" data-dropdown-css-class="select2-danger" name="jumlah_pembayaran[]" required>
                                        <option value="Per Bulan" {{ $tagihan->jumlah_pembayaran == 'Per Bulan' ? 'selected' : ''}}>Per Bulan</option>
                                        <option value="Per Tahun" {{ $tagihan->jumlah_pembayaran == 'Per Tahun' ? 'selected' : ''}}>Per Tahun</option>
                                        <option value="Sekali" {{ $tagihan->jumlah_pembayaran == 'Sekali' ? 'selected' : ''}}>Sekali</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label>Nominal</label>
                                    <div class="input-group mb-3">
                                        <input type="text" name="nominal[]" class="form-control" placeholder="Nominal" value="{{ $tagihan->nominal }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label>Mulai Bayar</label>
                                    <div class="input-group mb-3">
                                        <input type="date" name="mulai_bayar[]" class="form-control" value="{{ $tagihan->mulai_bayar }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label>Akhir Bayar</label>
                                    <div class="input-group mb-3">
                                        <input type="date" name="akhir_bayar[]" class="form-control" value="{{ $tagihan->akhir_bayar }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <div>
                            <a href="{{ route('tagihan_siswa.index', ['instansi' => $instansi]) }}" class="btn btn-secondary" type="button">Batal</a>
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