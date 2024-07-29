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
          @if((Auth::user()->instansi_id == $data_instansi->id && in_array(Auth::user()->role, ['TU'])) || ($instansi == 'yayasan' && Auth::user()->hasRole('BENDAHARA')))
          <div class="col-sm-6">
            <a href="javascript:void(0);" data-toggle="modal" data-target="#modal-create-kartu-penyusutan" class="btn btn-primary float-sm-right">Tambah</a>
          </div>
          @endif
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
                  @if((Auth::user()->instansi_id == $data_instansi->id && in_array(Auth::user()->role, ['BENDAHARA', 'SARPRAS YAYASAN', 'SARPRAS SEKOLAH', 'TU'])) || in_array(Auth::user()->role, ['ADMIN']))
                  <div class="row">
                    <div class="col-12 d-flex mb-2">
                      <button id="editBtn" type="button" class="btn btn-warning">Edit</button>
                      <button id="saveBtn" type="button" style="display: none" class="btn btn-primary">Save</button>
                      <button id="cancelBtn" type="button" style="display: none" class="btn btn-secondary ml-1">Cancel</button>
                      <button id="jurnalBtn" type="button" class="btn btn-info ml-1" onclick="saveJurnal()">Tambah Jurnal</button>
                      <a href="javascript:void(0);" onclick="cetak()" class="btn bg-success pt-1 pb-1 pl-2 pr-2 rounded" style="margin-left: auto;">
                        <i class="fas fa-download"></i>
                      </a>
                    </div>                    
                  </div>
                  @endif
                  <div class="row">
                    <!-- Kolom pertama -->
                    <div class="col-md-6">
                      <div class="form-section row">
                        <label for="aset_id" class="col-sm-4 col-form-label">Aset Tetap</label>
                        <div class="col-sm-8">
                          <select class="form-control select2" id="aset_id" name="aset_id" style="width: 100%" required>
                            <option value="">Pilih Aset Tetap</option>
                            @foreach ($asets as $item)
                              <option value="{{ $item->id }}" data-id="{{ $item->id }}" data-aset_id="{{ $item->aset_id }}">{{ $item->id }} - {{ $item->nama_barang }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="form-section row">
                        <label for="nama_barang" class="col-sm-4 col-form-label">Nama Aset</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="nama_barang" value="" disabled>
                        </div>
                      </div>
                      <div class="form-section row">
                        <label for="no_barang" class="col-sm-4 col-form-label">Nomor Aset</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="no_barang" value="" disabled>
                        </div>
                      </div>
                      <div class="form-section row">
                        <label for="jumlah_barang" class="col-sm-4 col-form-label">Jumlah</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="jumlah_barang" value="" disabled>
                        </div>
                      </div>
                      <div class="form-section row">
                        <label for="harga_beli" class="col-sm-4 col-form-label">Harga Beli</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control text-right" id="harga_beli" value="" disabled>
                        </div>
                      </div>
                    </div>
                    
                    <!-- Kolom kedua -->
                    <div class="col-md-6">
                      <div class="form-section row">
                        <label for="tanggal_operasi" class="col-sm-4 col-form-label">Tanggal Operasi</label>
                        <div class="col-sm-8">
                          <input type="date" class="form-control" id="tanggal_operasi" name="tanggal_operasi" disabled>
                        </div>
                      </div>
                      <div class="form-section row">
                        <label for="masa_penggunaan" class="col-sm-4 col-form-label">Masa Penggunaan</label>
                        <div class="col-sm-8">
                          <input type="number" class="form-control" id="masa_penggunaan" name="masa_penggunaan" disabled>
                        </div>
                      </div>
                      <div class="form-section row">
                        <label for="residu" class="col-sm-4 col-form-label">Residu</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control text-right" id="residu" name="residu" disabled>
                        </div>
                      </div>
                      <div class="form-section row">
                        <label for="metode" class="col-sm-4 col-form-label">Metode</label>
                        <div class="col-sm-8">
                          <select class="form-control select2" id="metode" name="metode" style="width:100%" required disabled>
                            <option value="Garis Lurus" {{ old('metode') == 'Garis Lurus' ? 'selected' : '' }}>Garis Lurus</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
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

  <div class="modal fade" id="modal-jurnal-create">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Jurnal Penyusutan</h4>
          <button
            type="button"
            class="close"
            data-dismiss="modal"
            aria-label="Close"
          >
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="formJurnal" action="{{ route('kartu-penyusutan.jurnal', ['instansi' => $instansi]) }}" method="post">
            @csrf
            <div class="form-group">
              <label for="tanggal">Tanggal</label>
              <input type="date" class="form-control" id="tanggal" name="tanggal" placeholder="tanggal" value="{{ old('tanggal') ?? date('Y-m-d') }}" required>
            </div>
            <div class="form-group">
              <label for="id">Id Aset Tetap</label>
              <input type="text" class="form-control" id="id" name="id" placeholder="id" value="{{ old('id') }}" required readonly>
            </div>
            <div class="form-group">
              <label for="akun_debit">Akun Debit</label>
              <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="akun_debit" name="akun_debit" style="width: 100%" required>
                <option value="">Akun Debit</option>
                @foreach ($akun as $item)
                    <option value="{{ $item->id }}" {{ old('akun_debit') == $item->id ? 'selected' : '' }}>{{ $item->kode }}-{{ $item->nama }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="akun_kredit">Akun Kredit</label>
              <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="akun_kredit" name="akun_kredit" style="width: 100%" required>
                <option value="">Akun Kredit</option>
                @foreach ($akun as $item)
                    <option value="{{ $item->id }}" {{ old('akun_kredit') == $item->id ? 'selected' : '' }}>{{ $item->kode }}-{{ $item->nama }}</option>
                @endforeach
              </select>
            </div>
            <div id="tahunBebanInputs"></div>
          </div>
          <div class="modal-footer justify-content-between">
            <button
              type="button"
              class="btn btn-default"
              data-dismiss="modal"
            >
              Close
            </button>
            <button type="submit" class="btn btn-primary">
              Save
            </button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- Modal Create Aset Tetap -->
<div class="modal fade" id="modal-create-kartu-penyusutan">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title">Tambah Kartu Penyusutan</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <form id="addForm" action="{{ route('kartu-penyusutan.store', ['instansi' => $instansi]) }}" method="POST">
              @csrf
              <div class="modal-body">
                  <div class="row">
                      <div class="col-md-6">
                          <div class="form-section row">
                              <label for="aset_id" class="col-sm-4 col-form-label">Aset Tetap</label>
                              <div class="col-sm-8">
                                  <select class="form-control select2" id="add_aset_id" name="aset_id" style="width: 100%" required>
                                      <option value="">Pilih Aset Tetap</option>
                                      @foreach ($allaset as $item)
                                          <option value="{{ $item->id }}">{{ $item->nama_aset }}</option>
                                      @endforeach
                                  </select>
                              </div>
                          </div>
                          <div class="form-section row">
                              <label for="nama_barang" class="col-sm-4 col-form-label">Nama Aset</label>
                              <div class="col-sm-8">
                                  <input type="text" class="form-control" id="add_nama_barang" name="nama_barang" value="{{ old('nama_barang') }}" required>
                              </div>
                          </div>
                          <div class="form-section row">
                              <label for="jumlah_barang" class="col-sm-4 col-form-label">Jumlah</label>
                              <div class="col-sm-8">
                                  <input type="text" class="form-control" id="add_jumlah_barang" name="jumlah_barang" value="{{ old('jumlah_barang') }}" required>
                              </div>
                          </div>
                          <div class="form-section row">
                              <label for="harga_beli" class="col-sm-4 col-form-label">Harga Beli</label>
                              <div class="col-sm-8">
                                  <input type="text" class="form-control text-right" id="add_harga_beli" name="harga_beli" value="{{ old('harga_beli') }}" required>
                              </div>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-section row">
                              <label for="tanggal_operasi" class="col-sm-4 col-form-label">Tanggal Operasi</label>
                              <div class="col-sm-8">
                                  <input type="date" class="form-control" id="add_tanggal_operasi" name="tanggal_operasi" value="{{ old('tanggal_operasi') }}" required>
                              </div>
                          </div>
                          <div class="form-section row">
                              <label for="masa_penggunaan" class="col-sm-4 col-form-label">Masa Penggunaan</label>
                              <div class="col-sm-8">
                                  <input type="number" class="form-control" id="add_masa_penggunaan" name="masa_penggunaan" value="{{ old('masa_penggunaan') }}" required>
                              </div>
                          </div>
                          <div class="form-section row">
                              <label for="residu" class="col-sm-4 col-form-label">Residu</label>
                              <div class="col-sm-8">
                                  <input type="text" class="form-control text-right" id="add_residu" name="residu" value="{{ old('residu') }}" required>
                              </div>
                          </div>
                          <div class="form-section row">
                              <label for="metode" class="col-sm-4 col-form-label">Metode</label>
                              <div class="col-sm-8">
                                  <select class="form-control select2" id="add_metode" name="metode" style="width: 100%" required>
                                      <option value="Garis Lurus" {{ old('metode') == 'Garis Lurus' ? 'selected' : '' }}>Garis Lurus</option>
                                  </select>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Simpan</button>
              </div>
          </form>
      </div>
  </div>
</div>
@endsection
@section('js')
    <script>
      var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
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

        $(document).on('input', '[id^=residu], #jumlah_barang, #add_harga_beli, #add_jumlah, #add_residu, #add_jumlah_barang', function() {
                let input = $(this);
                let value = input.val();
                
                if (!isNumeric(cleanNumber(value))) {
                value = value.replace(/[^\d]/g, "");
                }

                value = cleanNumber(value);
                let formattedValue = formatNumber(value);
                
                input.val(formattedValue);
            });

        $(document).on('change', '#aset_id', function(){
          if ($(this).val()) {
            var id = $(this).find(':selected').data('id');
            
            $.ajax({
                type: "GET",
                url: "kartu-penyusutan/"+id+"/show",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                  penyusutan((response.komponen ? response.komponen.harga_total : response.harga_beli), response.masa_penggunaan, response.residu, response.tanggal_operasi);
                  $('#nama_barang').val(response.nama_barang);
                  $('#jumlah_barang').val(formatNumber(response.jumlah_barang));
                  $('#no_barang').val(response.id);
                  if(response.komponen){
                    $('#harga_beli').val(formatNumber(response.komponen.harga_total));
                  } else {
                    $('#harga_beli').val(formatNumber(response.harga_beli));
                  }
                  $('#tanggal_operasi').val(response.tanggal_operasi);
                  $('#masa_penggunaan').val(response.masa_penggunaan);
                  $('#residu').val(formatNumber(response.residu));
                },
                error: function(error) {
                    toastr.error('Gagal mengambil data', 'Error', {
                        closeButton: true,
                        tapToDismiss: false,
                        rtl: false,
                        progressBar: true
                    });
                }
            });
          }
        })

        $(document).on('click', '#editBtn', function(){
          $('#aset_id').attr('disabled', true);
          $('#nama_barang').attr('disabled', false);
          $('#jumlah_barang').attr('disabled', false);
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
          $('#jumlah_barang').attr('disabled', true);
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
          $('#jumlah_barang').attr('disabled', true);
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
          var aset_id = $('#aset_id').find(':selected').data('aset_id');
          var nama = $('#nama_barang').val();
          var jumlah = cleanNumber($('#jumlah_barang').val());
          var tanggal = $('#tanggal_operasi').val();
          var masa = $('#masa_penggunaan').val();
          var residu = cleanNumber($('#residu').val());
          var metode = $('#metode').val();
          submitForm(id, aset_id, nama, jumlah, tanggal, masa, residu, metode);
        });

        $('#formJurnal').on('submit', function(e) {
            let inputs = $('#formJurnal').find('[name^=beban]');
            inputs.each(function() {
                let input = $(this);
                let value = input.val();
                let cleanedValue = cleanNumber(value);

                input.val(cleanedValue);
            });

            return true;
        });

        $('#addForm').on('submit', function(e) {
            let inputs = $('#addForm').find('#add_harga_beli, #add_jumlah, #add_residu, #add_jumlah_barang');
            inputs.each(function() {
                let input = $(this);
                let value = input.val();
                let cleanedValue = cleanNumber(value);

                input.val(cleanedValue);
            });

            return true;
        });

        function submitForm(id, aset_id, nama, jumlah, tanggal, masa, residu, metode){
          $.ajax({
              type: "GET",
              url: "kartu-penyusutan/save",
              data: {
                  id: id,
                  aset_id: aset_id,
                  nama_barang: nama,
                  jumlah_barang: jumlah,
                  tanggal_operasi: tanggal,
                  masa_penggunaan: masa,
                  residu: residu,
                  metode: metode
              },
              headers: {
                  'X-CSRF-TOKEN': csrfToken
              },
              success: function(response) {
                var harga_beli = $('#harga_beli').val();
                penyusutan(cleanNumber(harga_beli), masa, residu, tanggal);
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
          var bulan = (new Date(tanggal)).getMonth() + 1;
          var tahun = (new Date(tanggal)).getFullYear();
          var total_bulan = masa * 12;
          var test = 0;
          var akumulasi_susut = 0;
          var nilai_buku = harga_beli;
          for (let i = 0; i <= masa; i++) {
            if(i == 0){
              var penyusutan_berjalan = (12 - bulan)/12 * nilai_susut;
              total_bulan -= (12 - bulan);
              akumulasi_susut += penyusutan_berjalan;
              nilai_buku -= penyusutan_berjalan;
              var newRow = '<tr>' +
                    '<td>' + tahun + '</td>' +
                    '<td class="beban_pertahun text-right">' + formatNumber(penyusutan_berjalan.toFixed(0)) + '</td>' +
                    '<td class="text-right">' + formatNumber(akumulasi_susut.toFixed(0)) + '</td>' +
                    '<td class="text-right">' + formatNumber(nilai_buku.toFixed(0)) + '</td>' +
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
                    '<td class="beban_pertahun text-right">' + formatNumber(penyusutan_berjalan.toFixed(0)) + '</td>' +
                    '<td class="text-right">' + formatNumber(akumulasi_susut.toFixed(0)) + '</td>' +
                    '<td class="text-right">' + formatNumber(nilai_buku.toFixed(0)) + '</td>' +
                 '</tr>';

              $('#body_data').append(newRow);
            }
            test += penyusutan_berjalan;
          }
        }
        function saveJurnal()
        {
            var id = $('#aset_id').val();
            var masa = $('#masa_penggunaan').val();
            var residu = $('#residu').val();
            if(!id || !masa || !residu){
              toastr.error('Penyusutan aset belum disimpan', 'Error', {
                  closeButton: true,
                  tapToDismiss: false,
                  rtl: false,
                  progressBar: true
              });
              return;
            }
            var rows = $('#body_data tr');
            var tahunBebanArray = [];

            if (rows.length < 1) {
              toastr.error('Penyusutan aset belum disimpan ', 'Error', {
                  closeButton: true,
                  tapToDismiss: false,
                  rtl: false,
                  progressBar: true
              });
              return;
            }
            rows.each(function() {
                var tahun = $(this).find('td').eq(0).text();
                var beban = $(this).find('td.beban_pertahun').text();
                var bebanNumeric = beban;
                var tahunBeban = {
                    tahun: tahun,
                    beban: bebanNumeric
                };
                tahunBebanArray.push(tahunBeban);
            });

            var tahunBebanInputs = $('#tahunBebanInputs');

            for (var i = 0; i < tahunBebanArray.length; i++) {
                var inputTahun = $('<input>')
                    .attr('type', 'text')
                    .attr('class', 'form-control')
                    .attr('name', 'tahun[]')
                    .attr('value', tahunBebanArray[i].tahun)
                    .attr('readonly', 'readonly');

                var inputBeban = $('<input>')
                    .attr('type', 'text')
                    .attr('class', 'form-control text-right')
                    .attr('name', 'beban[]')
                    .attr('value', tahunBebanArray[i].beban)
                    .attr('readonly', 'readonly');

                var labelTahun = $('<label>')
                    .attr('for', 'tahun_' + i)
                    .text('Tahun');

                var labelBeban = $('<label>')
                    .attr('for', 'beban_' + i)
                    .text('Beban');

                var divInputGroup = $('<div>').addClass('form-group row');

                var divTahun = $('<div>').addClass('col');
                var divBeban = $('<div>').addClass('col');

                divTahun.append(labelTahun).append(inputTahun);
                divBeban.append(labelBeban).append(inputBeban);

                divInputGroup.append(divTahun).append(divBeban);
                tahunBebanInputs.append(divInputGroup);
            }
            $('#id').val(id)
            $('#modal-jurnal-create').modal('show');
        }

        function cetak()
        {
          var kartu_id = $('#aset_id').val();
          if(!kartu_id) {
            toastr.error('Kartu belum dipilih', 'Error', {
                closeButton: true,
                tapToDismiss: false,
                rtl: false,
                progressBar: true
            });
            return;
          }
          let url = "{{ route('kartu-penyusutan.cetak', ['instansi' => $instansi]) }}";
          let queryString = '?id=' + kartu_id;
          window.open(url + queryString, '_blank');
        }
    </script>
@endsection