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
            <h1 class="m-0">Tambah Data Pemasukan Lainnya</h1>
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
                    <form action="{{ route('pemasukan_lainnya.store', ['instansi' => $instansi]) }}" method="post">
                        @csrf
                        <h3 class="text-center font-weight-bold">Data Pemasukan Lainnya</h3>
                        <br><br>
                        <div class="row">
                          <div class="col-sm-4">
                            <div class="form-group">
                            <label>Instansi</label>
                            <select class="form-control select2" style="width: 100%" data-dropdown-css-class="select2-danger" id="instansi_id" name="instansi_id" required>
                                <option value="{{ $data_instansi->id }}" {{ old('instansi_id') == $data_instansi->id ? 'selected' : '' }}>{{ $data_instansi->nama_instansi }}</option>
                            </select>
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                            <label>Jenis</label>
                            <select class="form-control select2" style="width: 100%" data-dropdown-css-class="select2-danger" id="jenis" name="jenis" required>
                                <option value="">Pilih Jenis</option>
                                <option value="Donasi">Donasi</option>
                                <option value="Sewa Kantin">Sewa Kantin</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                            <label>Tanggal</label>
                            <div class="input-group mb-3">
                              <input type="date" name="tanggal" class="form-control" placeholder="Tanggal" value="{{ old('tanggal') ?? date('Y-m-d') }}" required>
                            </div>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-4">
                              <div class="form-group">
                              <label>Total</label>
                              <input type="number" id="total" name="total" class="form-control" placeholder="Total Bayar" required value="0">
                              </div>
                          </div>
                          <div class="col-sm-4">
                              <div class="form-group">
                              <label>Keterangan</label>
                              <textarea class="form-control" name="keterangan" id="keterangan"></textarea>
                              </div>
                          </div>
                        </div>
                        <div>
                            <a href="{{ route('pemasukan_lainnya.index', ['instansi' => $instansi]) }}" class="btn btn-secondary" type="button">Back</a>
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
      $('#tagihan_siswa_id').on('change', function(){
        let nominal = $(this).find(':selected').data('nominal');
        $('#total').val(parseInt(nominal));
      });
      $('#total').on('input', function(){
        let bayar = $(this).val();
        let nominal = $('#tagihan_siswa_id').find(':selected').data('nominal');
        $('#sisa').val(parseInt(nominal) - parseInt(bayar));
      });
    </script>
@endsection