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
            <h1 class="m-0">Pembelian Aset Tetap</h1>
          </div>
          @if((Auth::user()->instansi_id == $data_instansi->id && in_array(Auth::user()->role, ['BENDAHARA', 'SARPRAS YAYASAN', 'SARPRAS SEKOLAH', 'TU'])) || in_array(Auth::user()->role, ['ADMIN']))
          <div class="col-sm-6">
            <a href="{{ route('pembelian-aset.create', ['instansi' => $instansi]) }}" class="btn btn-primary float-sm-right">Tambah</a>
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
                  <h3 class="card-title">Pembelian Aset Tetap</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="row mb-1">
                    <div class="col-sm-6 col-md-3 col-lg-2">
                      <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="filterSupplier" style="width: 100%" required>
                        <option value="">Supplier</option>
                        @foreach ($suppliers as $item)
                            <option value="{{ $item->id }}">{{ $item->nama_supplier }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-sm-6 col-md-3 col-lg-2">
                      <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="filterAset" style="width: 100%" required>
                        <option value="">Aset Tetap</option>
                        @foreach ($asets as $item)
                            <option value="{{ $item->id }}">{{ $item->nama_aset }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="5%">No</th>
                        <th>Supplier</th>
                        <th>Tanggal Beli</th>
                        <th>Aset Tetap</th>
                        <th>Satuan</th>
                        <th>Jumlah</th>
                        <th>Harga Satuan</th>
                        {{-- <th>Diskon</th>
                        <th>PPN</th> --}}
                        <th>Total Harga</th>
                        <th>Total</th>
                        @if((Auth::user()->instansi_id == $data_instansi->id && in_array(Auth::user()->role, ['BENDAHARA', 'SARPRAS YAYASAN', 'SARPRAS SEKOLAH', 'TU'])) || in_array(Auth::user()->role, ['ADMIN']))
                        <th width="15%">Aksi</th>
                        @endif
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($data as $item)
                          <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->supplier->nama_supplier ?? '-' }}</td>
                            <td>{{ $item->tgl_beliaset ? formatTanggal($item->tgl_beliaset) : '-' }}</td>
                            <td class="p-0">
                              <table class="table table-bordered m-0 border" style="width: 100%">
                                @foreach ($item->komponen as $komponen)
                                    <tr>
                                      <td>
                                        {{ $komponen->aset->nama_aset ?? '' }}
                                      </td>
                                    </tr>
                                @endforeach
                              </table>
                            </td>
                            <td class="p-0">
                              <table class="table table-bordered m-0 border" style="width: 100%">
                                @foreach ($item->komponen as $komponen)
                                    <tr>
                                      <td>
                                        {{ $komponen->satuan ?? '' }}
                                      </td>
                                    </tr>
                                @endforeach
                              </table>
                            </td>
                            <td class="p-0">
                              <table class="table table-bordered m-0 border" style="width: 100%">
                                @foreach ($item->komponen as $komponen)
                                    <tr>
                                      <td>
                                        {{ $komponen->jumlah ?? '' }}
                                      </td>
                                    </tr>
                                @endforeach
                              </table>
                            </td>
                            <td class="p-0">
                              <table class="table table-bordered m-0 border" style="width: 100%">
                                @foreach ($item->komponen as $komponen)
                                    <tr>
                                      <td>
                                        {{ $komponen->harga_satuan ? formatRupiah($komponen->harga_satuan) : '' }}
                                      </td>
                                    </tr>
                                @endforeach
                              </table>
                            </td>
                            {{-- <td class="p-0">
                              <table class="table table-bordered m-0 border" style="width: 100%">
                                @foreach ($item->komponen as $komponen)
                                    <tr>
                                      <td>
                                        {{ $komponen->diskon ?? '' }} %
                                      </td>
                                    </tr>
                                @endforeach
                              </table>
                            </td>
                            <td class="p-0">
                              <table class="table table-bordered m-0 border" style="width: 100%">
                                @foreach ($item->komponen as $komponen)
                                    <tr>
                                      <td>
                                        {{ $komponen->ppn ?? '' }} %
                                      </td>
                                    </tr>
                                @endforeach
                              </table>
                            </td> --}}
                            <td class="p-0">
                              <table class="table table-bordered m-0 border" style="width: 100%">
                                @foreach ($item->komponen as $komponen)
                                    <tr>
                                      <td>
                                        {{ $komponen->harga_total ? formatRupiah($komponen->harga_total) : '' }}
                                      </td>
                                    </tr>
                                @endforeach
                              </table>
                            </td>
                            <td>{{ $item->total ? formatRupiah($item->total) : '' }}</td>
                            @if((Auth::user()->instansi_id == $data_instansi->id && in_array(Auth::user()->role, ['BENDAHARA', 'SARPRAS YAYASAN', 'SARPRAS SEKOLAH', 'TU'])) || in_array(Auth::user()->role, ['ADMIN']))
                            <td class="text-center">
                              <a href="{{ route('pembelian-aset.cetak', ['id' => $item->id, 'instansi' => $instansi]) }}" class="btn bg-success pt-1 pb-1 pl-2 pr-2 rounded" target="_blank">
                                  <i class="fas fa-download"></i>
                              </a>
                              <a href="{{ route('pembelian-aset.edit', ['id' => $item->id, 'instansi' => $instansi]) }}" class="btn bg-warning pt-1 pb-1 pl-2 pr-2 rounded">
                                  <i class="fas fa-edit"></i>
                              </a>
                              <a href="{{ route('pembelian-aset.show', ['id' => $item->id, 'instansi' => $instansi]) }}" class="btn bg-secondary pt-1 pb-1 pl-2 pr-2 rounded">
                                  <i class="fas fa-eye"></i>
                              </a>
                              <a onclick="remove({{ $item->id }})" class="btn bg-danger pt-1 pb-1 pl-2 pr-2 rounded">
                                  <i class="fas fa-times fa-lg"></i>
                              </a>
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
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
@section('js')
    <script>
      $('#filterAset, #filterSupplier').on('change', applyFilters);
        $(function () {
            $("#example1").DataTable({
                "responsive": true, 
                "lengthChange": true, 
                "autoWidth": false,
                "buttons": ["excel", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });

      function applyFilters() {
          let table = $("#example1").DataTable();
          let aset = $('#filterAset').find(':selected').text();
          let supplier = $('#filterSupplier').find(':selected').text();
          if (aset === "Aset Tetap" && supplier === "Supplier") {
              table.search("").columns().search("").draw();
            } else if (aset !== "Aset Tetap" && supplier === "Supplier") {
              table.column(2).search(aset).column(1).search("").draw();
            } else if (aset === "Aset Tetap" && supplier !== "Supplier") {
              table.column(2).search("").column(1).search(supplier).draw();
          } else {
              table.column(2).search(aset).column(1).search(supplier).draw();
          }
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
                fetch(`pembelian-aset/${id}/delete`, {
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