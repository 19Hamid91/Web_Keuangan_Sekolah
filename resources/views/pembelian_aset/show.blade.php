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
            <h1 class="m-0">Detail Data Pembelian Aset Tetap</h1>
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
                    <h3 class="text-center font-weight-bold">Data Pembelian Aset Tetap</h3>
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
                            <label>Aset Tetap</label>
                            <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" name="aset_id" disabled>
                                <option value="">Pilih Aset Tetap</option>
                                @foreach ($asets as $item)
                                    <option value="{{ $item->id }}" {{ $data->aset_id == $item->id ? 'selected' : '' }}>{{ $item->nama_aset }}</option>
                                @endforeach
                            </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                            <label>Tanggal Beli</label>
                            <input type="date" name="tgl_beliaset" class="form-control" placeholder="Tanggal Beli Aset" value="{{ $data->tgl_beliaset ?? date('Y-m-d') }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                            <label>Satuan</label>
                            <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" name="satuan" disabled>
                                <option value="unit" {{ $data->satuan == 'unit' ? 'selected' : '' }}>Unit</option>
                            </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                            <label>Jumlah</label>
                            <input type="number" id="jumlah_aset" name="jumlah_aset" class="form-control" placeholder="Jumlah Aset" value="{{ $data->jumlah_aset }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                            <label>Harga Satuan</label>
                            <input type="text" id="hargasatuan_aset" name="hargasatuan_aset" class="form-control" placeholder="Jumlah Aset" value="{{ $data->hargasatuan_aset }}" disabled>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                            <label>Total Harga</label>
                            <input type="text" id="jumlahbayar_aset" name="jumlahbayar_aset" class="form-control" placeholder="Total Harga" value="{{ $data->jumlahbayar_aset }}" disabled>
                            </div>
                        </div>
                    </div>
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
                        <a href="{{ route('pembelian-aset.index', ['instansi' => $instansi]) }}" class="btn btn-secondary" type="button">Batal</a>
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
            $('[id^=hargasatuan_aset], [id^=jumlahbayar_aset]').each(function() {
                  let input = $(this);
                  let value = input.val();
                  let formattedValue = formatNumber(value);

                  input.val(formattedValue);
              });
        })
    </script>
@endsection