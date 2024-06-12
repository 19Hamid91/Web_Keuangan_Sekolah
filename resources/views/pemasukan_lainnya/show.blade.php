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
            <h1 class="m-0">Detail Data Pemasukan Lainnya</h1>
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
                    <h3 class="text-center font-weight-bold">Data Pemasukan Lainnya</h3>
                    <br><br>
                    <div class="row">
                      <div class="col-sm-4">
                        <div class="form-group">
                        <label>Instansi</label>
                        <select class="form-control select2" style="width: 100%" data-dropdown-css-class="select2-danger" id="instansi_id" name="instansi_id" disabled>
                            <option value="{{ $data_instansi->id }}" {{ $data->instansi_id == $data_instansi->id ? 'selected' : '' }}>{{ $data_instansi->nama_instansi }}</option>
                        </select>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                        <label>Jenis</label>
                        <select class="form-control select2" style="width: 100%" data-dropdown-css-class="select2-danger" id="jenis" name="jenis" disabled>
                            <option value="">Pilih Jenis</option>
                            <option value="Donasi" {{ $data->jenis == 'Donasi' ? 'selected' : '' }}>Donasi</option>
                            <option value="Sewa Kantin" {{ $data->jenis == 'Sewa Kantin' ? 'selected' : '' }}>Sewa Kantin</option>
                            <option value="Lainnya" {{ $data->jenis == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                        <label>Tanggal</label>
                        <div class="input-group mb-3">
                          <input type="date" name="tanggal" class="form-control" placeholder="Tanggal" value="{{ $data->tanggal }}" disabled>
                        </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                        <div id="divDonaturId" class="col-sm-4" style="display: none">
                            <div class="form-group">
                            <label>Sumber</label>
                            <select class="form-control select2" style="width: 100%" data-dropdown-css-class="select2-danger" id="donatur_id" name="donatur_id" disabled>
                                <option value="">Pilih Donatur</option>
                                @foreach ($donaturs as $donatur)
                                    <option value="{{ $donatur->id }} {{ $data->donatur_id == $donatur->id ? 'selected' : '' }}">{{ $donatur->nama }}</option>      
                                @endforeach
                            </select>
                            </div>
                        </div>
                        <div id="divDonatur" class="col-sm-4">
                            <div class="form-group">
                            <label>Sumber</label>
                            <input type="text" id="donatur" name="donatur" class="form-control" placeholder="Sumber" value="{{ $data->donatur }}" disabled>
                            </div>
                        </div>
                      <div class="col-sm-4">
                          <div class="form-group">
                          <label>Total</label>
                          <input type="text" id="total" name="total" class="form-control" placeholder="Total Bayar" disabled value="{{ $data->total ?? 0 }}">
                          </div>
                      </div>
                      <div class="col-sm-4">
                          <div class="form-group">
                          <label>Keterangan</label>
                          <textarea class="form-control" name="keterangan" id="keterangan" disabled>{{ $data->keterangan }}</textarea>
                          </div>
                      </div>
                    </div>
                    <div>
                        <a href="{{ route('pemasukan_lainnya.index', ['instansi' => $instansi]) }}" class="btn btn-secondary" type="button">Back</a>
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
        $('#jenis').trigger('change');
        $('[id^=total]').each(function(){
            let input = $(this);
            let value = input.val();
            let formattedValue = formatNumber(value);

            input.val(formattedValue);
        })
      })
      $(document).on('input', '[id^=total]', function() {
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
      $('#jenis').on('change', function(){
        let jenis = $(this).val();
        let instansi = "{{ $instansi }}"
        if(jenis == 'Donasi' && instansi == 'yayasan'){
          $('#divDonaturId').css('display', 'block');
          $('#divDonaturId').attr('disabled', true);
          
          $('#divDonatur').css('display', 'none');
          $('#divDonatur').attr('disabled', true);
        } else if (jenis == 'Donasi' && instansi != 'yayasan'){
          $('#divDonaturId').css('display', 'none');
          $('#divDonaturId').attr('disabled', true);
          
          $('#divDonatur').css('display', 'block');
          $('#divDonatur').attr('disabled', true);
        } else {
          $('#divDonaturId').css('display', 'none');
          $('#divDonaturId').attr('disabled', true);
          
          $('#divDonatur').css('display', 'block');
          $('#divDonatur').attr('disabled', true);
        }
      });
    </script>
@endsection