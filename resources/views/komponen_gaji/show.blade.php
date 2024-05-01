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
            <h1 class="m-0">Detail Data Komponen Gaji</h1>
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
                    <h3 class="text-center font-weight-bold">Data Komponen Gaji</h3>
                    <br><br>
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                        <label>Kode</label>
                        <div class="input-group mb-3">
                            <input type="text" name="kode" class="form-control" placeholder="Kode Komponen Gaji" value="{{ $data->kode }}" disabled readonly>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" placeholder="Tanggal" value="{{ old('tanggal') ?? $data->tanggal }}" disabled>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                            <label>Transaksi</label>
                            <select class="form-control select2" data-dropdown-css-class="select2-danger" style="width: 100%;" id="kode_transaksi" name="kode_transaksi" disabled>
                                <option value="">Pilih Transaksi</option>
                                @foreach ($transaksi as $item)
                                    <option value="{{ $item->kode }}" {{ $data->kode_transaksi == $item->kode ? 'selected' : '' }}>{{ $item->nama_transaksi }}</option>
                                @endforeach
                              </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                          <label>Nominal</label>
                          <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                <span class="input-group-text">Rp</span>
                              </div>
                              <input type="text" name="nominal" class="form-control" placeholder="Nominal" value="{{ old('nominal') ?? $data->nominal }}" disabled>
                          </div>
                          </div>
                      </div>
                    </div>
                    <div>
                        <a href="{{ route('komponen_gaji.index') }}" class="btn btn-secondary" type="button">Back</a>
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
      var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    </script>
@endsection