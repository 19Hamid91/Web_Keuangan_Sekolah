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
            <h1 class="m-0">Tambah Data Kenaikan</h1>
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
                    <form action="{{ route('kenaikan.store', ['instansi' => $instansi]) }}" method="post">
                        @csrf
                        <h3 class="text-center font-weight-bold">Data Kenaikan</h3>
                        <br><br>
                        <div class="row">
                          <div class="col-sm-6">
                            <div class="form-group">
                            <label>Siswa</label>
                            <select class="form-control select2" data-dropdown-css-class="select2-danger" style="width: 100%" id="siswa_id" name="siswa_id" required>
                                <option value="">Pilih Siswa</option>
                                @foreach ($siswa as $item)
                                    <option value="{{ $item->id }}" {{ old('siswa_id') == $item->id ? 'selected' : '' }} data-instansi="{{ $item->instansi_id }}" data-kelas="{{ $item->kelas_id }}">({{ $item->nis }}) {{ $item->nama_siswa }}</option>
                                @endforeach
                            </select>
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="form-group">
                            <label>Tanggal</label>
                            <div class="input-group mb-3">
                              <input type="date" name="tanggal" class="form-control" placeholder="Tanggal" value="{{ old('tanggal') ?? date('Y-m-d') }}" required>
                            </div>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-6">
                              <div class="form-group">
                              <label>Instansi</label>
                              <select class="form-control select2" data-dropdown-css-class="select2-danger" style="width: 100%" id="instansi_id" name="instansi_id" disabled>
                                  @foreach ($instansis as $item)
                                      <option value="{{ $item->id }}" {{ old('instansi_id') == $item->id ? 'selected' : '' }}>{{ $item->nama_instansi }}</option>
                                  @endforeach
                                </select>
                              </div>
                          </div>
                          <div class="col-sm-6">
                              <div class="form-group">
                              <label>Tahun Ajaran</label>
                              <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" id="tahun_ajaran_id" name="tahun_ajaran_id" required>
                                  @foreach ($tahun_ajaran as $item)
                                      <option value="{{ $item->id }}" {{ old('tahun_ajaran_id') == $item->id ? 'selected' : '' }}>{{ $item->thn_ajaran }}</option>
                                  @endforeach
                                </select>
                              </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-6">
                            <div class="form-group">
                            <label>Kelas Awal</label>
                            <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" id="kelas_awal" name="kelas_awal" disabled>
                                <option value="">Pilih Kelas Awal</option>
                                @foreach ($kelas as $item)
                                      <option value="{{ $item->id }}" {{ old('kelas_awal') == $item->id ? 'selected' : '' }}>{{ $item->kelas }}-{{ $item->grup_kelas }}</option>
                                  @endforeach
                              </select>
                              <input type="hidden" id="kelas_awal_hid" name="kelas_awal" value="{{ old('kelas_awal') }}">
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="form-group">
                            <label>Kelas Akhir</label>
                            <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" id="kelas_akhir" name="kelas_akhir" required>
                                <option value="">Pilih Kelas Akhir</option>
                                @foreach ($kelas as $item)
                                      <option value="{{ $item->id }}" {{ old('kelas_akhir') == $item->id ? 'selected' : '' }}>{{ $item->kelas }}-{{ $item->grup_kelas }}</option>
                                  @endforeach
                              </select>
                              <input type="hidden" id="kelas_akhir" value="{{ old('kelas_akhir') }}">
                            </div>
                          </div>
                        </div>
                        <div>
                            <a href="{{ route('kenaikan.index', ['instansi' => $instansi]) }}" class="btn btn-secondary" type="button">Batal</a>
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
                $('#kelas_awal_hid').val(selectedOption.data('kelas'));
            } else {
                $('#instansi_id').val('').trigger('change');
                $('#kelas_awal').val('').trigger('change');
                $('#kelas_awal_hid').val('');
            }
        })
    </script>
@endsection