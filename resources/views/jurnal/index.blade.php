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
          @if((Auth::user()->instansi_id == $data_instansi->id && in_array(Auth::user()->role, ['BENDAHARA'])) || in_array(Auth::user()->role, ['ADMIN']))
          <div class="col-sm-6">
            <button class="btn btn-primary float-sm-right" data-target="#modal-jurnal-create" data-toggle="modal">Tambah</button>
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
                  <h3 class="card-title">Jurnal</h3>
                </div>
                
                <!-- /.card-header -->
                <form id="addForm" action="{{ route('jurnal.save', ['instansi' => $instansi]) }}" method="post">
                  @csrf
                  <div class="card-body">
                    <div class="row mb-1">
                      <div class="col-sm-6 col-md-4 col-lg-2">
                        <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="filterTahun" style="width: 100%">
                          <option value="">Pilih Tahun</option>
                          @foreach ($tahun as $item)
                              <option value="{{ $item }}" {{ request()->input('tahun') == $item ? 'selected' : '' }}>{{ $item }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="col-sm-6 col-md-4 col-lg-2">
                        <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="filterBulan" style="width: 100%">
                          <option value="">Pilih Bulan</option>
                          @foreach ($bulan as $key => $value)
                              <option value="{{ $key }}" {{ request()->input('bulan') == $key ? 'selected' : '' }}>{{ $value }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="col-sm-6 col-md-4 col-lg-8 d-flex justify-content-between">
                        <div>
                          <button class="btn btn-primary" type="button" onClick="filter()">Filter</button>
                          <button class="btn btn-warning" type="button" onClick="clearFilter()">Clear</button>
                        </div>
                        <div>
                          <button class="btn btn-success" type="button" id="btnExcel" onClick="excel()"><i class="far fa-file-excel"></i></button>
                          <button class="btn btn-danger ml-1" type="button" id="btnPdf" onclick="pdf()"><i class="far fa-file-pdf"></i></button>
                        </div>
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
                        <div class="row mt-3">
                          <div class="col-sm-6 col-md-4 col-lg-3">
                              <div class="form-group">
                                  <label>Total Debit</label>
                                  <div class="input-group mb-3">
                                    <input type="text" id="total_debit" name="total_debit" class="form-control" placeholder="Saldo Awal" value="{{ $jumlah ? formatRupiah($jumlah) : 0 }}" readonly required>
                                  </div>
                              </div>
                          </div>
                          <div class="col-sm-6 col-md-4 col-lg-3">
                              <div class="form-group">
                                  <label>Total Kredit</label>
                                  <div class="input-group mb-3">
                                    <input type="text" id="total_kredit" name="total_kredit" class="form-control" placeholder="Saldo Akhir" value="{{ $jumlah ? formatRupiah($jumlah) : 0 }}" readonly required>
                                  </div>
                              </div>
                          </div>
                          <div class="col-sm-6 col-md-4 col-lg-3 d-flex align-items-center pt-3">
                            <button class="btn btn-warning" type="button" id="btnEdit"><i class="far fa-edit"></i></button>
                            <button class="btn btn-success d-none" type="submit" id="btnSave"><i class="fas fa-check"></i></button>
                            <button class="btn btn-danger d-none ml-1" type="button" id="btnClose"><i class="fas fa-times"></i></button>
                          </div>
                        </div>
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
  <div class="modal fade" id="modal-jurnal-create">
    <div class="modal-dialog modal-sm">
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
            <div class="form-group">
              <label for="kode">Akun Debit</label>
              <select name="akun_debit" id="add_akun_debit" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%" required>
                <option value="">Pilih Akun Debit</option>
                @foreach ($akuns as $akun)
                    <option value="{{ $akun->id }}" {{ old('akun_debit') == $akun->id ? 'selected' : '' }}>{{ $akun->kode }} - {{ $akun->nama }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="nama">Nama Akun</label>
              <select name="akun_kredit" id="add_akun_kredit" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%" required>
                <option value="">Pilih Akun Kredit</option>
                @foreach ($akuns as $akun)
                    <option value="{{ $akun->id }}" {{ old('akun_kredit') == $akun->id ? 'selected' : '' }}>{{ $akun->kode }} - {{ $akun->nama }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="nominal">Nominal</label>
              <input type="text" class="form-control" id="add_nominal" name="nominal" placeholder="Nominal" value="{{ old('nominal') }}" required>
            </div>
            <div class="form-group">
              <label for="tanggal">Tanggal</label>
              <input type="date" class="form-control" id="add_tanggal" name="tanggal" placeholder="tanggal" value="{{ old('tanggal') ?? date('Y-m-d') }}" required>
            </div>
            <div class="form-group">
              <label for="keterangan">Keterangan</label>
              <textarea name="keterangan" id="add_keterangan" class="form-control"></textarea>
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
  {{-- modal end --}}
@endsection
@section('js')
    <script>
      var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      $(document).ready(function() {
        $(document).on('input', '#add_nominal', function() {
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
            let inputs = $(this).find('#add_nominal');
            inputs.each(function() {
                let input = $(this);
                let value = input.val();
                let cleanedValue = cleanNumber(value);

                input.val(cleanedValue);
            });

            return true;
        });
        $('#btnEdit').click(function() {
          $(this).addClass('d-none');
          $('#btnSave, #btnClose').removeClass('d-none')
          $('[id^=akun_]').attr('disabled', false)
        });

        $('#btnClose, #btnSave').click(function() {
          $('#btnEdit').removeClass('d-none');
          $('#btnSave, #btnClose').addClass('d-none');
          $('[id^=akun_]').attr('disabled', true)
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

      function pdf() {
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

        let url = "{{ route('jurnal.pdf', ['instansi' => $instansi]) }}";
        let queryString = '?tahun=' + filterTahun + '&bulan=' + filterBulan;
        window.open(url + queryString, '_blank');
      }
    </script>
@endsection