@extends('layout')
@section('css')
    <style>
      .floating-button {
            position: fixed;
            top: 15%;
            right: 20px;
            cursor: pointer;
            z-index: 1000;
        }
    </style>
@endsection
@section('content')
     <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Jurnal</h1>
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
                  <h3 class="card-title">Jurnal</h3>
                </div>
                
                <!-- /.card-header -->
                <form action="{{ route('jurnal.save', ['instansi' => $instansi]) }}" method="post">
                  @csrf
                  <div class="card-body">
                    <div class="row mb-1">
                      <div class="col-sm-6 col-md-3 col-lg-2">
                        <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="filterTahun" style="width: 100%">
                          <option value="">Pilih Tahun</option>
                          @foreach ($tahun as $item)
                              <option value="{{ $item }}" {{ request()->input('tahun') == $item ? 'selected' : '' }}>{{ $item }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="col-sm-6 col-md-3 col-lg-2">
                        <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="filterBulan" style="width: 100%">
                          <option value="">Pilih Bulan</option>
                          @foreach ($bulan as $key => $value)
                              <option value="{{ $key }}" {{ request()->input('bulan') == $key ? 'selected' : '' }}>{{ $value }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="col-sm-6 col-md-3 col-lg-2">
                        <button class="btn btn-primary" type="button" onClick="filter()">Filter</button>
                        <button class="btn btn-danger" type="button" onClick="clearFilter()">Clear</button>
                      </div>
                      <div class="col-sm-6 col-md-3 col-lg-2 ml-auto text-right">
                        <button class="btn btn-success" type="button" id="btnExcel" onClick="excel()"><i class="far fa-file-excel"></i></button>
                        <button class="btn btn-warning" type="button" id="btnEdit"><i class="far fa-edit"></i></button>
                        <button class="btn btn-success d-none" type="submit" id="btnSave"><i class="fas fa-check"></i></button>
                        <button class="btn btn-danger d-none" type="button" id="btnClose"><i class="fas fa-times"></i></button>
                      </div>
                    </div>
                    
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th width="5%">No</th>
                          <th>Tanggal</th>
                          <th>Keterangan</th>
                          <th>Akun Debit</th>
                          <th>Akun Kredit</th>
                          <th>Nominal</th>
                        </tr>
                      </thead>
                      <tbody id="tableBody">
                        @php
                            $i = 0;
                        @endphp
                        @foreach ($data as $item)
                          <tr>
                            <td>{{ $i + 1 }}<input type="hidden" name="id[]" id="id_{{ $i }}" value="{{ $item->id }}"></td>
                            <td><input type="date" class="form-control" name="tanggal[]" id="tanggal_{{ $i }}" value="{{ \Carbon\Carbon::createFromFormat('Y-m-d', $item->tanggal)->format('Y-m-d') }}" disabled></td>
                            <td><input type="text" class="form-control" name="keterangan[]" id="keterangan_{{ $i }}" value="{{ $item->keterangan }}" disabled></td>
                            <td>
                              <select name="akun_debit[]" id="akun_debit_{{ $i }}" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%" disabled>
                                <option value="">--Belum diset--</option>
                                @foreach ($akuns as $akun)
                                    <option value="{{ $akun->id }}" {{ $item->akun_debit == $akun->id ? 'selected' : '' }}>{{ $akun->kode }} - {{ $akun->nama }}</option>
                                @endforeach
                              </select>
                            </td>
                            <td>
                              <select name="akun_kredit[]" id="akun_kredit_{{ $i }}" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%" disabled>
                                <option value="">--Belum diset--</option>
                                @foreach ($akuns as $akun)
                                    <option value="{{ $akun->id }}" {{ $item->akun_kredit == $akun->id ? 'selected' : '' }}>{{ $akun->kode }} - {{ $akun->nama }}</option>
                                @endforeach
                              </select>
                            </td>
                            <td><input type="text" class="form-control" name="nominal[]" id="nominal_{{ $i }}" value="{{ formatRupiah($item->nominal) }}" disabled></td>
                          </tr>
                          @php
                              $i++;
                          @endphp
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </form>
              </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <button id="floatingButton" class="btn btn-primary floating-button rounded-circle p-auto" data-toggle="modal" data-target="#modal-list-akun"><i class="fas fa-list"></i></button>

  {{-- modal start --}}
  <div class="modal fade" id="modal-list-akun">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">List Akun</h4>
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
          <table id="tableAkun" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th style="width: 5%;">No</th>
                <th>Nomor Akun</th>
                <th>Nama Akun</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($akuns as $item)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $item->kode }}</td>
                  <td>{{ $item->nama }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  {{-- modal end --}}
@endsection
@section('js')
    <script>
      var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      $(document).ready(function() {
        $('#btnEdit').click(function() {
          $(this).addClass('d-none');
          $('#btnSave, #btnClose').removeClass('d-none')
          $('[id^=akun_]').attr('disabled', false)
        });

        $('#btnClose, #btnSave').click(function() {
          $('#btnEdit').removeClass('d-none');
          $('#btnSave, #btnClose').addClass('d-none');
        });
      });
      $("#tableAkun").DataTable({
                "responsive": true, 
                "lengthChange": true, 
                "autoWidth": false,
                "lengthMenu": [5, 10, 20, 25]
            })
        $(function () {
            $("#example1").DataTable({
                "responsive": true, 
                "lengthChange": true, 
                "autoWidth": false,
                "buttons": ["excel", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });

      function filter() {
          let filterTahun = $('#filterTahun').val();
          let filterBulan = $('#filterBulan').val();

          let url = "{{ route('jurnal.index', ['instansi' => $instansi]) }}";
          let queryString = '?tahun=' + filterTahun + '&bulan=' + filterBulan;
          window.location.href = url + queryString;
      }

      function clearFilter() {
        window.location.href = "{{ route('jurnal.index', ['instansi' => $instansi]) }}";
      }

      function excel() {
        let filterTahun = $('#filterTahun').val();
        let filterBulan = $('#filterBulan').val();

        if (!filterTahun || !filterBulan) {
            toastr.error('Semua filter harus diisi', {
                closeButton: true,
                tapToDismiss: false,
                rtl: false,
                progressBar: true
            });
            return;
        }

        let url = "{{ route('jurnal.excel', ['instansi' => $instansi]) }}";
        let queryString = '?tahun=' + filterTahun + '&bulan=' + filterBulan;
        window.location.href = url + queryString;
      }
    </script>
@endsection