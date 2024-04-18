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
            <h1 class="m-0">Edit Data Kenaikan</h1>
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
                    <form action="{{ route('kenaikan.update', ['kenaikan' => $data->id]) }}" method="post">
                        @csrf
                        @method('patch')
                        <h3 class="text-center font-weight-bold">Data Kenaikan</h3>
                        <br><br>
                        <div class="row">
                          <div class="col-sm-12">
                              <div class="form-group">
                              <label>Kode</label>
                              <div class="input-group mb-3">
                                <input type="text" name="kode" class="form-control" placeholder="Kode" value="{{ $data->kode }}" readonly>
                              </div>
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
                                      <option value="{{ $item->kode }}" {{ $data->kode_sekolah == $item->kode ? 'selected' : '' }}>{{ $item->nama_sekolah }}</option>
                                  @endforeach
                                </select>
                              </div>
                          </div>
                          <div class="col-sm-6">
                              <div class="form-group">
                              <label>Tahun Ajaran</label>
                              <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" id="kode_tahun_ajaran" name="kode_tahun_ajaran" required>
                                  @foreach ($tahun_ajaran as $item)
                                      <option value="{{ $item->kode }}" {{ $data->kode == $item->kode ? 'selected' : '' }}>{{ $item->tahun_ajaran }}</option>
                                  @endforeach
                                </select>
                              </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-6">
                            <div class="form-group">
                            <label>Kelas Awal</label>
                            <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" id="kode_kelas_awal" name="kode_kelas_awal" required disabled>
                                <option value="">Pilih Kelas Awal</option>
                                @foreach ($kelas as $item)
                                      <option value="{{ $item->kode }}" {{ $data->kode == $item->kode ? 'selected' : '' }}>{{ $item->nama_kelas }}</option>
                                  @endforeach
                              </select>
                              <input type="hidden" id="kelas_awal" value="{{ $data->kode_kelas_awal }}">
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="form-group">
                            <label>Kelas</label>
                            <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" id="kode_kelas_akhir" name="kode_kelas_akhir" required disabled>
                                <option value="">Pilih Kelas Akhir</option>
                                @foreach ($kelas as $item)
                                      <option value="{{ $item->kode }}" {{ $data->kode == $item->kode ? 'selected' : '' }}>{{ $item->nama_kelas }}</option>
                                  @endforeach
                              </select>
                              <input type="hidden" id="kelas_akhir" value="{{ $data->kode_kelas_akhir }}">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-6">
                            <div class="form-group">
                            <label>Siswa</label>
                            <select class="form-control select2" data-dropdown-css-class="select2-danger" id="nis_siswa" name="nis_siswa" required>
                                <option value="">Pilih Siswa</option>
                                @foreach ($siswa as $item)
                                    <option value="{{ $item->nis }}" {{ $data->nis_siswa == $item->nis ? 'selected' : '' }}>{{ $item->nama_siswa }}</option>
                                @endforeach
                            </select>
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="form-group">
                            <label>Tanggal</label>
                            <div class="input-group mb-3">
                              <input type="date" name="tanggal" class="form-control" placeholder="Tanggal" value="{{ $data->tanggal ?? date('Y-m-d') }}">
                            </div>
                            </div>
                          </div>
                        </div>
                        <div>
                            <a href="{{ route('kenaikan.index') }}" class="btn btn-secondary" type="button">Back</a>
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
                $('#kode_kelas_awal').attr('disabled', false);
                $('#kode_kelas_awal').empty();
                $('#kode_kelas_awal').append('<option value="">Pilih Kelas</option>');
                result.map(kelas => {
                    $('#kode_kelas_awal').append(`<option value="${kelas.kode}">${kelas.nama_kelas}</option>`);
                })
                $('#kode_kelas_akhir').attr('disabled', false);
                $('#kode_kelas_akhir').empty();
                $('#kode_kelas_akhir').append('<option value="">Pilih Kelas</option>');
                result.map(kelas => {
                    $('#kode_kelas_akhir').append(`<option value="${kelas.kode}">${kelas.nama_kelas}</option>`);
                })
            })
        })
        var kelas_awal = $('#kelas_awal').val();
        var kelas_akhir = $('#kelas_akhir').val();
        if(kelas_awal || kelas_akhir){
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
                $('#kode_kelas_awal').attr('disabled', false);
                $('#kode_kelas_awal').empty();
                $('#kode_kelas_awal').append('<option value="">Pilih Kelas</option>');
                result.map(kelas => {
                  var selectValue = kelas_awal == kelas.kode ? 'selected' : '';
                  $('#kode_kelas_awal').append(`<option value="${kelas.kode}" ${selectValue}>${kelas.nama_kelas}</option>`);
                })
                $('#kode_kelas_akhir').attr('disabled', false);
                $('#kode_kelas_akhir').empty();
                $('#kode_kelas_akhir').append('<option value="">Pilih Kelas</option>');
                result.map(kelas => {
                  var selectValue = kelas_akhir == kelas.kode ? 'selected' : '';
                  $('#kode_kelas_akhir').append(`<option value="${kelas.kode}" ${selectValue}>${kelas.nama_kelas}</option>`);
                })
            })
        }
    </script>
@endsection