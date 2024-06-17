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
            <h1 class="m-0">Detail Presensi Karyawan</h1>
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
                  <h3 class="text-center font-weight-bold">Data Presensi Karyawan</h3>
                  <br><br>
                  <div class="row">
                      <div class="col-sm-4">
                          <div class="form-group">
                          <label>Karyawan</label>
                          <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" name="karyawan_id" disabled>
                              <option value="">Pilih Karyawan</option>
                              @foreach ($karyawans as $item)
                                  <option value="{{ $item->id }}" {{ $data->karyawan_id == $item->id ? 'selected' : '' }}>{{ $item->nama_gurukaryawan }}</option>
                              @endforeach
                          </select>
                          </div>
                      </div>
                      <div class="col-sm-4">  
                          <div class="form-group">
                          <label>Tahun</label>
                          <input type="number" name="tahun" class="form-control" placeholder="Jumlah tahun" value="{{ $data->tahun ?? date('Y') }}" disabled>
                          </div>
                      </div>
                      <div class="col-sm-4">
                          <div class="form-group">
                          <label>Bulan</label>
                          <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" name="bulan" disabled>
                              <option value="Januari" {{ $data->bulan ==  'Januari' ? 'selected' : ''}}>Januari</option>
                              <option value="Februari" {{ $data->bulan ==  'Februari' ? 'selected' : ''}}>Februari</option>
                              <option value="Maret" {{ $data->bulan ==  'Maret' ? 'selected' : ''}}>Maret</option>
                              <option value="April" {{ $data->bulan ==  'April' ? 'selected' : ''}}>April</option>
                              <option value="Mei" {{ $data->bulan ==  'Mei' ? 'selected' : ''}}>Mei</option>
                              <option value="Juni" {{ $data->bulan ==  'Juni' ? 'selected' : ''}}>Juni</option>
                              <option value="Juli" {{ $data->bulan ==  'Juli' ? 'selected' : ''}}>Juli</option>
                              <option value="Agustus" {{ $data->bulan ==  'Agustus' ? 'selected' : ''}}>Agustus</option>
                              <option value="September" {{ $data->bulan ==  'September' ? 'selected' : ''}}>September</option>
                              <option value="Oktober" {{ $data->bulan ==  'Oktober' ? 'selected' : ''}}>Oktober</option>
                              <option value="November" {{ $data->bulan ==  'November' ? 'selected' : ''}}>November</option>
                              <option value="Desember" {{ $data->bulan ==  'Desember' ? 'selected' : ''}}>Desember</option>

                          </select>
                          </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-sm-4">  
                          <div class="form-group">
                          <label>Hadir</label>
                          <input type="number" name="hadir" class="form-control" placeholder="Jumlah Hadir" value="{{ $data->hadir ?? 0 }}" disabled>
                          </div>
                      </div>
                      <div class="col-sm-4">  
                          <div class="form-group">
                          <label>Sakit</label>
                          <input type="number" name="sakit" class="form-control" placeholder="Jumlah sakit" value="{{ $data->sakit ?? 0 }}" disabled>
                          </div>
                      </div>
                      <div class="col-sm-4">  
                          <div class="form-group">
                          <label>Izin</label>
                          <input type="number" name="izin" class="form-control" placeholder="Jumlah izin" value="{{ $data->izin ?? 0 }}" disabled>
                          </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-sm-4">  
                          <div class="form-group">
                          <label>Alpha</label>
                          <input type="number" name="alpha" class="form-control" placeholder="Jumlah alpha" value="{{ $data->alpha ?? 0 }}" disabled>
                          </div>
                      </div>
                      <div class="col-sm-4">  
                          <div class="form-group">
                          <label>Lembur</label>
                          <input type="number" name="lembur" class="form-control" placeholder="Jumlah lembur" value="{{ $data->lembur ?? 0 }}" disabled>
                          </div>
                      </div>
                  </div>
                  <div>
                      <a href="{{ route('presensi.index', ['instansi' => $instansi]) }}" class="btn btn-secondary" type="button">batal</a>
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
    </script>
@endsection