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
                <div class="card-body">
                  <div class="row mb-1">
                    <div class="col-sm-6 col-md-3 col-lg-2">
                      <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="filterKelas" style="width: 100%" required>
                        <option value="">Pilih Kelas</option>
                        {{-- @foreach ($kelas as $item)
                            <option value="{{ $item->id }}">{{ $item->kelas }}</option>
                        @endforeach --}}
                      </select>
                    </div>
                    <div class="col-sm-6 col-md-3 col-lg-2 ml-auto text-right">
                      <button class="btn btn-warning" id="btnEdit"><i class="far fa-edit"></i></button>
                      <button class="btn btn-success d-none" id="btnSave"><i class="fas fa-check"></i></button>
                      <button class="btn btn-danger d-none" id="btnClose"><i class="fas fa-times"></i></button>
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
                    <tbody>
                      @php
                          $i = 0;
                      @endphp
                      @foreach ($data as $item)
                        <tr>
                          <td>1<input type="hidden" name="id[]" id="id_{{ $i }}" value="{{ $item->id }}"></td>
                          <td><input type="date" class="form-control" name="tanggal[]" id="tanggal_{{ $i }}" value="{{ $item->created_at->format('Y-m-d') }}" disabled></td>
                          <td><input type="text" class="form-control" name="keterangan[]" id="keterangan_{{ $i }}" value="{{ $item->keterangan }}" disabled></td>
                          <td>
                            <select name="akun_debit" id="akun_debit_{{ $i }}" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%" disabled>
                              <option value="">--Belum diset--</option>
                              @foreach ($akuns as $akun)
                                  <option value="{{ $akun->id }}">{{ $akun->kode }} - {{ $akun->nama }}</option>
                              @endforeach
                            </select>
                          </td>
                          <td>
                            <select name="akun_kredit" id="akun_kredit_{{ $i }}" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%" disabled>
                              <option value="">--Belum diset--</option>
                              @foreach ($akuns as $akun)
                                  <option value="{{ $akun->id }}">{{ $akun->kode }} - {{ $akun->nama }}</option>
                              @endforeach
                            </select>
                          </td>
                          <td><input type="text" class="form-control" name="nominal[]" id="nominal_{{ $i }}" value="{{ formatRupiah($item->nominal) }}" disabled></td>
                        </tr>
                        @php
                            $i++;
                        @endphp
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
      $(document).ready(function() {
        $('#btnEdit').click(function() {
          $(this).addClass('d-none'); // Hide Edit button
          $('#btnSave, #btnClose').removeClass('d-none'); // Show Save and Close buttons
        });

        $('#btnClose, #btnSave').click(function() {
          $('#btnEdit').removeClass('d-none'); // Show Edit button
          $('#btnSave, #btnClose').addClass('d-none'); // Hide Save and Close buttons
        });
      });
      $("#tableAkun").DataTable({
                "responsive": true, 
                "lengthChange": true, 
                "autoWidth": false,
                "lengthMenu": [5, 10, 20, 25]
            })
      $('#filterKelas').on('change', applyFilters);
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
        let Kelas = $('#filterKelas').find(':selected').text();
        if (Kelas === "Pilih Kelas") {
            table.search("").draw();
        } else {
            table.column(2).search(Kelas).draw();
        }
      }
    </script>
@endsection