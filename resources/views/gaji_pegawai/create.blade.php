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
            <h1 class="m-0">Tambah Data Gaji Pegawai</h1>
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
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ route('gaji_pegawai.store') }}" method="post">
                        @csrf
                        <h3 class="text-center font-weight-bold">Data Gaji Pegawai</h3>
                        <br><br>
                        <div class="row">
                          <div class="col-sm-4">
                            <div class="form-group">
                            <label>Pegawai</label>
                            <select class="form-control select2" data-dropdown-css-class="select2-danger" style="width: 100%;" id="nip" name="nip" required>
                              <option value="">Pilih Pegawai</option>
                              @foreach ($pegawai as $item)
                                  <option value="{{ $item->nip }}">{{ $item->nama_pegawai }}</option>
                              @endforeach
                            </select>
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                            <label>Tanggal</label>
                            <input type="date" id="tanggal" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" placeholder="Tanggal" required>
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                            <label>Status</label>
                            <select class="form-control select2" data-dropdown-css-class="select2-danger" style="width: 100%;" id="status" name="status" required>
                              <option value="PENDING" selected>Pending</option>
                              <option value="SELESAI">Selesai</option>
                              <option value="Batal">Batal</option>
                            </select>
                            </div>
                          </div>
                        </div>
                        <hr>
                        <div class="row">
                          <div class="col-sm-4">
                              <div class="form-group">
                                  <label>Komponen Gaji</label>
                              </div>
                          </div>
                          <div class="col-sm-1">
                              <div class="form-group">
                                  <label>Jumlah</label>
                              </div>
                          </div>
                          <div class="col-sm-2">
                              <div class="form-group">
                                  <label>Nominal</label>
                              </div>
                          </div>
                          <div class="col-sm-2">
                              <div class="form-group">
                                  <label>Jenis</label>
                              </div>
                          </div>
                          <div class="col-sm-3">
                              <div class="form-group">
                                  <label>Sum</label>
                              </div>
                          </div>
                      </div>
                      @php
                          $i = 0;
                      @endphp
                      @foreach ($komponenGaji as $item)
                      @php
                          $jenis = $item->jenis == 'PENGURANGAN' ? 'pengurangan' : 'penambahan';
                          $minus = $jenis == 'pengurangan' ? -1 : 1;
                      @endphp
                      <div class="row" id="row_{{ $i }}">
                          <div class="col-sm-4">
                              <div class="form-group">
                                  <select class="form-control select2" data-dropdown-css-class="select2-danger" style="width: 100%;" id="kode_komponen_gaji_{{ $i }}" name="kode_komponen_gaji[]" required>
                                      <option value="{{ $item->kode }}">{{ $item->transaksi->nama_transaksi }}</option>
                                  </select>
                              </div>
                          </div>
                          <div class="col-sm-1">
                              <div class="form-group">
                                  <input type="number" id="jumlah_{{ $i }}" name="jumlah[]" class="form-control" value="1" oninput="calculate({{ $i }}, '{{ $jenis }}')" placeholder="Jumlah" required>
                              </div>
                          </div>
                          <div class="col-sm-2">
                              <div class="form-group">
                                  <input type="text" id="nominal_{{ $i }}" name="nominal[]" class="form-control" value="{{ $item->nominal }}" oninput="calculate({{ $i }}, '{{ $jenis }}')" placeholder="Nominal" required>
                              </div>
                          </div>
                          <div class="col-sm-2">
                              <div class="form-group">
                                  <input type="text" id="jenis_{{ $i }}" name="jenis[]" class="form-control" value="{{ $item->jenis }}" placeholder="Nominal" readonly>
                              </div>
                          </div>
                          <div class="col-sm-3">
                              <div class="form-group">
                                  <input type="text" id="sum_{{ $i }}" name="sum[]" class="form-control" value="{{ intval($item->nominal) * 1 * $minus }}" placeholder="Sum" readonly>
                              </div>
                          </div>
                      </div>
                      @php
                          $i++;
                      @endphp
                      @endforeach
                      
                        <div class="row">
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label for="">Total</label>
                              <input type="text" class="form-control" id="total_gaji" name="total_gaji" value="" placeholder="Total Gaji" readonly>
                            </div>
                          </div>
                        </div>
                        <div>
                            <a href="{{ route('gaji_pegawai.index') }}" class="btn btn-secondary" type="button">Back</a>
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>
                    </form>
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
      var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      $(document).ready(function() {
        sumTotal();
      });
      function calculate(index, jenis){
        var jumlah = $('#jumlah_' + index).val();
        var nominal = $('#nominal_' + index).val();
        var sum = parseInt(jumlah) * parseInt(nominal);
        if (isNaN(sum)) {
            sum = 0;
        }
        if(jenis == 'pengurangan'){
          sum = sum * -1;
        }
        console.log(jenis)
        $('#sum_' + index).val(sum);

        sumTotal();
      }

      function sumTotal(){
        var total = 0;
        $('[id^=sum_]').each(function(){
          var sumValue = parseInt($(this).val());
          total += sumValue;
        });

        $('#total_gaji').val(total);
      }
    </script>
@endsection