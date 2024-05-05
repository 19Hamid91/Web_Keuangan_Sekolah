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
            <h1 class="m-0">Tambah Data Tagihan</h1>
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
                    <form action="{{ route('tagihan.store') }}" method="post">
                        @csrf
                        <h3 class="text-center font-weight-bold">Data Tagihan</h3>
                        <br><br>
                        <div class="row">
                          <div class="col-sm-6">
                            <div class="form-group">
                            <label>Kode</label>
                            <div class="input-group mb-3">
                                <input type="text" name="kode" class="form-control" placeholder="Kode Tagihan" value="{{ old('kode') ?? $getKode }}" required readonly>
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="form-group">
                            <label>Status</label>
                            <select class="form-control select2" data-dropdown-css-class="select2-danger" style="width: 100%;" id="status" name="status" required>
                              <option value="PENDING" selected>Pending</option>
                              <option value="SELESAI">Selesai</option>
                              <option value="Batal">Batal</option>
                            </select>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label>Tagihan</label>
                                <select class="form-control select2" data-dropdown-css-class="select2-danger" style="width: 100%;" id="kode_daftar_tagihan" name="kode_daftar_tagihan" required>
                                    <option value="">Pilih Tagihan</option>
                                    @foreach ($daftartagihan as $tagihan)
                                        <option value="{{ $tagihan->kode }}" {{ old('kode_daftar_tagihan') == $tagihan->kode ? 'selected' : '' }}>{{ $tagihan->transaksi->nama_transaksi }}</option>
                                    @endforeach
                                  </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label>Siswa</label>
                                <select class="form-control select2" data-dropdown-css-class="select2-danger" style="width: 100%;" id="nis_siswa" name="nis_siswa" required>
                                    <option value="">Pilih Siswa</option>
                                    @foreach ($siswa as $item)
                                        <option value="{{ $item->nis }}" {{ old('nis_siswa') == $item->nis ? 'selected' : '' }}>{{ $item->nama_siswa }}</option>
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
                                    <input type="text" id="nominal" class="form-control" placeholder="Nominal" disabled>
                                </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label>Presentase</label>
                                <div class="input-group mb-3">
                                    <input type="number" id="persen_yayasan" class="form-control" placeholder="Presentase Yayasan" disabled>
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
                                <input type="date" id="awal_pembayaran" class="form-control" placeholder="Awal Pembayaran" disabled>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label>Akhir Pembayaran</label>
                                <input type="date" id="akhir_pembayaran" class="form-control" placeholder="Akhir Pembayaran" disabled>
                                </div>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('tagihan.index') }}" class="btn btn-secondary" type="button">Back</a>
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
      var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      $(document).ready(function() {
        var kode_daftar_tagihan = $('#kode_daftar_tagihan').val()
        if(kode_daftar_tagihan){
          data_tagihan();
        }
      });
      $('#kode_daftar_tagihan').on('change', function() {
        data_tagihan();
      });

      function data_tagihan(){
        var kode_daftar_tagihan = $('#kode_daftar_tagihan').val();
        if(!kode_daftar_tagihan){
          $('#nominal').val('');
          $('#persen_yayasan').val('');
          $('#awal_pembayaran').val('');
          $('#akhir_pembayaran').val('');
          return 0;
        }
        fetch(`/datadaftartagihan/${kode_daftar_tagihan}`, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json'
                }
        })
        .then((res) => res.json())
        .then(result => {
            $('#nominal').val(result.nominal);
            $('#persen_yayasan').val(result.persen_yayasan);
            $('#awal_pembayaran').val(result.awal_pembayaran);
            $('#akhir_pembayaran').val(result.akhir_pembayaran);
        })
      };
    </script>
@endsection