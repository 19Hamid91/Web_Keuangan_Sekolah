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
            <h1 class="m-0">Tambah Presensi Karyawan</h1>
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
                    <form action="{{ route('presensi.store', ['instansi' => $instansi]) }}" method="post">
                        @csrf
                        <h3 class="text-center font-weight-bold">Data Presensi Karyawan</h3>
                        <br><br>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                <label>Karyawan</label>
                                <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" name="karyawan_id" required>
                                    <option value="">Pilih Karyawan</option>
                                    @foreach ($karyawans as $item)
                                        <option value="{{ $item->id }}" {{ old('karyawan_id') == $item->id ? 'selected' : '' }}>{{ $item->nama_gurukaryawan }}</option>
                                    @endforeach
                                </select>
                                </div>
                            </div>
                            <div class="col-sm-4">  
                                <div class="form-group">
                                <label>Tahun</label>
                                <input type="number" name="tahun" class="form-control" placeholder="Jumlah tahun" value="{{ old('tahun') ?? date('Y') }}" required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                <label>Bulan</label>
                                <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" name="bulan" required>
                                    <option value="Januari" {{ old('bulan') ==  'Januari' ? 'selected' : ''}}>Januari</option>
                                    <option value="Februari" {{ old('bulan') ==  'Februari' ? 'selected' : ''}}>Februari</option>
                                    <option value="Maret" {{ old('bulan') ==  'Maret' ? 'selected' : ''}}>Maret</option>
                                    <option value="April" {{ old('bulan') ==  'April' ? 'selected' : ''}}>April</option>
                                    <option value="Mei" {{ old('bulan') ==  'Mei' ? 'selected' : ''}}>Mei</option>
                                    <option value="Juni" {{ old('bulan') ==  'Juni' ? 'selected' : ''}}>Juni</option>
                                    <option value="Juli" {{ old('bulan') ==  'Juli' ? 'selected' : ''}}>Juli</option>
                                    <option value="Agustus" {{ old('bulan') ==  'Agustus' ? 'selected' : ''}}>Agustus</option>
                                    <option value="September" {{ old('bulan') ==  'September' ? 'selected' : ''}}>September</option>
                                    <option value="Oktober" {{ old('bulan') ==  'Oktober' ? 'selected' : ''}}>Oktober</option>
                                    <option value="November" {{ old('bulan') ==  'November' ? 'selected' : ''}}>November</option>
                                    <option value="Desember" {{ old('bulan') ==  'Desember' ? 'selected' : ''}}>Desember</option>

                                </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">  
                                <div class="form-group">
                                <label>Hadir</label>
                                <input type="number" name="hadir" class="form-control" placeholder="Jumlah Hadir" value="{{ old('hadir') ?? 0 }}" required>
                                </div>
                            </div>
                            <div class="col-sm-4">  
                                <div class="form-group">
                                <label>Sakit</label>
                                <input type="number" name="sakit" class="form-control" placeholder="Jumlah sakit" value="{{ old('sakit') ?? 0 }}" required>
                                </div>
                            </div>
                            <div class="col-sm-4">  
                                <div class="form-group">
                                <label>Izin</label>
                                <input type="number" name="izin" class="form-control" placeholder="Jumlah izin" value="{{ old('izin') ?? 0 }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">  
                                <div class="form-group">
                                <label>Alpha</label>
                                <input type="number" name="alpha" class="form-control" placeholder="Jumlah alpha" value="{{ old('alpha') ?? 0 }}" required>
                                </div>
                            </div>
                            <div class="col-sm-4">  
                                <div class="form-group">
                                <label>Lembur</label>
                                <input type="number" name="lembur" class="form-control" placeholder="Jumlah lembur" value="{{ old('lembur') ?? 0 }}" required>
                                </div>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('presensi.index', ['instansi' => $instansi]) }}" class="btn btn-secondary" type="button">Back</a>
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
    </script>
@endsection