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
            <h1 class="m-0">Edit Data Pembelian Atk</h1>
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
                    <form id="form" action="{{ route('pembelian-atk.update', ['id' => $data->id, 'instansi' => $instansi]) }}" method="post">
                        @csrf
                        @method('patch')
                        <h3 class="text-center font-weight-bold">Data Pembelian Atk</h3>
                        <br><br>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                <label>Supplier</label>
                                <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" name="supplier_id" required>
                                    <option value="">Pilih Supplier</option>
                                    @foreach ($suppliers as $item)
                                        <option value="{{ $item->id }}" {{ $data->supplier_id == $item->id ? 'selected' : '' }}>{{ $item->nama_supplier }}</option>
                                    @endforeach
                                </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                <label>Atk</label>
                                <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" name="atk_id" required>
                                    <option value="">Pilih Atk</option>
                                    @foreach ($atks as $item)
                                        <option value="{{ $item->id }}" {{ $data->atk_id == $item->id ? 'selected' : '' }}>{{ $item->nama_atk }}</option>
                                    @endforeach
                                </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                <label>Tanggal Beli</label>
                                <input type="date" name="tgl_beliatk" class="form-control" placeholder="Tanggal Beli atk" value="{{ $data->tgl_beliatk ?? date('Y-m-d') }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label>Satuan</label>
                                <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" name="satuan" required>
                                    <option value="pcs" {{ $data->satuan == 'pcs' ? 'selected' : '' }}>pcs</option>
                                    <option value="rem" {{ $data->satuan == 'rem' ? 'selected' : '' }}>rem</option>
                                    <option value="box" {{ $data->satuan == 'box' ? 'selected' : '' }}>box</option>
                                </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label>Jumlah</label>
                                <input type="number" id="jumlah_atk" name="jumlah_atk" class="form-control" placeholder="Jumlah atk" value="{{ $data->jumlah_atk }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label>Harga Satuan</label>
                                <input type="text" id="hargasatuan_atk" name="hargasatuan_atk" class="form-control" placeholder="Jumlah Atk" value="{{ $data->hargasatuan_atk }}" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label>Total Harga</label>
                                <input type="text" id="jumlahbayar_atk" name="jumlahbayar_atk" class="form-control" placeholder="Total Harga" value="{{ $data->jumlahbayar_atk }}" required>
                                </div>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('pembelian-atk.index', ['instansi' => $instansi]) }}" class="btn btn-secondary" type="button">Back</a>
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
            $('[id^=hargasatuan_atk], [id^=jumlahbayar_atk]').each(function() {
                  let input = $(this);
                  let value = input.val();
                  let formattedValue = formatNumber(value);

                  input.val(formattedValue);
              });
        })
        $(document).on('input', '#jumlah_atk, #hargasatuan_atk', function(){
            var jumlah = cleanNumber($('#jumlah_atk').val());
            var harga = cleanNumber($('#hargasatuan_atk').val());
            $('#jumlahbayar_atk').val(formatNumber(jumlah * harga));
        });
        $(document).on('input', '[id^=hargasatuan_atk], [id^=jumlahbayar_atk]', function() {
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
            let inputs = $('#form').find('[id^=hargasatuan_atk], #jumlahbayar_atk');
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