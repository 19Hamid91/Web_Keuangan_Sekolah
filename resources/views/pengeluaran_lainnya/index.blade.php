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
            <h1 class="m-0">Pengeluaran Lainnya</h1>
          </div>
          @if((Auth::user()->instansi_id == $data_instansi->id && in_array(Auth::user()->role, ['BENDAHARA'])) || in_array(Auth::user()->role, ['ADMIN']))
          <div class="col-sm-6">
            <a href="{{ route('pengeluaran_lainnya.create', ['instansi' => $instansi]) }}" class="btn btn-primary float-sm-right">Tambah</a>
            <a href="javascript:void(0);" data-target="#modal-jurnal-create" data-toggle="modal" class="btn btn-success mr-1 rounded float-sm-right">
              Jurnal
            </a>
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
                  <h3 class="card-title">Daftar Pengeluaran Lainnya</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="row mb-1">
                    <div class="col-sm-6 col-md-3 col-lg-2">
                      <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="filterJenis" style="width: 100%" required>
                        <option value="Perbaikan Aset">Perbaikan Aset Tetap</option>
                        @if ($instansi == 'tk-kb-tpa')
                        <option value="Outbond">Outbond</option>
                        @endif
                        <option value="Operasional">Operasional</option>
                        @if($instansi == 'yayasan')
                        <option value="Transport">Transport</option>
                        <option value="Honor Dokter">Honor Dokter</option>
                        @endif
                        <option value="Lainnya">Lainnya</option>
                      </select>
                    </div>
                  </div>
                  <table id="perbaikanTable" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="5%">No</th>
                        <th class="perbaikan-head">Teknisi</th>
                        <th class="perbaikan-head">Aset Tetap</th>
                        <th class="perbaikan-head">Tanggal Perbaikan</th>
                        <th class="perbaikan-head">Jenis Perbaikan</th>
                        <th class="perbaikan-head">Harga Perbaikan</th>
                        <th width="15%">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                  </table>
                  <table id="outbondTable" class="table table-bordered table-striped d-none">
                    <thead>
                      <tr>
                        <th width="5%">No</th>
                        <th class="outbond-head">Biro</th>
                        <th class="outbond-head">Tanggal Pembayaran</th>
                        <th class="outbond-head">Harga</th>
                        <th class="outbond-head">Tanggal Outbond</th>
                        <th class="outbond-head">Tempat Outbond</th>
                        <th width="15%">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                  </table>
                  <table id="operasionalTable" class="table table-bordered table-striped d-none">
                    <thead>
                      <tr>
                        <th width="5%">No</th>
                        <th class="operasional-head">PJ Kegiatan</th>
                        <th class="operasional-head">Jenis Tagihan</th>
                        <th class="operasional-head">Tanggal Pembayaran</th>
                        <th class="operasional-head">Jumlah Tagihan</th>
                        <th class="operasional-head">Keterangan</th>
                        <th width="15%">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                  </table>
                  <table id="transportTable" class="table table-bordered table-striped d-none">
                    <thead>
                      <tr>
                        <th width="5%">No</th>
                        <th class="transport-head">Nama</th>
                        <th class="transport-head">Tanggal</th>
                        <th class="transport-head">Nominal</th>
                        <th class="transport-head">Keterangan</th>
                        <th width="15%">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                  </table>
                  <table id="honorTable" class="table table-bordered table-striped d-none">
                    <thead>
                      <tr>
                        <th width="5%">No</th>
                        <th class="honor-head">Nama</th>
                        <th class="honor-head">Tanggal</th>
                        <th class="honor-head">Honor Total</th>
                        <th class="honor-head">Keterangan</th>
                        <th width="15%">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                  </table>
                  <table id="lainnyaTable" class="table table-bordered table-striped d-none">
                    <thead>
                      <tr>
                        <th width="5%">No</th>
                        <th class="lainnya-head">Nama</th>
                        <th class="lainnya-head">Tanggal</th>
                        <th class="lainnya-head">Nominal</th>
                        <th class="lainnya-head">Keterangan</th>
                        <th width="15%">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
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
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Data Jurnal</h4>
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
          <div class="row mb-2">
            <div class="col-sm-3 col-md-3 col-lg-3">
              <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="filterTahun" style="width: 100%">
                <option value="">Pilih Tahun</option>
                @foreach ($tahun as $item)
                    <option value="{{ $item }}" {{ request()->input('tahun') == $item ? 'selected' : '' }}>{{ $item }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-sm-3 col-md-3 col-lg-3">
              <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="filterTipe" style="width: 100%">
                <option value="Honor Dokter">Honor Dokter</option>
                <option value="Transport">Transport</option>
              </select>
            </div>
            <div class="col-sm-3 col-md-3 col-lg-3">
              <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="filterBulan" style="width: 100%">
                <option value="">Pilih Bulan</option>
                @foreach ($bulan as $key => $value)
                    <option value="{{ $key }}" {{ request()->input('bulan') == $key ? 'selected' : '' }}>{{ $value }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-sm-3 col-md-3 col-lg-3">
              <div>
                <button class="btn btn-primary" type="button" onClick="filter()">Filter</button>
              </div>
            </div>
          </div>
          <form id="addForm" action="{{ route('jurnal.store', ['instansi' => $instansi]) }}" method="post">
            @csrf
            <input type="hidden" id="journable_id" name="journable_id" value="0">
            <input type="hidden" id="journable_type" name="journable_type" value="">
            <div class="form-group">
              <label for="nominal">Nominal</label>
              <input type="text" class="form-control" id="add_nominal" name="nominal" placeholder="Nominal" value="" readonly>
            </div>
            <div class="form-group">
              <label for="tanggal">Tanggal</label>
              <input type="date" class="form-control" id="add_tanggal" name="tanggal" placeholder="Tanggal" value="{{ old('tanggal') ?? date('Y-m-d') }}" required>
            </div>
            <div class="form-group">
              <label for="keterangan">Keterangan</label>
              <textarea name="keterangan" id="add_keterangan" class="form-control">{{ old('keterangan') }}</textarea>
            </div>
            <div>
              <table style="min-width: 100%">
                  <thead>
                      <tr>
                          <th>Akun</th>
                          <th>Debit</th>
                          <th>Kredit</th>
                          <th></th>
                      </tr>
                  </thead>
                  <tbody id="body_akun">
                      <tr id="row_0" class="mt-1">
                          <td>
                            <select name="akun[]" id="akun_0" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%" required>
                              <option value="">Pilih Akun</option>
                              @foreach ($akuns as $akun)
                                  <option value="{{ $akun->id }}" {{ old('akun.0') == $akun->id ? 'selected' : '' }}>{{ $akun->kode }} - {{ $akun->nama }}</option>
                              @endforeach
                            </select>
                          </td>
                          <td>
                              <input type="text" id="debit-0" name="debit[]" class="form-control" placeholder="Nominal Debit" value="" oninput="calculate()">
                          </td>
                          <td>
                              <input type="text" id="kredit-0" name="kredit[]" class="form-control" placeholder="Nominal Kredit" value="" oninput="calculate()">
                          </td>
                          <td>
                              <button class="btn btn-success" id="addRow">+</button>
                          </td>
                      </tr>
                  </tbody>
                  <tfoot>
                      <tr>
                          <td class="text-right pr-3">Total</td>
                          <td><input type="text" id="debit_keseluruhan" name="debit_keseluruhan" class="form-control" required readonly></td>
                          <td><input type="text" id="kredit_keseluruhan" name="kredit_keseluruhan" class="form-control" required readonly></td>
                      </tr>
                  </tfoot>
              </table>
              <p class="text-danger d-none" id="notMatch">Jumlah Belum Sesuai</p>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button
              type="button"
              class="btn btn-default"
              data-dismiss="modal"
            >
              Close
            </button>
            <button type="submit" class="btn btn-primary" id="saveBtn">
              Save
            </button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
@endsection
@section('js')
    <script>
      var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
         $(document).ready(function() {
            var table = null;
            var hasEditPermission = false;

            @if((Auth::user()->instansi_id == $data_instansi->id && in_array(Auth::user()->role, ['BENDAHARA'])) || in_array(Auth::user()->role, ['ADMIN']))
                hasEditPermission = true;
            @endif

            function initializeTable(filterJenis) {
                if (table !== null) {
                    table.destroy(); 
                }

                if(filterJenis == 'Perbaikan Aset'){
                  table = $("#perbaikanTable").DataTable({
                    "responsive": true,
                    "lengthChange": true,
                  "autoWidth": false,
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": "{{ route('pengeluaran_lainnya.getData', ['instansi' => $instansi]) }}",
                        "data": function(d) {
                            d.filterJenis = filterJenis;
                        }
                    },
                    "columns": [
                      { "data": null, "title": "No" },
                      { "data": "teknisi_id", "title": "Teknisi" },
                      { "data": "aset_id", "title": "Aset" },
                      { "data": "tanggal", "title": "Tanggal" },
                      { "data": "jenis", "title": "Jenis" },
                      { "data": "harga", "title": "Harga" },
                      {
                        "data": null,
                        "title": "Aksi",
                        "render": function(data, type, row) {
                          return `
                              <td class="text-center">
                                  <a href="/{{ $instansi }}/pengeluaran_lainnya/Perbaikan Aset/cetak/${data.id}" class="btn  bg-success pt-1 pb-1 pl-2 pr-2 rounded" target="_blank">
                                      <i class="fas fa-download"></i>
                                  </a>
                                  <a href="/{{ $instansi }}/pengeluaran_lainnya/Perbaikan Aset/edit/${data.id}" class="btn bg-warning pt-1 pb-1 pl-2 pr-2 rounded">
                                      <i class="fas fa-edit"></i>
                                  </a>
                                  <a href="/{{ $instansi }}/pengeluaran_lainnya/Perbaikan Aset/show/${data.id}" class="btn bg-secondary pt-1 pb-1 pl-2 pr-2 rounded">
                                      <i class="fas fa-eye"></i>
                                  </a>
                                  <a onclick="remove('Perbaikan Aset',${data.id})" class="btn bg-danger pt-1 pb-1 pl-2 pr-2 rounded">
                                      <i class="fas fa-times fa-lg"></i>
                                  </a>
                              </td>
                          `;
                        }
                      }
                    ],
                    "order": [],
                    "drawCallback": function(settings) {
                        var api = this.api();
                        var startIndex = api.context[0]._iDisplayStart;

                        api.column(0, {order: 'applied'}).nodes().each(function(cell, i) {
                            cell.innerHTML = startIndex + i + 1;
                        });
                    }
                  });
                } else if (filterJenis == 'Outbond'){
                  table = $("#outbondTable").DataTable({
                    "responsive": true,
                    "lengthChange": true,
                    "autoWidth": false,
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": "{{ route('pengeluaran_lainnya.getData', ['instansi' => $instansi]) }}",
                        "data": function(d) {
                            d.filterJenis = filterJenis;
                        }
                    },
                    "columns": [
                        { "data": null, "title": "No" },
                        { "data": "biro_id", "title": "Biro" },
                        { "data": "tanggal_pembayaran", "title": "Tanggal Pembayaran" },
                        { "data": "harga_outbond", "title": "Harga Outbond" },
                        { "data": "tanggal_outbond", "title": "Tanggal Outbond" },
                        { "data": "tempat_outbond", "title": "Tempat Outbond" },
                        {
                        "data": null,
                        "title": "Aksi",
                        "render": function(data, type, row) {
                          return `
                              <td class="text-center">
                                  <a href="/{{ $instansi }}/pengeluaran_lainnya/Outbond/cetak/${data.id}" class="btn  bg-success pt-1 pb-1 pl-2 pr-2 rounded" target="_blank">
                                      <i class="fas fa-download"></i>
                                  </a>
                                  <a href="/{{ $instansi }}/pengeluaran_lainnya/Outbond/edit/${data.id}" class="btn bg-warning pt-1 pb-1 pl-2 pr-2 rounded">
                                      <i class="fas fa-edit"></i>
                                  </a>
                                  <a href="/{{ $instansi }}/pengeluaran_lainnya/Outbond/show/${data.id}" class="btn bg-secondary pt-1 pb-1 pl-2 pr-2 rounded">
                                      <i class="fas fa-eye"></i>
                                  </a>
                                  <a onclick="remove('Outbond',${data.id})" class="btn bg-danger pt-1 pb-1 pl-2 pr-2 rounded">
                                      <i class="fas fa-times fa-lg"></i>
                                  </a>
                              </td>
                            `;
                          }
                        }
                    ],
                    "order": [],
                    "drawCallback": function(settings) {
                        var api = this.api();
                        var startIndex = api.context[0]._iDisplayStart;

                        api.column(0, {order: 'applied'}).nodes().each(function(cell, i) {
                            cell.innerHTML = startIndex + i + 1;
                        });
                    }
                  });
                } else if (filterJenis == 'Operasional'){
                  table = $("#operasionalTable").DataTable({
                    "responsive": true,
                    "lengthChange": true,
                    "autoWidth": false,
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": "{{ route('pengeluaran_lainnya.getData', ['instansi' => $instansi]) }}",
                        "data": function(d) {
                            d.filterJenis = filterJenis;
                        }
                    },
                    "columns": [
                        { "data": null, "title": "No" },
                        { "data": "karyawan_id", "title": "PJ Kegiatan" },
                        { "data": "jenis", "title": "Jenis" },
                        { "data": "tanggal_pembayaran", "title": "Tanggal Pembayaran" },
                        { "data": "jumlah_tagihan", "title": "Jumlah Tagihan" },
                        { "data": "keterangan", "title": "Keterangan" },
                        {
                        "data": null,
                        "title": "Aksi",
                        "render": function(data, type, row) {
                          return `
                              <td class="text-center">
                                  <a href="/{{ $instansi }}/pengeluaran_lainnya/Operasional/cetak/${data.id}" class="btn  bg-success pt-1 pb-1 pl-2 pr-2 rounded" target="_blank">
                                      <i class="fas fa-download"></i>
                                  </a>
                                  <a href="/{{ $instansi }}/pengeluaran_lainnya/Operasional/edit/${data.id}" class="btn bg-warning pt-1 pb-1 pl-2 pr-2 rounded">
                                      <i class="fas fa-edit"></i>
                                  </a>
                                  <a href="/{{ $instansi }}/pengeluaran_lainnya/Operasional/show/${data.id}" class="btn bg-secondary pt-1 pb-1 pl-2 pr-2 rounded">
                                      <i class="fas fa-eye"></i>
                                  </a>
                                  <a onclick="remove('Operasional',${data.id})" class="btn bg-danger pt-1 pb-1 pl-2 pr-2 rounded">
                                      <i class="fas fa-times fa-lg"></i>
                                  </a>
                              </td>
                            `;
                          }
                        }
                    ],
                    "order": [],
                    "drawCallback": function(settings) {
                        var api = this.api();
                        var startIndex = api.context[0]._iDisplayStart;

                        api.column(0, {order: 'applied'}).nodes().each(function(cell, i) {
                            cell.innerHTML = startIndex + i + 1;
                        });
                    }
                  });
                } else if (filterJenis == 'Transport'){
                  table = $("#transportTable").DataTable({
                    "responsive": true,
                    "lengthChange": true,
                    "autoWidth": false,
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": "{{ route('pengeluaran_lainnya.getData', ['instansi' => $instansi]) }}",
                        "data": function(d) {
                            d.filterJenis = filterJenis;
                        }
                    },
                    "columns": [
                        { "data": null, "title": "No" },
                        { "data": "nama", "title": "Nama" },
                        { "data": "tanggal", "title": "Tanggal" },
                        { "data": "nominal", "title": "Nominal" },
                        { "data": "keterangan", "title": "Keterangan" },
                        {
                        "data": null,
                        "title": "Aksi",
                        "render": function(data, type, row) {
                          return `
                              <td class="text-center">
                                  <a href="/{{ $instansi }}/pengeluaran_lainnya/Transport/cetak/${data.id}" class="btn  bg-success pt-1 pb-1 pl-2 pr-2 rounded" target="_blank">
                                      <i class="fas fa-download"></i>
                                  </a>
                                  <a href="/{{ $instansi }}/pengeluaran_lainnya/Transport/edit/${data.id}" class="btn bg-warning pt-1 pb-1 pl-2 pr-2 rounded">
                                      <i class="fas fa-edit"></i>
                                  </a>
                                  <a href="/{{ $instansi }}/pengeluaran_lainnya/Transport/show/${data.id}" class="btn bg-secondary pt-1 pb-1 pl-2 pr-2 rounded">
                                      <i class="fas fa-eye"></i>
                                  </a>
                                  <a onclick="remove('Transport',${data.id})" class="btn bg-danger pt-1 pb-1 pl-2 pr-2 rounded">
                                      <i class="fas fa-times fa-lg"></i>
                                  </a>
                              </td>
                            `;
                          }
                        }
                    ],
                    "order": [],
                    "drawCallback": function(settings) {
                        var api = this.api();
                        var startIndex = api.context[0]._iDisplayStart;

                        api.column(0, {order: 'applied'}).nodes().each(function(cell, i) {
                            cell.innerHTML = startIndex + i + 1;
                        });
                    }
                  });
                } else if (filterJenis == 'Honor Dokter'){
                  table = $("#honorTable").DataTable({
                    "responsive": true,
                    "lengthChange": true,
                    "autoWidth": false,
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": "{{ route('pengeluaran_lainnya.getData', ['instansi' => $instansi]) }}",
                        "data": function(d) {
                            d.filterJenis = filterJenis;
                        }
                    },
                    "columns": [
                        { "data": null, "title": "No" },
                        { "data": "nama", "title": "Nama" },
                        { "data": "tanggal", "title": "Tanggal" },
                        { "data": "nominal", "title": "Total Honor" },
                        { "data": "keterangan", "title": "Keterangan" },
                        {
                        "data": null,
                        "title": "Aksi",
                        "render": function(data, type, row) {
                          return `
                              <td class="text-center">
                                  <a href="/{{ $instansi }}/pengeluaran_lainnya/Honor Dokter/cetak/${data.id}" class="btn  bg-success pt-1 pb-1 pl-2 pr-2 rounded" target="_blank">
                                      <i class="fas fa-download"></i>
                                  </a>
                                  <a href="/{{ $instansi }}/pengeluaran_lainnya/Honor Dokter/edit/${data.id}" class="btn bg-warning pt-1 pb-1 pl-2 pr-2 rounded">
                                      <i class="fas fa-edit"></i>
                                  </a>
                                  <a href="/{{ $instansi }}/pengeluaran_lainnya/Honor Dokter/show/${data.id}" class="btn bg-secondary pt-1 pb-1 pl-2 pr-2 rounded">
                                      <i class="fas fa-eye"></i>
                                  </a>
                                  <a onclick="remove('Honor Dokter',${data.id})" class="btn bg-danger pt-1 pb-1 pl-2 pr-2 rounded">
                                      <i class="fas fa-times fa-lg"></i>
                                  </a>
                              </td>
                            `;
                          }
                        }
                    ],
                    "order": [],
                    "drawCallback": function(settings) {
                        var api = this.api();
                        var startIndex = api.context[0]._iDisplayStart;

                        api.column(0, {order: 'applied'}).nodes().each(function(cell, i) {
                            cell.innerHTML = startIndex + i + 1;
                        });
                    }
                  });
                } else if (filterJenis == 'Lainnya'){
                  table = $("#lainnyaTable").DataTable({
                    "responsive": true,
                    "lengthChange": true,
                    "autoWidth": false,
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": "{{ route('pengeluaran_lainnya.getData', ['instansi' => $instansi]) }}",
                        "data": function(d) {
                            d.filterJenis = filterJenis;
                        }
                    },
                    "columns": [
                        { "data": null, "title": "No" },
                        { "data": "nama", "title": "Nama" },
                        { "data": "tanggal", "title": "Tanggal" },
                        { "data": "nominal", "title": "Nominal" },
                        { "data": "keterangan", "title": "Keterangan" },
                        {
                        "data": null,
                        "title": "Aksi",
                        "render": function(data, type, row) {
                          return `
                              <td class="text-center">
                                  <a href="/{{ $instansi }}/pengeluaran_lainnya/Lainnya/cetak/${data.id}" class="btn  bg-success pt-1 pb-1 pl-2 pr-2 rounded" target="_blank">
                                      <i class="fas fa-download"></i>
                                  </a>
                                  <a href="/{{ $instansi }}/pengeluaran_lainnya/Lainnya/edit/${data.id}" class="btn bg-warning pt-1 pb-1 pl-2 pr-2 rounded">
                                      <i class="fas fa-edit"></i>
                                  </a>
                                  <a href="/{{ $instansi }}/pengeluaran_lainnya/Lainnya/show/${data.id}" class="btn bg-secondary pt-1 pb-1 pl-2 pr-2 rounded">
                                      <i class="fas fa-eye"></i>
                                  </a>
                                  <a onclick="remove('Lainnya',${data.id})" class="btn bg-danger pt-1 pb-1 pl-2 pr-2 rounded">
                                      <i class="fas fa-times fa-lg"></i>
                                  </a>
                              </td>
                            `;
                          }
                        }
                    ],
                    "order": [],
                    "drawCallback": function(settings) {
                        var api = this.api();
                        var startIndex = api.context[0]._iDisplayStart;

                        api.column(0, {order: 'applied'}).nodes().each(function(cell, i) {
                            cell.innerHTML = startIndex + i + 1;
                        });
                    }
                  });
                }
                
                table.buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
                  if(filterJenis == 'Lainnya' || filterJenis == 'Transport' || filterJenis == 'Honor Dokter'){
                    table.column(5).visible(hasEditPermission)
                  } else {
                    table.column(6).visible(hasEditPermission)
                  }
            }

            const dataTableSearchInput = $('#perbaikanTable_filter input');

            dataTableSearchInput.off('input').on('input', debounce(function() {
                table.search(this.value).draw();
            }, 1000));
            initializeTable('Perbaikan Aset');
            
            $(document).on('change', '#filterJenis', function() {
                var filterJenis = $(this).val() ?? 'Perbaikan Aset';
                console.log(filterJenis);
                switchTable(filterJenis)
                initializeTable(filterJenis);
            });
        });

        function switchTable(jenis){
          if (jenis == 'Perbaikan Aset') {
              $('#perbaikanTable').removeClass('d-none');
              $('#outbondTable').addClass('d-none');
              $('#operasionalTable').addClass('d-none');
              $('#transportTable').addClass('d-none');
              $('#honorTable').addClass('d-none');
              $('#lainnyaTable').addClass('d-none');
          } else if (jenis == 'Outbond') {
              $('#perbaikanTable').addClass('d-none');
              $('#outbondTable').removeClass('d-none');
              $('#operasionalTable').addClass('d-none');
              $('#transportTable').addClass('d-none');
              $('#honorTable').addClass('d-none');
              $('#lainnyaTable').addClass('d-none');
          } else if (jenis == 'Operasional') {
              $('#perbaikanTable').addClass('d-none');
              $('#outbondTable').addClass('d-none');
              $('#operasionalTable').removeClass('d-none');
              $('#transportTable').addClass('d-none');
              $('#honorTable').addClass('d-none');
              $('#lainnyaTable').addClass('d-none');
          } else if (jenis == 'Transport') {
              $('#perbaikanTable').addClass('d-none');
              $('#outbondTable').addClass('d-none');
              $('#operasionalTable').addClass('d-none');
              $('#transportTable').removeClass('d-none');
              $('#honorTable').addClass('d-none');
              $('#lainnyaTable').addClass('d-none');
          } else if (jenis == 'Honor Dokter') {
              $('#perbaikanTable').addClass('d-none');
              $('#outbondTable').addClass('d-none');
              $('#operasionalTable').addClass('d-none');
              $('#transportTable').addClass('d-none');
              $('#honorTable').removeClass('d-none');
              $('#lainnyaTable').addClass('d-none');
          } else if (jenis == 'Lainnya') {
              $('#perbaikanTable').addClass('d-none');
              $('#outbondTable').addClass('d-none');
              $('#operasionalTable').addClass('d-none');
              $('#transportTable').addClass('d-none');
              $('#honorTable').addClass('d-none');
              $('#lainnyaTable').removeClass('d-none');
          }
        }

        function debounce(func, wait) {
            let timeout;
            return function(...args) {
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(this, args), wait);
            };
        }

        function remove(jenis, id){
          var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
          Swal.fire({
            title: 'Apakah Anda yakin ingin menghapus data ini?',
            text: "Tindakan ini tidak dapat dibatalkan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`pengeluaran_lainnya/${jenis}/delete/${id}`, {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                      toastr.error(response.json(), {
                        closeButton: true,
                        tapToDismiss: false,
                        rtl: false,
                        progressBar: true
                      });
                    }
                })
                .then(data => {
                  toastr.success('Data berhasil dihapus', {
                    closeButton: true,
                    tapToDismiss: false,
                    rtl: false,
                    progressBar: true
                  });
                  setTimeout(() => {
                    location.reload();
                  }, 2000);
                })
                .catch(error => {
                  toastr.error('Gagal menghapus data', {
                    closeButton: true,
                    tapToDismiss: false,
                    rtl: false,
                    progressBar: true
                  });
                });
            }
        })
        }
        var rowCount = 1;
        $('#addRow').on('click', function(e){
            e.preventDefault();
            if($('[id^=row_]').length <= 10){
                var newRow = `
                    <tr id="row_${rowCount}">
                        <td>
                          <select name="akun[]" id="akun_${rowCount}" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%" required>
                            <option value="">Pilih Akun</option>
                            @foreach ($akuns as $akun)
                                <option value="{{ $akun->id }}">{{ $akun->kode }} - {{ $akun->nama }}</option>
                            @endforeach
                          </select>
                        </td>
                        <td>
                            <input type="text" id="debit-${rowCount}" name="debit[]" class="form-control" placeholder="Nominal Debit" value="" oninput="calculate()">
                        </td>
                        <td>
                            <input type="text" id="kredit-${rowCount}" name="kredit[]" class="form-control" placeholder="Nominal Kredit" value="" oninput="calculate()">
                        </td>
                        <td>
                            <button class="btn btn-danger removeRow" id="removeRow">-</button>
                        </td>
                    </tr>
                `;
                $('#body_akun').append(newRow); 
                rowCount++;
    
                $('.select2').select2();
            }
        });
        $(document).on('click', '.removeRow', function() {
            $(this).closest('tr').remove();
        });
        $(document).on('input', '[id^=debit-], [id^=kredit-]', function() {
            let input = $(this);
            let value = input.val();
            let cursorPosition = input[0].selectionStart;
            
            if (!isNumeric(cleanNumber(value))) {
            value = value.replace(/[^\d]/g, "");
            }

            let originalLength = value.length;

            value = cleanNumber(value);
            let formattedValue = formatNumber(value);
            
            input.val(formattedValue);

            let newLength = formattedValue.length;
            let lengthDifference = newLength - originalLength;
            input[0].setSelectionRange(cursorPosition + lengthDifference, cursorPosition + lengthDifference);
        });
        $(document).on('submit', '#addForm', function(e) {
            let inputs = $(this).find('[id^=debit], [id^=kredit], [id^=nominal_debit], [id^=nominal_kredit]');
            inputs.each(function() {
                let input = $(this);
                let value = input.val();
                let cleanedValue = cleanNumber(value);

                input.val(cleanedValue);
            });

            return true;
        });
        function calculate(){
          var inputDebit = $('[id^=debit-]');
          var inputKredit = $('[id^=kredit-]');
          var total_debit = 0;
          var total_kredit = 0;
          inputDebit.each(function() {
              total_debit += parseInt(cleanNumber($(this).val())) || 0;
          });
          inputKredit.each(function() {
            total_kredit += parseInt(cleanNumber($(this).val())) || 0;
          });
          $('#debit_keseluruhan').val(formatNumber(total_debit))
          $('#kredit_keseluruhan').val(formatNumber(total_kredit))
          isMatch()
        }
        function isMatch(){
          var allDebit = cleanNumber($('#debit_keseluruhan').val());
          var allKredit = cleanNumber($('#kredit_keseluruhan').val());
          var reminder = $('#notMatch');
          var saveBtn = $('#saveBtn');
          if(allDebit == allKredit){
            reminder.addClass('d-none')
            saveBtn.attr('disabled', false)
          } else {
            reminder.removeClass('d-none')
            saveBtn.attr('disabled', true)
          }
        }
        function filter() {
            let filterTahun = $('#filterTahun').val();
            let filterBulan = $('#filterBulan').val();
            let filterTipe = $('#filterTipe').val();
            $.ajax({
                  url: 'pengeluaran_lainnya/getNominal', 
                  type: 'GET',
                  data: { 
                    bulan: filterBulan,
                    tahun: filterTahun,
                    jenis: filterTipe
                  }, 
                  headers: {
                      'X-CSRF-TOKEN': csrfToken
                  },
                  success: function(response) {
                    $(document).ready(function() {
                    $('#journable_type').val(filterTipe == 'Transport' ? 'App\\Models\\Transport' : 'App\\Models\\HonorDokter');
                  });
                    $('#add_nominal').val(formatNumber(response));
                  },
                  error: function(xhr, status, error) {
                      console.error('Error:', error);
                  }
              });
        }

        function clearFilter() {
          window.location.href = "{{ route('pengeluaran_lainnya.index', ['instansi' => $instansi]) }}";
        }
    </script>
@endsection