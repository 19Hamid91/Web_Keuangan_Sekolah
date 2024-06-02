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
                  <h3 class="card-title">Kartu Penyusutan</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="row">
                      <button id="editBtn" type="button" class="btn btn-warning">Edit</button>
                      <button id="saveBtn" type="button" style="display: none" class="btn btn-primary">Save</button>
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
                      <td>Harga Beli</td>
                      <td> : </td>
                      <td><input type="text" class="form-control" id="harga_beli" value="" disabled></td>
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
                          <option value="Tegak Lurus" {{ old('metode') == 'Tegak Lurus' ? 'selected' : '' }}>Tegak Lurus</option>
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
                "pageLength": 20,
                // "buttons": ["excel", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });

        $(document).on('change', '#aset_id', function(){
          var data = $(this).find(':selected').data('item');
          $('#nama_barang').val(data.nama_barang);
          $('#no_barang').val(data.id);
          $('#harga_beli').val(data.pembelian_aset.hargasatuan_aset);
          $('#tanggal_operasi').val(data.tanggal_operasi);
          $('#masa_penggunaan').val(data.masa_penggunaan);
          $('#residu').val(data.residu);

          penyusutan(data.pembelian_aset.hargasatuan_aset, data.masa_penggunaan, data.residu, data.tanggal_operasi);
        })

        $(document).on('click', '#editBtn', function(){
          $('#aset_id').attr('disabled', true);
          $('#nama_barang').attr('disabled', false);
          $('#no_barang').attr('disabled', false);
          $('#harga_beli').attr('disabled', false);
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
          $('#harga_beli').attr('disabled', true);
          $('#tanggal_operasi').attr('disabled', true);
          $('#masa_penggunaan').attr('disabled', true);
          $('#residu').attr('disabled', true);
          $('#metode').attr('disabled', true);

          $('#editBtn').css('display', 'block');
          $('#cancelBtn').css('display', 'none');
          $('#saveBtn').css('display', 'none');
        });

        $(document).on('click', '#saveBtn', function(){
          $('#aset_id').attr('disabled', false);
          $('#nama_barang').attr('disabled', true);
          $('#no_barang').attr('disabled', true);
          $('#harga_beli').attr('disabled', true);
          $('#tanggal_operasi').attr('disabled', true);
          $('#masa_penggunaan').attr('disabled', true);
          $('#residu').attr('disabled', true);
          $('#metode').attr('disabled', true);

          $('#editBtn').css('display', 'block');
          $('#cancelBtn').css('display', 'none');
          $('#saveBtn').css('display', 'none');

          var id = $('#no_barang').val();
          var aset_id = $('#aset_id').find(':selected').data('item');
          var nama = $('#nama_barang').val();
          var tanggal = $('#tanggal_operasi').val();
          var masa = $('#masa_penggunaan').val();
          var residu = $('#residu').val();
          var metode = $('#metode').val();
          submitForm(id, aset_id.aset.id, nama, tanggal, masa, residu, metode);
        });

        function submitForm(id, aset_id, nama, tanggal, masa, residu, metode){
          $.ajax({
              type: "GET",
              url: "kartu-penyusutan/save",
              data: {
                  id: id,
                  aset_id: aset_id,
                  nama_barang: nama,
                  tanggal_operasi: tanggal,
                  masa_penggunaan: masa,
                  residu: residu,
                  metode: metode
              },
              success: function(response) {
                var harga_beli = $('#harga_beli').val();
                penyusutan(harga_beli, masa, residu, tanggal);
                toastr.success('Data tersimpan', 'Success', {
                      closeButton: true,
                      tapToDismiss: false,
                      rtl: false,
                      progressBar: true
                  });
              },
              error: function(error) {
                  toastr.error('Gagal menyimpan data', 'Error', {
                      closeButton: true,
                      tapToDismiss: false,
                      rtl: false,
                      progressBar: true
                  });
              }
          });
        }
        function penyusutan(harga_beli, masa, residu, tanggal)
        {
          $('#body_data').empty();
          var nilai_susut = (harga_beli - residu) / (masa == 0 ? 1 : masa);
          var bulan = (new Date(tanggal)).getMonth();
          var tahun = (new Date(tanggal)).getFullYear();
          var total_bulan = masa * 12;
          var test = 0;
          var akumulasi_susut = 0;
          var nilai_buku = harga_beli;
          for (let i = 0; i <= masa; i++) {
            if(i == 0){
              var penyusutan_berjalan = bulan/12 * nilai_susut;
              total_bulan -= bulan;
              akumulasi_susut += penyusutan_berjalan;
              nilai_buku -= penyusutan_berjalan;
              var newRow = '<tr>' +
                    '<td>' + tahun + '</td>' +
                    '<td>' + penyusutan_berjalan.toFixed(2) + '</td>' +
                    '<td>' + akumulasi_susut.toFixed(2) + '</td>' +
                    '<td>' + nilai_buku.toFixed(2) + '</td>' +
                 '</tr>';

              $('#body_data').append(newRow);
            } else {
              if (total_bulan > 12) {
                var penyusutan_berjalan = nilai_susut;
                total_bulan -= 12;
              } else{
                var penyusutan_berjalan = total_bulan/12 * nilai_susut;
                total_bulan -= total_bulan;
              }
              tahun++;
              akumulasi_susut += penyusutan_berjalan;
              nilai_buku -= penyusutan_berjalan;
              var newRow = '<tr>' +
                    '<td>' + tahun + '</td>' +
                    '<td>' + penyusutan_berjalan.toFixed(2) + '</td>' +
                    '<td>' + akumulasi_susut.toFixed(2) + '</td>' +
                    '<td>' + nilai_buku.toFixed(2) + '</td>' +
                 '</tr>';

              $('#body_data').append(newRow);
            }
            test += penyusutan_berjalan;
          }
          console.log(test)
        }

    </script>
@endsection