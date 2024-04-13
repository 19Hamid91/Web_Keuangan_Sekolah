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
            <h1 class="m-0">Detail Data Pegawai</h1>
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
                    <h3 class="text-center font-weight-bold">Data Pegawai</h3>
                    <br><br>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" name="status" disabled>
                                    <option value="AKTIF" {{ $pegawai->status == "AKTIF" ? 'selected' : '' }}>AKTIF</option>
                                    <option value="TIDAK AKTIF" {{ $pegawai->status == "TIDAK AKTIF" ? 'selected' : '' }}>TIDAK AKTIF</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                            <label>Nama Pegawai</label>
                            <input type="text" name="nama_pegawai" class="form-control" placeholder="Nama Pegawai" value="{{ $pegawai->nama_pegawai }}" disabled>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                            <label>NIP</label>
                            <input type="text" name="nip" class="form-control" placeholder="NIP" value="{{ $pegawai->nip }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                            <label>Nomor Handphone</label>
                            <input type="text" name="no_hp_pegawai" class="form-control" placeholder="No Handphone Pegawai" value="{{ $pegawai->no_hp_pegawai }}" disabled>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" name="jenis_kelamin" disabled>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="laki-laki" {{ $pegawai->jenis_kelamin == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="perempuan" {{ $pegawai->jenis_kelamin == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                            <label>Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control" placeholder="Tempat Lahir" value="{{ $pegawai->tempat_lahir }}" disabled>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                            <label>Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control" placeholder="Tanggal Lahir" value="{{ $pegawai->tanggal_lahir }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                            <label>Sekolah</label>
                            <select class="form-control select2" data-dropdown-css-class="select2-danger" id="kode_sekolah" name="kode_sekolah" disabled>
                                <option value="">Pilih Sekolah</option>
                                @foreach ($sekolah as $item)
                                    <option value="{{ $item->kode }}" {{ $pegawai->kode_sekolah == $item->kode ? 'selected' : '' }}>{{ $item->nama_sekolah }}</option>
                                @endforeach
                              </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                            <label>Jabatan</label>
                            <input type="text" name="jabatan" class="form-control" placeholder="Jabatan" value="{{ $pegawai->jabatan }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                            <label>Alamat</label>
                            <textarea class="form-control" name="alamat" rows="3" placeholder="Alamat" disabled>{{ $pegawai->alamat }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('pegawai.index') }}" class="btn btn-secondary" type="button">Back</a>
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
            var kode_kelas = $('#kode_kelas').data('kelas')
            var kode_sekolah = $('#kode_sekolah').val()
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            fetch(`/datakelas/${kode_sekolah}`, {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json'
                    }
            })
            .then((res) => res.json())
            .then(result => {
                $('#kode_kelas').empty();
                $('#kode_kelas').append('<option value="">Pilih Kelas</option>');
                result.map(kelas => {
                    var selectValue = kelas.kode == kode_kelas ? 'selected' : '';
                    $('#kode_kelas').append(`<option value="${kelas.kode}" ${selectValue}>${kelas.nama_kelas}</option>`);
                })
                $('#kode_kelas').attr('disabled', true);
            })
        })
    </script>
@endsection