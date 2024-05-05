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
            <h1 class="m-0">Detail Log Inventory</h1>
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
                  <h3 class="text-center font-weight-bold">Data Inventory</h3>
                  <br><br>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                      <label>Jenis Lokasi<span class="text-danger">*</span></label>
                      <select class="form-control select2" data-dropdown-css-class="select2-danger" style="width: 100%;" id="jenis_lokasi" name="jenis_lokasi" disabled>
                          <option value="Sekolah" {{ $data->jenis_lokasi == 'Sekolah' ? 'selected' : '' }}>Sekolah</option>
                          <option value="Yayasan" {{ $data->jenis_lokasi == 'Yayasan' ? 'selected' : '' }}>Yayasan</option>
                      </select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div id="div_sekolah" class="form-group">
                      <label>Sekolah<span class="text-danger">*</span></label>
                      <select class="form-control select2" data-dropdown-css-class="select2-danger" style="width: 100%;" id="kode_lokasi_sekolah" name="kode_lokasi_sekolah" disabled>
                          <option value="">Pilih Sekolah</option>
                          @foreach ($sekolah as $item)
                              <option value="{{ $item->kode }}" {{ $data->kode_lokasi == $item->kode ? 'selected' : '' }}>{{ $item->nama_sekolah }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div id="div_yayasan" class="form-group" style="display: none">
                      <label>Yayasan<span class="text-danger">*</span></label>
                      <select class="form-control select2" data-dropdown-css-class="select2-danger" style="width: 100%;" id="kode_lokasi_yayasan" name="kode_lokasi_yayasan">
                          <option value="">Pilih Yayasan</option>
                          @foreach ($yayasan as $item)
                              <option value="{{ $item->kode }}" {{ $data->kode_lokasi == $item->kode ? 'selected' : '' }}>{{ $item->nama_yayasan }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                      <label>Barang<span class="text-danger">*</span></label>
                      <select class="form-control select2" data-dropdown-css-class="select2-danger" style="width: 100%;" id="kode_barang" name="kode_barang" disabled>
                        <option value="">Pilih Barang</option>
                        @foreach ($barang as $item)
                            <option value="{{ $item->barang->kode }}" {{ $data->kode_barang == $item->barang->kode ? 'selected' : '' }} data-kondisi="{{ $item->kondisi }}">{{ $item->barang->nama_barang }}  - {{ $item->kondisi }}</option>
                        @endforeach
                      </select>
                      <input type="hidden" id="kondisi" name="kondisi" value="">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                      <label>Jumlah<span class="text-danger">*</span></label>
                      <input type="number" id="jumlah" name="jumlah" class="form-control" placeholder="Jumlah" value="{{ $data->jumlah ?? 0 }}" disabled>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                      <label>Peminjam<span class="text-danger">*</span></label>
                      <input type="text" id="peminjam" name="peminjam" class="form-control" placeholder="Peminjam" value="{{ $data->peminjam }}" disabled>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                      <label>Tanggal Pinjam<span class="text-danger">*</span></label>
                      <input type="date" id="tanggal_pinjam" name="tanggal_pinjam" class="form-control" placeholder="Tanggal Pinjam" value="{{ $data->tanggal_pinjam }}" disabled>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                      <label>Alasan<span class="text-danger">*</span></label>
                      <textarea name="alasan" id="alasan" class="form-control" disabled>{{ $data->alasan }}</textarea>
                      </div>
                    </div>
                  </div>
                  <div>
                      <a href="{{ url()->previous() }}" class="btn btn-secondary" type="button">Back</a>
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
      var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      $(document).ready(function() {
        $('#jenis_lokasi').trigger('change')
        $('#kode_barang').trigger('change')
      });
      $('#kode_barang').change(function() {
          var kondisi = $(this).find(':selected').data('kondisi');
          $('#kondisi').val(kondisi);
      });
      $('#jenis_lokasi').change(function(){
        var jenis = $(this).val();
        if(jenis == 'Yayasan'){
          $('#div_yayasan').css('display', 'block');
          $('#kode_lokasi_yayasan').attr('disabled', true);
          $('#kode_lokasi_yayasan').attr('required', true);
          $('#div_sekolah').css('display', 'none');
          $('#kode_lokasi_sekolah').attr('disabled', false);
          $('#kode_lokasi_sekolah').attr('required', false);
        } else {
          $('#div_sekolah').css('display', 'block');
          $('#kode_lokasi_sekolah').attr('disabled', true);
          $('#kode_lokasi_sekolah').attr('required', true);
          $('#div_yayasan').css('display', 'none');
          $('#kode_lokasi_yayasan').attr('disabled', false);
          $('#kode_lokasi_yayasan').attr('required', false);
        }
      });
    </script>
@endsection