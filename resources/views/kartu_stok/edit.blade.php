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
            <h1 class="m-0">Edit Data Kartu Atk</h1>
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
                    <form action="{{ route('kartu-stok.store', ['instansi' => $instansi]) }}" method="post">
                        @csrf
                        <h3 class="text-center font-weight-bold">Data Data Kartu Atk</h3>
                        <br><br>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                <label>Atk</label>
                                <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" name="atk_id" required>
                                    <option value="">Pilih Atk</option>
                                    @foreach ($atks as $item)
                                        <option value="{{ $item->id }}" {{ $data->atk_id == $item->id ? 'selected' : '' }}>{{ $item->nama_atk }}</option>
                                    @endforeach
                                </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                <label>Tanggal</label>
                                <input type="date" name="tanggal" class="form-control" placeholder="Tanggal" value="{{ $data->tanggal ?? date('Y-m-d') }}" required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                <label>Pengambil</label>
                                <input type="text" name="pengambil" class="form-control" placeholder="Pengambil" value="{{ $data->pengambil }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label>Jenis</label>
                                <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" id="jenis" name="jenis" required>
                                    <option value="masuk" {{ $data->jenis == 'pcs' ? 'selected' : '' }}>Masuk</option>
                                    <option value="keluar" {{ $data->jenis == 'rem' ? 'selected' : '' }}>Keluar</option>
                                </select>
                                </div>
                            </div>
                            <div id="div_masuk" class="col-sm-6">
                                <div class="form-group">
                                <label>Jumlah Masuk</label>
                                <input type="number" id="masuk" name="masuk" class="form-control" placeholder="Jumlah Masuk" value="{{ $data->masuk ?? 0 }}">
                                </div>
                            </div>
                            <div id="div_keluar" class="col-sm-6" style="display: none">
                                <div class="form-group">
                                <label>Jumlah keluar</label>
                                <input type="number" id="keluar" name="keluar" class="form-control" placeholder="Jumlah Keluar" value="{{ $data->keluar ?? 0 }}">
                                </div>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('kartu-stok.index', ['instansi' => $instansi]) }}" class="btn btn-secondary" type="button">Batal</a>
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
        $(document).on('change', '#jenis', function(){
            var jenis = $(this).val();
            if(jenis == 'masuk') {
                $('#div_masuk').css('display', 'block');
                $('#masuk').attr('required',true);
                $('#div_keluar').css('display', 'none');
                $('#keluar').attr('required',false);
            } else {
                $('#div_masuk').css('display', 'none');
                $('#masuk').attr('required',false);
                $('#div_keluar').css('display', 'block');
                $('#keluar').attr('required',true);
            }
        });
    </script>
@endsection