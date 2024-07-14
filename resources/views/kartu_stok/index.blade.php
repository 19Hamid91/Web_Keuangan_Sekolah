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
            <h1 class="m-0">Kartu Stok</h1>
          </div>
          @if((Auth::user()->instansi_id == $data_instansi->id && in_array(Auth::user()->role, ['BENDAHARA', 'SARPRAS YAYASAN', 'SARPRAS SEKOLAH', 'TU'])) || in_array(Auth::user()->role, ['ADMIN']))
          <div class="col-sm-6">
            <a href="{{ route('kartu-stok.create', ['instansi' => $instansi]) }}" class="btn btn-primary float-sm-right">Tambah</a>
            <a href="javascript:void(0);" data-target="#modal-jurnal-create" data-toggle="modal" data-journable_id="{{ 0 }}" data-journable_type="{{ 'App\Models\KartuStok' }}" data-nominal="{{ $totalPerBulan }}" class="btn btn-success mr-1 rounded float-sm-right">
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
                  <h3 class="card-title">Kartu Stok</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="row mb-1">
                    <div class="col-sm-4 col-md-3 col-lg-2">
                      <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="filterAtk" style="width: 100%">
                        <option value="">ATK</option>
                        @foreach ($atks as $item)
                            <option value="{{ $item->id }}" {{ request()->input('atk') == $item->id ? 'selected' : '' }}>{{ $item->nama_atk }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-sm-4 col-md-3 col-lg-2">
                      <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="filterTahun" style="width: 100%">
                        <option value="">Tahun</option>
                        @foreach ($tahun as $item)
                            <option value="{{ $item }}" {{ request()->input('tahun') == $item ? 'selected' : '' }}>{{ $item }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-sm-4 col-md-3 col-lg-2">
                      <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="filterBulan" style="width: 100%">
                        <option value="">Bulan</option>
                        @foreach ($bulan as $key => $value)
                            <option value="{{ $key }}" {{ request()->input('bulan') == $key ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-sm-4 col-md-3 col-lg-6 d-flex justify-content-between">
                      <div>
                        <button class="btn btn-primary" type="button" onClick="filter()">Filter</button>
                        <button class="btn btn-warning" type="button" onClick="clearFilter()">Clear</button>
                      </div>
                      {{-- <div>
                        <button class="btn btn-success" type="button" id="btnExcel" onClick="excel()"><i class="far fa-file-excel"></i></button>
                        <button class="btn btn-danger ml-1" type="button" id="btnPdf" onclick="pdf()"><i class="far fa-file-pdf"></i></button>
                      </div> --}}
                    </div>
                  </div>
                  <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th width="5%">No</th>
                          <th>Atk</th>
                          <th>Tanggal</th>
                          <th>Pengambil/Supplier</th>
                          <th width="5%">Masuk</th>
                          <th>Harga/Unit Masuk</th>
                          <th>Total Masuk</th>
                          <th width="5%">Keluar</th>
                          <th>Harga/Unit Keluar</th>
                          <th>Total Keluar</th>
                          <th width="5%">Saldo</th>
                          <th>Harga/Unit Rata-rata</th>
                          <th>Total Saldo</th>
                          @if((Auth::user()->instansi_id == $data_instansi->id && in_array(Auth::user()->role, ['BENDAHARA', 'SARPRAS YAYASAN', 'SARPRAS SEKOLAH', 'TU'])) || in_array(Auth::user()->role, ['ADMIN']))
                          <th width="15%">Aksi</th>
                          @endif
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->atk->nama_atk ?? '-' }}</td>
                                <td>{{ $item->tanggal ? formatTanggal($item->tanggal) : '-' }}</td>
                                <td>{{ $item->pengambil ?? '-' }}</td>
                                <td>{{ $item->masuk ?? '-' }}</td>
                                <td>{{ $item->masuk != 0 ? formatRupiah($item->harga_unit_masuk) : '-' }}</td>
                                <td>{{ $item->masuk != 0 ? formatRupiah($item->total_harga_masuk) : '-' }}</td>
                                <td>{{ $item->keluar ?? '-' }}</td>
                                <td>{{ $item->keluar != 0 ? formatRupiah($item->harga_unit_keluar) : '-' }}</td>
                                <td>{{ $item->keluar != 0 ? formatRupiah($item->total_harga_keluar) : '-' }}</td>
                                <td>{{ $item->sisa ?? '-' }}</td>
                                <td>{{ $item->sisa != 0 ? formatRupiah($item->harga_rata_rata) : '-' }}</td>
                                <td>{{ $item->sisa != 0 ? formatRupiah($item->total_harga_stok) : '-' }}</td>
                                @if((Auth::user()->instansi_id == $data_instansi->id && in_array(Auth::user()->role, ['BENDAHARA', 'SARPRAS YAYASAN', 'SARPRAS SEKOLAH', 'TU'])) || in_array(Auth::user()->role, ['ADMIN']))
                                  <td class="text-center">
                                    @if(!$item->pembelian_atk_id)
                                    <button onclick="remove({{ $item->id }})" class="bg-danger pt-1 pb-1 pl-2 pr-2 rounded">
                                        <i class="fas fa-times fa-lg"></i>
                                    </button>
                                    @endif
                                  </td>
                                @endif
                            </tr>
                        @endforeach
                    </table>
                  </div>
                </div>
              </div>
          </div>
        </div>
        {{-- <div class="row">
          <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                  <h3 class="card-title">ATK Periode Berjalan</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="row mb-1">
                    <div class="col-sm-4 col-md-3 col-lg-2">
                      <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="filterAtk2" style="width: 100%">
                        <option value="">ATK</option>
                        @foreach ($atks as $item)
                            <option value="{{ $item->id }}" {{ request()->input('atk2') == $item->id ? 'selected' : '' }}>{{ $item->nama_atk }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-sm-4 col-md-3 col-lg-2">
                      <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="filterTahun2" style="width: 100%">
                        <option value="">Pilih Tahun</option>
                        @foreach ($tahun as $item)
                            <option value="{{ $item }}" {{ request()->input('tahun2') == $item ? 'selected' : '' }}>{{ $item }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-sm-4 col-md-3 col-lg-2">
                      <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="filterBulan2" style="width: 100%">
                        <option value="">Pilih Bulan</option>
                        @foreach ($bulan as $key => $value)
                            <option value="{{ $key }}" {{ request()->input('bulan2') == $key ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-6 d-flex justify-content-between">
                      <div>
                        <button class="btn btn-primary" type="button" onClick="filter()">Filter</button>
                        <button class="btn btn-warning" type="button" onClick="clearFilter()">Clear</button>
                      </div>
                      <div>
                        <button class="btn btn-success" type="button" id="btnJurnal" onClick="jurnal()">Tambah Jurnal</button>
                      </div>
                    </div>
                  </div>
                  <table id="example2" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="5%">No</th>
                        <th>Atk</th>
                        <th>Jumlah ATK Masuk</th>
                        <th>Total Harga Perolehan</th>
                        <th>Harga Rata-rata per Unit</th>
                        <th>Jumlah ATK Keluar</th>
                        <th>Jumlah Penggunaan ATK</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($result as $item)
                          <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item['atk'] ?? '-' }}</td>
                            <td>{{ $item['total_masuk'] ?? '-' }}</td>
                            <td>{{ $item['total_harga'] ? formatRupiah($item['total_harga']) : '-' }}</td>
                            <td>{{ $item['harga_per_unit'] ? formatRupiah($item['harga_per_unit']) : '-' }}</td>
                            <td>{{ $item['total_keluar'] ?? 0 }}</td>
                            <td>{{ $item['harga_per_penggunaan'] ? formatRupiah($item['harga_per_penggunaan']) : 0 }}</td>
                          </tr>
                      @endforeach
                  </table>
                </div>
              </div>
          </div>
        </div> --}}
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
          <form id="addForm" action="{{ route('jurnal.store', ['instansi' => $instansi]) }}" method="post">
            @csrf
            <input type="hidden" id="journable_id" name="journable_id" value="">
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
        $(document).ready(function(){
          $('.daterange').daterangepicker();
        })
        $(function () {
            $("#example1").DataTable({
                "responsive": true, 
                "lengthChange": true, 
                "autoWidth": false,
                "buttons": ["excel", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $("#example2").DataTable({
                "responsive": true, 
                "lengthChange": true, 
                "autoWidth": false,
                "buttons": ["excel", "colvis"]
            }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
        });
        function filter() {
          let filterAtk = $('#filterAtk').val();
          let filterAtk2 = $('#filterAtk2').val();
          let filterTahun = $('#filterTahun').val();
          let filterBulan = $('#filterBulan').val();
          let filterTahun2 = $('#filterTahun2').val();
          let filterBulan2 = $('#filterBulan2').val();

          let url = "{{ route('kartu-stok.index', ['instansi' => $instansi]) }}";
          let queryString = '?tahun=' + filterTahun + '&bulan=' + filterBulan + '&atk=' + filterAtk + '&tahun2=' + filterTahun2 + '&bulan2=' + filterBulan2 + '&atk2=' + filterAtk2;
          window.location.href = url + queryString;
      }

      function clearFilter() {
        window.location.href = "{{ route('kartu-stok.index', ['instansi' => $instansi]) }}";
      }

      function jurnal() {
        let filterTahun2 = $('#filterTahun2').val();
        let filterBulan2 = $('#filterBulan2').val();
        if (!filterTahun2 || !filterBulan2) {
            toastr.error('Semua filter harus diisi', {
                closeButton: true,
                tapToDismiss: false,
                rtl: false,
                progressBar: true
            });
            return;
        }
        $.ajax({
                  url: "kartu-stok/jurnal",
                  type: 'GET',
                  data: { 
                    tahun2: filterTahun2,
                    bulan2: filterBulan2,
                   }, 
                  headers: {
                      'X-CSRF-TOKEN': csrfToken
                  },
                  success: function(response) {
                    toastr.success(response, {
                        closeButton: true,
                        tapToDismiss: false,
                        rtl: false,
                        progressBar: true
                    });
                  },
                  error: function(xhr, status, error) {
                    toastr.error(error, {
                        closeButton: true,
                        tapToDismiss: false,
                        rtl: false,
                        progressBar: true
                    });
                  }
              });
      }

      function remove(id){
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
                fetch(`kartu-stok/${id}/delete`, {
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
    </script>
@endsection