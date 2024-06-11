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
            <h1 class="m-0">Detail Data Pembelian Atk</h1>
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
                    <h3 class="text-center font-weight-bold">Data Pembelian Atk</h3>
                    <br><br>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                            <label>Supplier</label>
                            <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" name="supplier_id" disabled>
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
                            <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" name="atk_id" disabled>
                                <option value="">Pilih Atk</option>
                                @foreach ($atks as $item)
                                    <option value="{{ $item->id }}" {{ $data->atk_id == $item->id ? 'selected' : '' }}>{{ $item->nama_atk }}</option>
                                @endforeach
                            </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                            <label>Tanggal beli</label>
                            <input type="date" name="tgl_beliatk" class="form-control" placeholder="Tanggal beli atk" value="{{ $data->tgl_beliatk ?? date('Y-m-d') }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                            <label>Satuan</label>
                            <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" name="satuan" disabled>
                                <option value="pcs" {{ $data->satuan == 'pcs' ? 'selected' : '' }}>pcs</option>
                                <option value="rem" {{ $data->satuan == 'rem' ? 'selected' : '' }}>rem</option>
                                <option value="box" {{ $data->satuan == 'box' ? 'selected' : '' }}>box</option>
                            </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                            <label>Jumlah</label>
                            <input type="number" id="jumlah_atk" name="jumlah_atk" class="form-control" placeholder="Jumlah Atk" value="{{ $data->jumlah_atk }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                            <label>Harga Satuan</label>
                            <input type="text" id="hargasatuan_atk" name="hargasatuan_atk" class="form-control" placeholder="Jumlah atk" value="{{ $data->hargasatuan_atk }}" disabled>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                            <label>Total Harga</label>
                            <input type="text" id="jumlahbayar_atk" name="jumlahbayar_atk" class="form-control" placeholder="Total Harga" value="{{ $data->jumlahbayar_atk }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('pembelian-atk.index', ['instansi' => $instansi]) }}" class="btn btn-secondary" type="button">Back</a>
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
            $('[id^=hargasatuan_atk], [id^=jumlahbayar_atk]').each(function() {
                  let input = $(this);
                  let value = input.val();
                  let formattedValue = formatNumber(value);

                  input.val(formattedValue);
              });
        })
    </script>
@endsection