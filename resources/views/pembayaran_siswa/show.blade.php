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
            <h1 class="m-0">Detail Data Pembayaran Siswa</h1>
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
                    <h3 class="text-center font-weight-bold">Data Pembayaran Siswa</h3>
                    <br><br>
                    <div class="row">
                      <div class="col-sm-4">
                        <div class="form-group">
                        <label>Tagihan</label>
                        <select class="form-control select2" style="width: 100%" data-dropdown-css-class="select2-danger" id="tagihan_siswa_id" name="tagihan_siswa_id" disabled>
                            <option value="">Pilih Tagihan</option>
                            @foreach ($tagihan_siswa as $item)
                                <option value="{{ $item->id }}" {{ $data->tagihan_siswa_id == $item->id ? 'selected' : '' }} data-nominal="{{ $item->nominal }}">{{ $item->jenis_tagihan }} - {{ formatRupiah($item->nominal) }}</option>
                            @endforeach
                        </select>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                        <label>Siswa</label>
                        <select class="form-control select2" style="width: 100%" data-dropdown-css-class="select2-danger" id="siswa_id" name="siswa_id" disabled>
                            <option value="">Pilih Siswa</option>
                            @foreach ($siswa as $item)
                                <option value="{{ $item->id }}" {{ $data->siswa_id == $item->id ? 'selected' : '' }} data-instansi="{{ $item->instansi_id }}" data-kelas="{{ $item->kelas_id }}">({{ $item->nis }}) {{ $item->nama_siswa }}</option>
                            @endforeach
                        </select>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                        <label>Tanggal</label>
                        <div class="input-group mb-3">
                          <input type="date" name="tanggal" class="form-control" placeholder="Tanggal" value="{{ $data->tanggal ?? date('Y-m-d') }}" disabled>
                        </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-4">
                          <div class="form-group">
                          <label>Total</label>
                          <input type="text" id="total" name="total" class="form-control" placeholder="Total Bayar" value="{{ $data->total ?? 0 }}" disabled>
                          </div>
                      </div>
                      <div class="col-sm-4">
                          <div class="form-group">
                          <label>Sisa</label>
                          <input type="text" id="sisa" name="sisa" class="form-control" placeholder="Sisa Pembayaran" value="{{ $data->sisa ?? 0 }}" disabled readonly>
                          </div>
                      </div>
                      <div class="col-sm-4">
                          <div class="form-group">
                          <label>Tipe Pembayaran</label>
                          <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" id="tipe_pembayaran" name="tipe_pembayaran" disabled>
                                <option value="Cash" {{ $data->tipe_pembayaran =='Cash' ? 'selected' : '' }}>Cash</option>
                                <option value="Transfer" {{ $data->tipe_pembayaran =='Transfer' ? 'selected' : '' }}>Transfer</option>
                            </select>
                          </div>
                      </div>
                    </div>
                    <div>
                        <a href="{{ route('pembayaran_siswa.index', ['instansi' => $instansi, 'kelas' => $kelas]) }}" class="btn btn-secondary" type="button">Batal</a>
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
            $('[id^=total], [id^=sisa]').each(function() {
                  let input = $(this);
                  let value = input.val();
                  let formattedValue = formatNumber(value);

                  input.val(formattedValue);
              });
        })
      $(document).on('input', '[id^=total], [id^=sisa]', function() {
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
            let inputs = $('#form').find('[id^=total], [id^=sisa]');
            inputs.each(function() {
                let input = $(this);
                let value = input.val();
                let cleanedValue = cleanNumber(value);

                input.val(cleanedValue);
            });

            return true;
        });
      $('#tagihan_siswa_id').on('change', function(){
        let nominal = $(this).find(':selected').data('nominal');
        $('#total').val(formatNumber(nominal));
      });
      $('#total').on('input', function(){
        let bayar = cleanNumber($(this).val());
        let nominal = $('#tagihan_siswa_id').find(':selected').data('nominal');
        $('#sisa').val(formatNumber((parseInt(nominal) - parseInt(bayar))));
      });
    </script>
@endsection