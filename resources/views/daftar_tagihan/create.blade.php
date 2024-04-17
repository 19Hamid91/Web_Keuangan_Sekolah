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
            <h1 class="m-0">Tambah Data Daftar tagihan</h1>
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
                    <form action="{{ route('daftar_tagihan.store') }}" method="post">
                        @csrf
                        <h3 class="text-center font-weight-bold">Data Daftar Tagihan</h3>
                        <br><br>
                        <div class="row">
                          <div class="col-sm-6">
                            <div class="form-group">
                            <label>Kode</label>
                            <div class="input-group mb-3">
                                <input type="text" name="kode" class="form-control" placeholder="Kode Daftar Tagihan" value="{{ old('kode') }}" required>
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="form-group">
                            <label>Status</label>
                            <select class="form-control select2" data-dropdown-css-class="select2-danger" id="status" name="status" required>
                              <option value="AKTIF" selected>Aktif</option>
                              <option value="TIDAK AKTIF">Tidak Aktif</option>
                            </select>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label>Sekolah</label>
                                <select class="form-control select2" data-dropdown-css-class="select2-danger" id="kode_sekolah" name="kode_sekolah" required>
                                    <option value="">Pilih Sekolah</option>
                                    @foreach ($sekolah as $item)
                                        <option value="{{ $item->kode }}" {{ old('kode_sekolah') == $item->kode ? 'selected' : '' }}>{{ $item->nama_sekolah }}</option>
                                    @endforeach
                                  </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label>Kelas</label>
                                <select class="form-control select2" data-dropdown-css-class="select2-danger" id="kode_kelas" name="kode_kelas" required disabled>
                                    <option value="">Pilih Kelas</option>
                                    @foreach ($kelas as $item)
                                        <option value="{{ $item->kode }}" {{ old('kode_kelas') == $item->kode ? 'selected' : '' }}>{{ $item->nama_kelas }}</option>
                                    @endforeach
                                  </select>
                                  <input type="hidden" id="old_kelas" value="{{ old('kode_kelas') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label>Yayasan</label>
                                <select class="form-control select2" data-dropdown-css-class="select2-danger" id="kode_yayasan" name="kode_yayasan" required>
                                    <option value="">Pilih Yayasan</option>
                                    @foreach ($yayasan as $item)
                                        <option value="{{ $item->kode }}" {{ old('kode_yayasan') == $item->kode ? 'selected' : '' }}>{{ $item->nama_yayasan }}</option>
                                    @endforeach
                                  </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label>Transaksi</label>
                                <select class="form-control select2" data-dropdown-css-class="select2-danger" id="kode_transaksi" name="kode_transaksi" required>
                                    <option value="">Pilih Transaksi</option>
                                    @foreach ($transaksi as $item)
                                        <option value="{{ $item->kode }}" {{ old('kode_transaksi') == $item->kode ? 'selected' : '' }}>{{ $item->nama_transaksi }}</option>
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
                                    <input type="text" name="nominal" class="form-control" placeholder="Nominal" value="{{ old('nominal') }}" required>
                                </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label>Presentase</label>
                                <div class="input-group mb-3">
                                    <input type="number" name="persen_yayasan" class="form-control" placeholder="Presentase Yayasan" value="{{ old('persen_yayasan') }}" min="0" max="100" required>
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
                                <input type="date" name="awal_pembayaran" class="form-control" placeholder="Awal Pembayaran" value="{{ old('awal_pembayaran') }}" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label>Akhir Pembayaran</label>
                                <input type="date" name="akhir_pembayaran" class="form-control" placeholder="Akhir Pembayaran" value="{{ old('akhir_pembayaran') }}" required>
                                </div>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('daftar_tagihan.index') }}" class="btn btn-secondary" type="button">Back</a>
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
        $('#kode_sekolah').on('change', function(){
            var kode_sekolah = $(this).val()
            if(!kode_sekolah){
                $('#kode_kelas').attr('disabled', true);
                return 0;
            }
            fetch(`/datakelas/${kode_sekolah}`, {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json'
                    }
            })
            .then((res) => res.json())
            .then(result => {
                $('#kode_kelas').attr('disabled', false);
                $('#kode_kelas').empty();
                $('#kode_kelas').append('<option value="">Pilih Kelas</option>');
                result.map(kelas => {
                    $('#kode_kelas').append(`<option value="${kelas.kode}">${kelas.nama_kelas}</option>`);
                })
            })
        })
        var old_kelas = $('#old_kelas').val();
        if(old_kelas){
            var kode_sekolah = $('#kode_sekolah').val()
            fetch(`/datakelas/${kode_sekolah}`, {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json'
                    }
            })
            .then((res) => res.json())
            .then(result => {
                $('#kode_kelas').attr('disabled', false);
                $('#kode_kelas').empty();
                $('#kode_kelas').append('<option value="">Pilih Kelas</option>');
                result.map(kelas => {
                    var selectValue = old_kelas == kelas.kode ? 'selected' : '';
                    $('#kode_kelas').append(`<option value="${kelas.kode}" ${selectValue}>${kelas.nama_kelas}</option>`);
                })
            })
        }
    </script>
@endsection