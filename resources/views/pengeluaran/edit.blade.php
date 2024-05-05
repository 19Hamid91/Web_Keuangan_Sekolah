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
            <h1 class="m-0">Edit Data Pengeluaran</h1>
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
                    <form action="{{ route('pengeluaran.update', ['pengeluaran' => $data->id]) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <h3 class="text-center font-weight-bold">Data Pengeluaran</h3>
                        <br><br>
                        <div class="row">
                          <div class="col-sm-6">
                            <div class="form-group">
                            <label>Kode<span class="text-danger">*</span></label>
                            <div class="input-group mb-3">
                                <input type="text" name="kode" class="form-control" placeholder="Kode pengeluaran" value="{{ old('kode') ?? $data->kode }}" required readonly>
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="form-group">
                            <label>Sekolah<span class="text-danger">*</span></label>
                            <select class="form-control select2" data-dropdown-css-class="select2-danger" style="width: 100%;" id="kode_sekolah" name="kode_sekolah" required>
                                <option value="">Pilih Sekolah</option>
                                @foreach ($sekolah as $item)
                                    <option value="{{ $item->kode }}" {{ $data->kode_sekolah == $item->kode ? 'selected' : '' }}>{{ $item->nama_sekolah }}</option>
                                @endforeach
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-6">
                            <div class="form-group">
                            <label>Transaksi<span class="text-danger">*</span></label>
                            <select class="form-control select2" data-dropdown-css-class="select2-danger" style="width: 100%;" id="kode_transaksi" name="kode_transaksi" required>
                                <option value="">Pilih Transaksi</option>
                                @foreach ($transaksi as $item)
                                    <option value="{{ $item->kode }}" {{ $data->kode_transaksi == $item->kode ? 'selected' : '' }}>{{ $item->nama_transaksi }}</option>
                                @endforeach
                              </select>
                            </div>
                          </div>
                          <div class="col-sm-6">
                              <div class="form-group">
                              <label>Jumlah Pengeluaran<span class="text-danger">*</span></label>
                              <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                  </div>
                                  <input type="text" id="nominal" name="nominal" class="form-control" placeholder="Nominal" value="{{ $data->nominal }}" required>
                              </div>
                              </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-6">
                            <div class="form-group">
                              <label>Bukti</label>
                              <div class="custom-file">
                                <input type="file" class="custom-file-input" id="bukti" name="bukti">
                                <label class="custom-file-label" for="bukti">Choose file</label>
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="form-group">
                            <label>Tanggal Bayar<span class="text-danger">*</span></label>
                            <input type="date" id="tanggal" name="tanggal" class="form-control" placeholder="Awal pengeluaran" value="{{ $data->tanggal }}" required>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-6">
                            <div class="row ml-1">
                              <label>Preview</label>
                              <img id="preview" src="{{ $data->bukti ? '/storage/' . $data->bukti : '' }}" alt="your image" style="max-width: 60%; height: auto;"/>
                            </div>
                          </div>
                        </div>
                        <div>
                            <a href="{{ route('pengeluaran.index') }}" class="btn btn-secondary" type="button">Back</a>
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
        var kode_tagihan = $('#kode_tagihan').val()
        if(kode_tagihan){
          data_tagihan();
        }
        if ($('#preview').attr('src') === '') {
            $('#preview').attr('src', defaultImg);
        }
      });
      $('#kode_tagihan').on('change', function() {
        data_tagihan();
      });
      $('#bukti').on('change', function() {
            const file = $(this)[0].files[0];
            if (file.size > 2 * 1024 * 1024) { 
                toastr.warning('Ukuran file tidak boleh lebih dari 2mb', {
                    closeButton: true,
                    tapToDismiss: false,
                    rtl: false,
                    progressBar: true
                });
                $(this).val(''); 
                return;
            }
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(file);
            }
        });
        function clearFile(){
            $('#bukti').val('');
            $('#preview').attr('src', defaultImg);
        };

      function data_tagihan(){
        var nominal = $('#kode_tagihan').find(':selected').data('nominal');
        $('#nominal').val(nominal);
        $('#jml_tagihan').val(nominal);
      };
    </script>
@endsection