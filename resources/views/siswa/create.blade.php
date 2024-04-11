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
            <h1 class="m-0">Tambah Data Siswa</h1>
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
                    <form action="{{ route('siswa.store') }}" method="post">
                        @csrf
                        <h3 class="text-center font-weight-bold">Data Siswa</h3>
                        <br><br>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label>Nama Siswa</label>
                                <input type="text" name="nama_siswa" class="form-control" placeholder="Nama Siswa" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label>NIS</label>
                                <input type="text" name="nis" class="form-control" placeholder="NIS" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label>Nomor Handphone</label>
                                <input type="text" name="no_hp_siswa" class="form-control" placeholder="No Handphone Siswa" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label>Jenis Kelamin</label>
                                <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" name="jenis_kelamin" required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="laki-laki">Laki-laki</option>
                                    <option value="perempuan">Perempuan</option>
                                </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label>Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" class="form-control" placeholder="Tempat Lahir" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label>Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" class="form-control" placeholder="Tanggal Lahir" required>
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
                                        <option value="{{ $item->kode }}">{{ $item->nama_sekolah }}</option>
                                    @endforeach
                                  </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label>Kelas</label>
                                <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" id="kode_kelas" name="kode_kelas" required disabled>
                                    <option value="">Pilih Kelas</option>
                                  </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                <label>Alamat</label>
                                <textarea class="form-control" name="alamat" rows="3" placeholder="Alamat" required></textarea>
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
                                <input type="text" name="nama_wali" class="form-control" placeholder="Nama Wali" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label>Pekerjaan Wali</label>
                                <input type="text" name="pekerjaan_wali" class="form-control" placeholder="Pekerjaan Wali" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label>Nomor Handphone</label>
                                <input type="text" name="no_hp_wali" class="form-control" placeholder="No Handphone Wali" required>
                                </div>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('siswa.index') }}" class="btn btn-secondary" type="button">Back</a>
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
        $('#kode_sekolah').on('change', function(){
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
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
    </script>
@endsection