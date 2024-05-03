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
            <h1 class="m-0">Detail Data Gaji Pegawai</h1>
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
                  <h3 class="text-center font-weight-bold">Data Gaji Pegawai</h3>
                  <br><br>
                  <div class="row">
                    <div class="col-sm-4">
                      <div class="form-group">
                      <label>Pegawai</label>
                      <select class="form-control select2" data-dropdown-css-class="select2-danger" style="width: 100%;" id="nip" name="nip" disabled>
                        <option value="">Pilih Pegawai</option>
                        @foreach ($pegawai as $item)
                            <option value="{{ $item->nip }}" {{ $data[0]->nip == $item->nip ? 'selected' : '' }}>{{ $item->nama_pegawai }}</option>
                        @endforeach
                      </select>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                      <label>Tanggal</label>
                      <input type="date" id="tanggal" name="tanggal" class="form-control" value="{{ $data[0]->tanggal ?? date('Y-m-d') }}" placeholder="Tanggal" disabled>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                      <label>Status</label>
                      <select class="form-control select2" data-dropdown-css-class="select2-danger" style="width: 100%;" id="status" name="status" disabled>
                        <option value="PENDING" {{ $data[0]->status == 'PENDING' ? 'selected' : '' }}>Pending</option>
                        <option value="SELESAI" {{ $data[0]->status == 'SELESAI' ? 'selected' : '' }}>Selesai</option>
                        <option value="Batal" {{ $data[0]->status == 'BATAL' ? 'selected' : '' }}>Batal</option>
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
                @foreach ($data as $komponen)
                {{-- @foreach ($komponenGaji as $item) --}}
                @php
                    $jenis = $komponen->jenis == 'PENGURANGAN' ? 'pengurangan' : 'penambahan';
                    $minus = $jenis == 'pengurangan' ? -1 : 1;
                @endphp
                <div class="row" id="row_{{ $i }}">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <select class="form-control select2" data-dropdown-css-class="select2-danger" style="width: 100%;" id="kode_komponen_gaji_{{ $i }}" name="kode_komponen_gaji[]" disabled>
                                <option value="{{ $komponen->kode_komponen_gaji }}">{{ $komponen->komponen_gaji->transaksi->nama_transaksi }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <div class="form-group">
                            <input type="number" id="jumlah_{{ $i }}" name="jumlah[]" class="form-control" value="{{ $komponen->jumlah }}" oninput="calculate({{ $i }}, '{{ $jenis }}')" placeholder="Jumlah" disabled>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <input type="text" id="nominal_{{ $i }}" name="nominal[]" class="form-control" value="{{ $komponen->nominal }}" oninput="calculate({{ $i }}, '{{ $jenis }}')" placeholder="Nominal" disabled>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <input type="text" id="jenis_{{ $i }}" name="jenis[]" class="form-control" value="{{ $komponen->komponen_gaji->jenis }}" placeholder="Nominal" readonly>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <input type="text" id="sum_{{ $i }}" name="sum[]" class="form-control" value="{{ intval($komponen->nominal) * intval($komponen->jumlah) * $minus }}" placeholder="Sum" readonly>
                        </div>
                    </div>
                </div>
                @php
                    $i++;
                @endphp
                {{-- @endforeach --}}
                @endforeach
                  <div class="row">
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label for="">Total</label>
                        <input type="text" class="form-control" id="total_gaji" name="total_gaji" value="{{ $data[0]->total_gaji }}" placeholder="Total Gaji" readonly>
                      </div>
                    </div>
                  </div>
                  <div>
                      <a href="{{ route('gaji_pegawai.index') }}" class="btn btn-secondary" type="button">Back</a>
                  </div>
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
        // sumTotal();
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