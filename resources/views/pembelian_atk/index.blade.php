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
            <h1 class="m-0">Pembelian Atk</h1>
          </div>
          <div class="col-sm-6">
            <a href="{{ route('pembelian-atk.create', ['instansi' => $instansi]) }}" class="btn btn-primary float-sm-right">Tambah</a>
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
                <div class="card-header">
                  <h3 class="card-title">Pembelian Atk</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="row mb-1">
                    <div class="col-sm-6 col-md-3 col-lg-2">
                      <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="filterSupplier" style="width: 100%" required>
                        <option value="">Pilih Supplier</option>
                        @foreach ($suppliers as $item)
                            <option value="{{ $item->id }}">{{ $item->nama_supplier }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-sm-6 col-md-3 col-lg-2">
                      <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="filterAtk" style="width: 100%" required>
                        <option value="">Pilih Atk</option>
                        @foreach ($atks as $item)
                            <option value="{{ $item->id }}">{{ $item->nama_atk }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="5%">No</th>
                        <th>Supplier</th>
                        <th>Atk</th>
                        <th>Tanggal Beli</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Harga Satuan</th>
                        <th>Total Harga</th>
                        <th width="15%">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($data as $item)
                          <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->supplier->nama_supplier ?? '-' }}</td>
                            <td>{{ $item->atk->nama_atk ?? '-' }}</td>
                            <td>{{ $item->tgl_beliatk ? formatTanggal($item->tgl_beliatk) : '-' }}</td>
                            <td>{{ $item->jumlah_atk ?? '-' }}</td>
                            <td>{{ $item->satuan ?? '-' }}</td>
                            <td>{{ $item->hargasatuan_atk ? formatRupiah($item->hargasatuan_atk) : '-' }}</td>
                            <td>{{ $item->jumlahbayar_atk ? formatRupiah($item->jumlahbayar_atk) : '-'}}</td>
                            <td class="text-center">
                              <a href="{{ route('pembelian-atk.edit', ['id' => $item->id, 'instansi' => $instansi]) }}" class="btn bg-warning pt-1 pb-1 pl-2 pr-2 rounded">
                                  <i class="fas fa-edit"></i>
                              </a>
                              <a href="{{ route('pembelian-atk.show', ['id' => $item->id, 'instansi' => $instansi]) }}" class="btn bg-secondary pt-1 pb-1 pl-2 pr-2 rounded">
                                  <i class="fas fa-eye"></i>
                              </a>
                              <a onclick="remove({{ $item->id }})" class="btn bg-danger pt-1 pb-1 pl-2 pr-2 rounded">
                                  <i class="fas fa-times fa-lg"></i>
                              </a>
                          </td>
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
      $('#filterAtk, #filterSupplier').on('change', applyFilters);
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
          let atk = $('#filterAtk').find(':selected').text();
          let supplier = $('#filterSupplier').find(':selected').text();
          if (atk === "Pilih Atk" && supplier === "Pilih Supplier") {
              table.search("").columns().search("").draw();
            } else if (atk !== "Pilih Atk" && supplier === "Pilih Supplier") {
              table.column(2).search(atk).column(1).search("").draw();
            } else if (atk === "Pilih Atk" && supplier !== "Pilih Supplier") {
              table.column(2).search("").column(1).search(supplier).draw();
          } else {
              table.column(2).search(atk).column(1).search(supplier).draw();
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
                fetch(`pembelian-atk/${id}/delete`, {
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