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
            <h1 class="m-0">Kartu Penyusutan</h1>
          </div>
          {{-- <div class="col-sm-6">
            <a href="{{ route('kartu-penyusutan.create', ['instansi' => $instansi]) }}" class="btn btn-primary float-sm-right">Tambah</a>
          </div> --}}
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
                <div class="card-header">
                  <h3 class="card-title">Kartu Penyusutan {{ 'test' }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="row">
                      <button id="editBtn" type="button" class="btn btn-warning">Edit</button>
                      <button id="saveBtn" type="button" onClick="submitForm()" style="display: none" class="btn btn-primary">Save</button>
                      <button id="cancelBtn" type="button" style="display: none" class="btn btn-secondary">Cancel</button>
                  </div>
                  <table>
                    <tr>
                      <td>Nama Barang</td>
                      <td> : </td>
                      <td>
                        <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" id="aset_id" name="aset_id" required>
                          <option value="">Pilih Aset</option>
                          @foreach ($asets as $item)
                              <option value="{{ $item->id }}" data-item="{{ $item }}">{{ $item->id }}-{{ $item->nama_barang }}</option>
                          @endforeach
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td>Nama Barang</td>
                      <td> : </td>
                      <td><input type="text" class="form-control" id="nama_barang" value="" disabled></td>
                    </tr>
                    <tr>
                      <td>Nomor Barang</td>
                      <td> : </td>
                      <td><input type="text" class="form-control" id="no_barang" value="" disabled></td>
                    </tr>
                    <tr>
                      <td>Tanggal Operasi</td>
                      <td> : </td>
                      <td><input type="date" class="form-control" name="tanggal_operasi" id="tanggal_operasi" disabled></td>
                    </tr>
                    <tr>
                      <td>Masa Penggunaan</td>
                      <td> : </td>
                      <td><input type="number" class="form-control" name="masa_penggunaan" id="masa_penggunaan" disabled></td>
                    </tr>
                    <tr>
                      <td>Residu</td>
                      <td> : </td>
                      <td><input type="number" class="form-control" name="residu" id="residu" disabled></td>
                    </tr>
                    <tr>
                      <td>Metode</td>
                      <td> : </td>
                      <td>
                        <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" id="metode" name="metode" required disabled>
                          <option value="pcs" {{ old('satuan') == 'pcs' ? 'selected' : '' }}>pcs</option>
                          <option value="rem" {{ old('satuan') == 'rem' ? 'selected' : '' }}>rem</option>
                          <option value="lusin" {{ old('satuan') == 'lusin' ? 'selected' : '' }}>lusin</option>
                        </select>
                      </td>
                    </tr>
                  </table>
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="5%">Periode</th>
                        <th>Beban Penyusutan Tahun Berjalan</th>
                        <th>Akumulasi Penyusutan</th>
                        <th>Nilai Buku</th>
                      </tr>
                    </thead>
                    <tbody id="body_data">
                  </table>
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
        $(function () {
            $("#example1").DataTable({
                "responsive": true, 
                "lengthChange": false, 
                "autoWidth": false,
                "searching" : false,
                "ordering" : false,
                // "buttons": ["excel", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });

        $(document).on('change', '#aset_id', function(){
          var data = $(this).find(':selected').data('item');
          $('#nama_barang').val(data.nama_barang);
          $('#no_barang').val(data.id);
          $('#tanggal_operasi').val(data.tanggal_operasi);
          $('#masa_penggunaan').val(data.masa_penggunaan);
          $('#residu').val(data.residu);
          console.log(data)
        })

        $(document).on('click', '#editBtn', function(){
          $('#aset_id').attr('disabled', true);
          $('#nama_barang').attr('disabled', false);
          $('#no_barang').attr('disabled', false);
          $('#tanggal_operasi').attr('disabled', false);
          $('#masa_penggunaan').attr('disabled', false);
          $('#residu').attr('disabled', false);
          $('#metode').attr('disabled', false);

          $('#editBtn').css('display', 'none');
          $('#cancelBtn').css('display', 'block');
          $('#saveBtn').css('display', 'block');
        });

        $(document).on('click', '#cancelBtn', function(){
          $('#aset_id').attr('disabled', false);
          $('#nama_barang').attr('disabled', true);
          $('#no_barang').attr('disabled', true);
          $('#tanggal_operasi').attr('disabled', true);
          $('#masa_penggunaan').attr('disabled', true);
          $('#residu').attr('disabled', true);
          $('#metode').attr('disabled', true);

          $('#editBtn').css('display', 'block');
          $('#cancelBtn').css('display', 'none');
          $('#saveBtn').css('display', 'none');
        });

        function submitForm(){
          console.log('save');
        }

    </script>
@endsection