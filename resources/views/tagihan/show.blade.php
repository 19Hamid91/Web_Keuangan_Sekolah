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
            <h1 class="m-0">Detail Data Daftar tagihan</h1>
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
                    <form action="{{ route('daftar_tagihan.update', ['daftar_tagihan' => $data->id]) }}" method="post">
                        @csrf
                        @method('patch')
                        <h3 class="text-center font-weight-bold">Data Daftar Tagihan</h3>
                        <br><br>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label>Sekolah</label>
                                <select class="form-control select2" data-dropdown-css-class="select2-danger" id="kode_sekolah" name="kode_sekolah" disabled>
                                    <option value="">Pilih Sekolah</option>
                                    @foreach ($sekolah as $item)
                                        <option value="{{ $item->kode }}" {{ $data->kode_sekolah == $item->kode ? 'selected' : '' }}>{{ $item->nama_sekolah }}</option>
                                    @endforeach
                                  </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label>Kelas</label>
                                <select class="form-control select2" data-dropdown-css-class="select2-danger" id="kode_kelas" name="kode_kelas" disabled>
                                    <option value="">Pilih Kelas</option>
                                    @foreach ($kelas as $item)
                                        <option value="{{ $item->kode }}" {{ $data->kode_kelas == $item->kode ? 'selected' : '' }}>{{ $item->nama_kelas }}</option>
                                    @endforeach
                                  </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label>Yayasan</label>
                                <select class="form-control select2" data-dropdown-css-class="select2-danger" id="kode_yayasan" name="kode_yayasan" disabled>
                                    <option value="">Pilih Yayasan</option>
                                    @foreach ($yayasan as $item)
                                        <option value="{{ $item->kode }}" {{ $data->kode_yayasan == $item->kode ? 'selected' : '' }}>{{ $item->nama_yayasan }}</option>
                                    @endforeach
                                  </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label>Transaksi</label>
                                <select class="form-control select2" data-dropdown-css-class="select2-danger" id="kode_transaksi" name="kode_transaksi" disabled>
                                    <option value="">Pilih Transaksi</option>
                                    @foreach ($transaksi as $item)
                                        <option value="{{ $item->kode }}" {{ $data->kode_transaksi == $item->kode ? 'selected' : '' }}>{{ $item->nama_transaksi }}</option>
                                    @endforeach
                                  </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label>Nominal</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="text" name="nominal" class="form-control" placeholder="Nominal" value="{{ $data->nominal }}" disabled>
                                </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label>Presentase</label>
                                <div class="input-group mb-3">
                                    <input type="number" name="persen_yayasan" class="form-control" placeholder="Presentase Yayasan" value="{{ $data->persen_yayasan }}" min="0" max="100" disabled>
                                    <div class="input-group-append">
                                      <span class="input-group-text">%</span>
                                    </div>
                                  </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label>Awal Pembayaran</label>
                                <input type="date" name="awal_pembayaran" class="form-control" placeholder="Awal Pembayaran" value="{{ $data->awal_pembayaran }}" disabled>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label>Akhir Pembayaran</label>
                                <input type="date" name="akhir_pembayaran" class="form-control" placeholder="Akhir Pembayaran" value="{{ $data->akhir_pembayaran }}" disabled>
                                </div>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('daftar_tagihan.index') }}" class="btn btn-secondary" type="button">Back</a>
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
    </script>
@endsection