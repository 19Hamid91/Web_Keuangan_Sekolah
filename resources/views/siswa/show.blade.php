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
            <h1 class="m-0">Detail Data Siswa</h1>
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
                    <h3 class="text-center font-weight-bold">Data Siswa</h3>
                    <br><br>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" name="status" disabled>
                                    <option value="AKTIF" {{ $siswa->status == "AKTIF" ? 'selected' : '' }}>AKTIF</option>
                                    <option value="TIDAK AKTIF" {{ $siswa->status == "TIDAK AKTIF" ? 'selected' : '' }}>TIDAK AKTIF</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" placeholder="Nama Siswa" value="{{ $siswa->nama_siswa }}" disabled>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                            <label>NIS</label>
                            <input type="text" name="nis" class="form-control" placeholder="NIS" value="{{ $siswa->nis }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                            <label>Nomor Handphone</label>
                            <input type="text" name="no_hp_siswa" class="form-control" placeholder="No Handphone Siswa" value="{{ $siswa->no_hp_siswa }}" disabled>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" name="jenis_kelamin" disabled>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="laki-laki" {{ $siswa->jenis_kelamin == "laki-laki" ? 'selected' : '' }}>Laki-laki</option>
                                <option value="perempuan" {{ $siswa->jenis_kelamin == "perempuan" ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                            <label>Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control" placeholder="Tempat Lahir" value="{{ $siswa->tempat_lahir }}" disabled>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                            <label>Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control" placeholder="Tanggal Lahir" value="{{ $siswa->tanggal_lahir }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                            <label>Sekolah</label>
                            <select class="form-control select2" data-dropdown-css-class="select2-danger" style="width: 100%;" id="kode_sekolah" name="kode_sekolah" disabled>
                                <option value="">Pilih Sekolah</option>
                                @foreach ($sekolah as $item)
                                    <option value="{{ $item->kode }}" {{ $siswa->kode_sekolah == $item->kode ? 'selected' : '' }}>{{ $item->nama_sekolah }}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                            <label>Kelas</label>
                            <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" id="kode_kelas" name="kode_kelas" data-kelas="{{ $siswa->kode_kelas }}" disabled disabled>
                                <option value="">Pilih Kelas</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                            <label>Alamat</label>
                            <textarea class="form-control" name="alamat" rows="3" placeholder="Alamat" disabled>{{ $siswa->alamat }}</textarea>
                            </div>
                        </div>
                    </div>
                    <br>
                    <hr>
                    <br>
                    <h3 class="text-center font-weight-bold">Data Wali</h3>
                    <br><br>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                            <label>Nama Wali</label>
                            <input type="text" name="nama_wali" class="form-control" placeholder="Nama Wali" value="{{ $siswa->nama_wali }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                            <label>Pekerjaan Wali</label>
                            <input type="text" name="pekerjaan_wali" class="form-control" placeholder="Pekerjaan Wali" value="{{ $siswa->pekerjaan_wali }}" disabled>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                            <label>Nomor Handphone</label>
                            <input type="text" name="no_hp_wali" class="form-control" placeholder="No Handphone Wali" value="{{ $siswa->no_hp_wali }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('siswa.index') }}" class="btn btn-secondary" type="button">Back</a>
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