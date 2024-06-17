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
            <h1 class="m-0">Detail Data Pengurus</h1>
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
                    <h3 class="text-center font-weight-bold">Data Pengurus</h3>
                    <br><br>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" name="status" disabled>
                                    <option value="AKTIF" {{ $pengurus->status == "AKTIF" ? 'selected' : '' }}>AKTIF</option>
                                    <option value="TIDAK AKTIF" {{ $pengurus->status == "TIDAK AKTIF" ? 'selected' : '' }}>TIDAK AKTIF</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                            <label>Nama Pengurus</label>
                            <input type="text" name="nama_pengurus" class="form-control" placeholder="Nama Pengurus" value="{{ $pengurus->nama_pengurus }}" disabled>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                            <label>Nomor Handphone</label>
                            <input type="number" name="no_hp_pengurus" class="form-control" placeholder="No Handphone Pengurus" value="{{ $pengurus->no_hp_pengurus }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                            <label>Instasi</label>
                            <select class="form-control select2" data-dropdown-css-class="select2-danger" style="width: 100%;" id="instansi_id" name="instansi_id" disabled>
                                <option value="{{ $data_instansi->id }}" {{ $pengurus->instansi_id == $data_instansi->id ? 'selected' : '' }}>{{ $data_instansi->nama_instansi }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                            <label>Jabatan</label>
                            <select class="form-control select2" data-dropdown-css-class="select2-danger" style="width: 100%;" id="jabatan_id" name="jabatan_id" disabled>
                                <option value="">Pilih Jabatan</option>
                                @foreach ($jabatans as $item)
                                    <option value="{{ $item->id }}" {{ $pengurus->jabatan_id == $item->id ? 'selected' : '' }}>{{ $item->jabatan }}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                            <label>Alamat</label>
                            <textarea class="form-control" name="alamat_pengurus" rows="3" placeholder="Alamat" disabled>{{ $pengurus->alamat_pengurus }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('pengurus.index', ['instansi' => $instansi]) }}" class="btn btn-secondary" type="button">Batal</a>
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
    </script>
@endsection