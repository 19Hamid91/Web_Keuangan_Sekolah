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
            <h1 class="m-0">Buku Besar</h1>
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
                  <h3 class="card-title">Buku Besar</h3>
                </div>
                
                <!-- /.card-header -->
                <form id="form" action="{{ route('bukubesar.save', ['instansi' => $instansi]) }}" method="post">
                  @csrf
                  <div class="card-body">
                    <div class="row mb-1">
                      <div class="col-sm-6 col-md-3 col-lg-2">
                        <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="filterAkun" name="akun" style="width: 100%" required>
                          <option value="">Pilih Akun</option>
                          @foreach ($akun as $item)
                              <option value="{{ $item->id }}" {{ request()->input('akun') == $item->id ? 'selected' : '' }} data-saldo_awal="{{ $item->saldo_awal }}">{{ $item->kode }}-{{ $item->nama }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="col-sm-6 col-md-3 col-lg-2">
                        <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="filterTahun" name="tahun" style="width: 100%" required>
                          <option value="">Pilih Tahun</option>
                          @foreach ($tahun as $item)
                              <option value="{{ $item }}" {{ request()->input('tahun') == $item ? 'selected' : '' }}>{{ $item }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="col-sm-6 col-md-3 col-lg-2">
                        <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="filterBulan" name="bulan" style="width: 100%" required>
                          <option value="">Pilih Bulan</option>
                          @foreach ($bulan as $key => $value)
                              <option value="{{ $key }}" {{ request()->input('bulan') == $key ? 'selected' : '' }}>{{ $value }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="col-sm-6 col-md-3 col-lg-6 d-flex justify-content-between">
                        <div>
                            <button class="btn btn-primary" type="button" onClick="filter()">Filter</button>
                            <button class="btn btn-warning" type="button" onClick="clearFilter()">Clear</button>
                        </div>
                        <div class="ml-auto">
                          <button class="btn btn-secondary" type="submit" id="btnSave"><i class="fas fa-check"></i> | Save Saldo</button>
                          <button class="btn btn-success" type="button" id="btnExcel" onclick="excel()"><i class="far fa-file-excel"></i></button>
                        </div>
                      </div>
                    </div>
                    
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th width="5%">No</th>
                          <th>Tanggal</th>
                          <th>Keterangan</th>
                          <th>Debit</th>
                          <th>Kredit</th>
                          <th>Saldo</th>
                        </tr>
                      </thead>
                      <tbody id="tableBody">
                        <div class="row mt-3">
                            <div class="col-sm-6 col-md-4 col-lg-3">
                                <div class="form-group">
                                    <label>Saldo Awal</label>
                                    <div class="input-group mb-3">
                                      <input type="text" id="saldo_awal" name="saldo_awal" class="form-control" placeholder="Saldo Awal" value="{{ $saldo_awal ? formatRupiah($saldo_awal) : 0 }}" readonly required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4 col-lg-3">
                                <div class="form-group">
                                    <label>Saldo Akhir</label>
                                    <div class="input-group mb-3">
                                      <input type="text" id="saldo_akhir" name="saldo_akhir" class="form-control" placeholder="Saldo Akhir" value="{{ $saldo_akhir ? formatRupiah($saldo_akhir) : 0 }}" readonly required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php
                            $i = 0;
                            $temp_saldo = $saldo_awal;
                        @endphp
                        @foreach ($data as $item)
                          <tr>
                            <td>
                                {{ $loop->iteration }}<input type="hidden" name="id[]" id="id_{{ $i }}" value="{{ $item->id }}">
                            </td>
                            <td>
                                <input type="date" class="form-control" name="tanggal[]" id="tanggal_{{ $i }}" value="{{ \Carbon\Carbon::createFromFormat('Y-m-d', $item->tanggal)->format('Y-m-d') }}" disabled>
                            </td>
                            <td>
                                <input type="text" class="form-control" name="keterangan[]" id="keterangan_{{ $i }}" value="{{ $item->keterangan }}" disabled>
                            </td>
                            <td>
                                <input type="text" class="form-control" name="debit[]" id="debit_{{ $i }}" value="{{ $item->akun_debit ? formatRupiah($item->nominal) : 0 }}" disabled>
                            </td>
                            <td>
                                <input type="text" class="form-control" name="kredit[]" id="kredit_{{ $i }}" value="{{ $item->akun_kredit ? formatRupiah($item->nominal) : 0 }}" disabled>
                            </td>
                            <td>
                                <input type="text" class="form-control" name="saldo[]" id="saldo_{{ $i }}" value="{{ $item->akun_debit ? formatRupiah($saldo_awal += $item->nominal) : formatRupiah($saldo_awal -= $item->nominal) }}" disabled>
                            </td>
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
@endsection
@section('js')
    <script>
      var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      $(document).ready(function() {

        $('#form').on('submit', function(e) {
            let inputs = $('#form').find('[id^=saldo_]');
            inputs.each(function() {
                let input = $(this);
                let value = input.val().trim();
                let cleanedValue = value.replace(/[^\d-]/g, "");

                input.val(cleanedValue);
            });
            return true;
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
          let filterAkun = $('#filterAkun').val();

          if (!filterTahun || !filterBulan || !filterAkun) {
                toastr.error('Semua filter harus diisi', {
                    closeButton: true,
                    tapToDismiss: false,
                    rtl: false,
                    progressBar: true
                });
                return;
            }

          let url = "{{ route('bukubesar.index', ['instansi' => $instansi]) }}";
          let queryString = '?tahun=' + filterTahun + '&bulan=' + filterBulan + '&akun=' + filterAkun;
          window.location.href = url + queryString;
      }

      function clearFilter() {
        window.location.href = "{{ route('bukubesar.index', ['instansi' => $instansi]) }}";
      }

      function excel() {
        let filterAkun = $('#filterAkun').val();
        let filterTahun = $('#filterTahun').val();
        let filterBulan = $('#filterBulan').val();
        
        if (!filterTahun || !filterBulan || !filterAkun) {
            toastr.error('Semua filter harus diisi', {
                closeButton: true,
                tapToDismiss: false,
                rtl: false,
                progressBar: true
            });
            return;
        }

        let url = "{{ route('bukubesar.excel', ['instansi' => $instansi]) }}";
        let queryString = '?tahun=' + filterTahun + '&bulan=' + filterBulan + '&akun=' + filterAkun;
        window.location.href = url + queryString;
      }
    </script>
@endsection