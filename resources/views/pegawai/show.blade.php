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
            <h1 class="m-0">Detail Data Guru & Karyawan</h1>
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
                    <h3 class="text-center font-weight-bold">Data Guru & Karyawan</h3>
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
                            <label>Nama Guru & Karyawan</label>
                            <input type="text" name="nama_gurukaryawan" class="form-control" placeholder="Nama Guru & Karyawan" value="{{ $pegawai->nama_gurukaryawan }}" disabled>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                            <label>NIP</label>
                            <input type="number" name="nip" class="form-control" placeholder="NIP" value="{{ $pegawai->nip }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                            <label>Nomor Handphone</label>
                            <input type="number" name="no_hp_gurukaryawan" class="form-control" placeholder="No Handphone Guru & Karyawan" value="{{ $pegawai->no_hp_gurukaryawan }}" disabled>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" name="jenis_kelamin" disabled>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="laki-laki" {{ $pegawai->jenis_kelamin == "laki-laki" ? 'selected' : '' }}>Laki-laki</option>
                                <option value="perempuan" {{ $pegawai->jenis_kelamin == "perempuan" ? 'selected' : '' }}>Perempuan</option>
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
                            <label>Instasi</label>
                            <select class="form-control select2" data-dropdown-css-class="select2-danger" style="width: 100%;" id="instansi_id" name="instansi_id" disabled>
                                <option value="{{ $data_instansi->id }}" {{ $pegawai->instansi_id == $data_instansi->id ? 'selected' : '' }}>{{ $data_instansi->nama_instansi }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                            <label>Jabatan</label>
                            <select class="form-control select2" data-dropdown-css-class="select2-danger" style="width: 100%;" id="jabatan_id" name="jabatan_id" disabled>
                                <option value="">Pilih Jabatan</option>
                                @foreach ($jabatans as $item)
                                    <option value="{{ $item->id }}" {{ $pegawai->jabatan_id == $item->id ? 'selected' : '' }}>{{ $item->jabatan }}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                            <label>Status Kawin</label>
                            <select class="form-control select2" data-dropdown-css-class="select2-danger" style="width: 100%;" id="status_kawin" name="status_kawin" disabled>
                                <option value="Menikah" {{ $pegawai->status_kawin == 'Menikah' ? 'selected' : '' }}>Menikah</option>
                                <option value="Belum Menikah" {{ $pegawai->status_kawin == 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah</option>
                            </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                            <label>Jumlah Anak</label>
                            <input type="number" name="jumlah_anak" id="jumlah_anak" class="form-control" value="{{ $pegawai->jumlah_anak }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                            <label>Alamat</label>
                            <textarea class="form-control" name="alamat_gurukaryawan" rows="3" placeholder="Alamat" disabled>{{ $pegawai->alamat_gurukaryawan }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('pegawai.index', ['instansi' => $instansi]) }}" class="btn btn-secondary" type="button">Batal</a>
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