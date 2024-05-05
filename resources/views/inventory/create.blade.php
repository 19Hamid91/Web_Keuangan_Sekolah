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
            <h1 class="m-0">Tambah Data Inventory</h1>
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
                    <form action="{{ route('inven.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <h3 class="text-center font-weight-bold">Data Inventory</h3>
                        <br><br>
                        <div class="row">
                          <div class="col-sm-6">
                            <div class="form-group">
                            <label>Barang<span class="text-danger">*</span></label>
                            <select class="form-control select2" data-dropdown-css-class="select2-danger" style="width: 100%;" id="kode_barang" name="kode_barang" required>
                              <option value="">Pilih Barang</option>
                              @foreach ($barang as $item)
                                  <option value="{{ $item->kode }}" {{ old('kode_barang') == $item->kode ? 'selected' : '' }}>{{ $item->nama_barang }}</option>
                              @endforeach
                            </select>
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="form-group">
                            <label>Jenis Lokasi<span class="text-danger">*</span></label>
                            <select class="form-control select2" data-dropdown-css-class="select2-danger" style="width: 100%;" id="jenis_lokasi" name="jenis_lokasi" required>
                                <option value="Sekolah">Sekolah</option>
                                <option value="Yayasan">Yayasan</option>
                            </select>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-6">
                            <div id="div_sekolah" class="form-group">
                            <label>Sekolah<span class="text-danger">*</span></label>
                            <select class="form-control select2" data-dropdown-css-class="select2-danger" style="width: 100%;" id="kode_lokasi_sekolah" name="kode_lokasi_sekolah" required>
                                <option value="">Pilih Sekolah</option>
                                @foreach ($sekolah as $item)
                                    <option value="{{ $item->kode }}" {{ old('kode_lokasi') == $item->kode ? 'selected' : '' }}>{{ $item->nama_sekolah }}</option>
                                @endforeach
                              </select>
                            </div>
                            <div id="div_yayasan" class="form-group" style="display: none">
                            <label>Yayasan<span class="text-danger">*</span></label>
                            <select class="form-control select2" data-dropdown-css-class="select2-danger" style="width: 100%;" id="kode_lokasi_yayasan" name="kode_lokasi_yayasan">
                                <option value="">Pilih Yayasan</option>
                                @foreach ($yayasan as $item)
                                    <option value="{{ $item->kode }}" {{ old('kode_lokasi') == $item->kode ? 'selected' : '' }}>{{ $item->nama_yayasan }}</option>
                                @endforeach
                              </select>
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="form-group">
                            <label>Jumlah<span class="text-danger">*</span></label>
                            <input type="number" id="jumlah" name="jumlah" class="form-control" placeholder="Jumlah" value="1" required>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-6">
                            <div class="form-group">
                            <label>Lokasi Penyimpanan<span class="text-danger">*</span></label>
                            <input type="text" id="lokasi_penyimpanan" name="lokasi_penyimpanan" class="form-control" placeholder="Lokasi Penyimpanan" value="" required>
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="form-group">
                            <label>Kondisi<span class="text-danger">*</span></label>
                            <select class="form-control select2" data-dropdown-css-class="select2-danger" style="width: 100%;" id="kondisi" name="kondisi" required>
                              <option value="">Pilih Kondisi</option>
                              <option value="Baik">Baik</option>
                              <option value="Buruk">Buruk</option>
                            </select>
                            </div>
                          </div>
                        </div>
                        <div>
                            <a href="{{ url()->previous() }}" class="btn btn-secondary" type="button">Back</a>
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
      $(document).ready(function() {
      });

      $('#jenis_lokasi').change(function(){
        var jenis = $(this).val();
        if(jenis == 'Yayasan'){
          $('#div_yayasan').css('display', 'block');
          $('#kode_lokasi_yayasan').attr('required', true);
          $('#div_sekolah').css('display', 'none');
          $('#kode_lokasi_sekolah').attr('required', false);
        } else {
          $('#div_sekolah').css('display', 'block');
          $('#kode_lokasi_sekolah').attr('required', true);
          $('#div_yayasan').css('display', 'none');
          $('#kode_lokasi_yayasan').attr('required', false);
        }
      });
    </script>
@endsection