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
                            <input type="number" name="nis" class="form-control" placeholder="NIS" value="{{ $siswa->nis }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                            <label>Nomor Handphone</label>
                            <input type="number" name="nohp_siswa" class="form-control" placeholder="No Handphone Siswa" value="{{ $siswa->nohp_siswa }}" disabled>
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
                            <label>Instansi</label>
                            <select class="form-control select2" data-dropdown-css-class="select2-danger" style="width: 100%;" id="instansi_id" name="instansi_id" disabled>
                                <option value="">Pilih Instansi</option>
                                <option value="{{ $instansis->id }}" {{ $siswa->instansi_id == $instansis->id ? 'selected' : '' }}>{{ $instansis->nama_instansi }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                            <label>Kelas</label>
                            <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" id="kelas_id" name="kelas_id" disabled>
                                <option value="">Pilih Kelas</option>
                                @foreach ($instansis->kelas as $item)
                                        <option value="{{ $item->id }}" {{ $siswa->kelas_id == $item->id ? 'selected' : '' }}>{{ $item->tingkat }}-{{ $item->kelas }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                            <label>Alamat</label>
                            <textarea class="form-control" name="alamat_siswa" placeholder="Alamat" disabled>{{ $siswa->alamat_siswa }}</textarea>
                            </div>
                        </div>
                    </div>
                    <br>
                    <hr>
                    <br>
                    <h3 class="text-center font-weight-bold">Data Wali</h3>
                    <br><br>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                            <label>Nama Wali</label>
                            <input type="text" name="nama_wali_siswa" class="form-control" placeholder="Nama Wali" value="{{ $siswa->nama_wali_siswa }}" disabled>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                            <label>Email Wali</label>
                            <input type="email" name="email_wali_siswa" id="email_wali_siswa" class="form-control" placeholder="Email Wali" value="{{ $siswa->email_wali_siswa }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                            <label>Pekerjaan Wali</label>
                            <input type="text" name="pekerjaan_wali_siswa" class="form-control" placeholder="Pekerjaan Wali" value="{{ $siswa->pekerjaan_wali_siswa }}" disabled>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                            <label>Nomor Handphone</label>
                            <input type="number" name="nohp_wali_siswa" class="form-control" placeholder="No Handphone Wali" value="{{ $siswa->nohp_wali_siswa }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('siswa.index', ['instansi' => $instansi]) }}" class="btn btn-secondary" type="button">Batal</a>
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
            var kode_instansi = $('#kode_instansi').val()
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            fetch(`/datakelas/${kode_instansi}`, {
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