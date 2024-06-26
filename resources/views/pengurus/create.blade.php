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
            <h1 class="m-0">Tambah Data Pengurus</h1>
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
                    <form action="{{ route('pengurus.store', ['instansi' => $instansi]) }}" method="post">
                        @csrf
                        <h3 class="text-center font-weight-bold">Data Pengurus</h3>
                        <br><br>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label>Nama Pengurus</label>
                                <input type="text" name="nama_pengurus" id="nama_pengurus" class="form-control" placeholder="Nama Pengurus" value="{{ old('nama_pengurus') }}" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label>Nomor Handphone</label>
                                <input type="text" name="no_hp_pengurus" id="no_hp_pengurus" class="form-control" placeholder="No Handphone" value="{{ old('no_hp_pengurus') }}" required oninput="validatePhoneNumber(this)">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label>Instansi</label>
                                <select class="form-control select2" data-dropdown-css-class="select2-danger" style="width: 100%;" id="instansi_id" name="instansi_id" required>
                                        <option value="{{ $data_instansi->id }}" {{ old('instansi_id') == $data_instansi->id ? 'selected' : '' }}>{{ $data_instansi->nama_instansi }}</option>
                                  </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label>Jabatan</label>
                                <input type="text" name="jabatan" id="jabatan" class="form-control" placeholder="Nama Pengurus" value="{{ old('jabatan') }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                <label>Alamat</label>
                                <textarea class="form-control" name="alamat_pengurus" rows="3" placeholder="Alamat" required>{{ old('alamat_pengurus') }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('pengurus.index', ['instansi' => $instansi]) }}" class="btn btn-secondary" type="button">Batal</a>
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
      $(document).on('input', '#nama_pengurus', function() {
          let input = $(this);
          let value = input.val();
          
          let cleanedValue = value.replace(/[^a-zA-Z'\-]/g, '');
          
          if (cleanedValue !== value) {
              input.val(cleanedValue);
          }
        });

        $(document).on('input', '#no_hp_pengurus', function() {
            let input = $(this); 
            let value = input.val();
            
            let cleanedValue = value.replace(/\D/g, '');
            
            if (cleanedValue !== value) {
                input.val(cleanedValue);
            }
        });

        function validatePhoneNumber(input) {
            if (input.value.length > 13) {
                input.value = input.value.slice(0, 13);
            }
        }
    </script>
@endsection