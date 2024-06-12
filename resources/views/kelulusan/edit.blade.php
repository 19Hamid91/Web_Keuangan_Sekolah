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
            <h1 class="m-0">Edit Data Kelulusan</h1>
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
                    <form action="{{ route('kelulusan.update', ['kelulusan' => $data->id, 'instansi' => $instansi]) }}" method="post">
                        @csrf
                        @method('patch')
                        <h3 class="text-center font-weight-bold">Data Kelulusan</h3>
                        <br><br>
                        <div class="row">
                          <div class="col-sm-6">
                            <div class="form-group">
                            <label>Siswa</label>
                            <select class="form-control select2" style="width: 100%"  data-dropdown-css-class="select2-danger" id="siswa_id" name="siswa_id" required>
                                <option value="">Pilih Siswa</option>
                                @foreach ($siswa as $item)
                                    <option value="{{ $item->id }}" {{ $data->siswa_id == $item->id ? 'selected' : '' }} data-instansi="{{ $item->instansi_id }}" data-kelas="{{ $item->kelas_id }}">({{ $item->nis }}) {{ $item->nama_siswa }}</option>
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
                        <div class="row">
                          <div class="col-sm-4">
                              <div class="form-group">
                              <label>Instansi</label>
                              <select class="form-control select2" data-dropdown-css-class="select2-danger" style="width: 100%" id="instansi_id" name="instansi_id" disabled>
                                  @foreach ($instansis as $item)
                                      <option value="{{ $item->id }}" {{ $data->instansi_id == $item->id ? 'selected' : '' }}>{{ $item->nama_instansi }}</option>
                                  @endforeach
                                </select>
                              </div>
                          </div>
                          <div class="col-sm-4">
                              <div class="form-group">
                              <label>Tahun Ajaran</label>
                              <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" id="tahun_ajaran_id" name="tahun_ajaran_id" required>
                                  @foreach ($tahun_ajaran as $item)
                                      <option value="{{ $item->id }}" {{ $data->tahun_ajaran_id == $item->id ? 'selected' : '' }}>{{ $item->thn_ajaran }}</option>
                                  @endforeach
                                </select>
                              </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                            <label>Kelas</label>
                            <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" id="kelas_id" name="kelas_id" disabled>
                                @foreach ($kelas as $item)
                                      <option value="{{ $item->id }}" {{ $data->kelas_id == $item->id ? 'selected' : '' }}>{{ $item->grup_kelas }}{{ $item->kelas }}</option>
                                  @endforeach
                              </select>
                            </div>
                          </div>
                        </div>
                        <div>
                            <a href="{{ route('kelulusan.index', ['instansi' => $instansi]) }}" class="btn btn-secondary" type="button">Back</a>
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
        $('#siswa_id').on('change', function(){
            var siswa_id = $(this).val()
            if (siswa_id) {
                var selectedOption = $(this).find(':selected');
                $('#instansi_id').val(selectedOption.data('instansi')).trigger('change');
                $('#kelas_awal').val(selectedOption.data('kelas')).trigger('change');
            } else {
                $('#instansi_id').val('').trigger('change');
                $('#kelas_awal').val('').trigger('change');
            }
        })
    </script>
@endsection