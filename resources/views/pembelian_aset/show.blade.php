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
            <h1 class="m-0">Detail Data Pembelian Aset Tetap</h1>
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
                    <h3 class="text-center font-weight-bold">Data Pembelian Aset Tetap</h3>
                    <br><br>
                    <div class="row">
                      <div class="col-sm-6">
                          <div class="form-group">
                          <label>Supplier</label>
                          <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" name="supplier_id" disabled>
                              <option value="">Pilih Supplier</option>
                              @foreach ($suppliers as $item)
                                  <option value="{{ $item->id }}" {{ $data->supplier_id == $item->id ? 'selected' : '' }}>{{ $item->nama_supplier }}</option>
                              @endforeach
                          </select>
                          </div>
                      </div>
                      <div class="col-sm-6">
                          <div class="form-group">
                          <label>Tanggal Beli</label>
                          <input type="date" name="tgl_beliaset" class="form-control" placeholder="Tanggal Beli Aset" value="{{ $data->tgl_beliaset ?? date('Y-m-d') }}" disabled>
                          </div>
                      </div>
                  </div>
                  <hr>
                  <div>
                      <table style="min-width: 100%">
                          <thead>
                              <tr>
                                  <th>Aset Tetap</th>
                                  <th>Satuan</th>
                                  <th>Jumlah</th>
                                  <th>Harga Satuan</th>
                                  <th>Diskon</th>
                                  <th>PPN</th>
                                  <th>Harga Total</th>
                              </tr>
                          </thead>
                          <tbody id="body_komponen">
                              @if(count($data->komponen) == 0)
                              <tr id="row_0" class="mt-1">
                                  <td>
                                      <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" name="aset_id[]" id="aset_id-0" disabled>
                                          <option value="">Pilih Aset Tetap</option>
                                          @foreach ($asets as $item)
                                              <option value="{{ $item->id }}">{{ $item->nama_aset }}</option>
                                          @endforeach
                                      </select>
                                  </td>
                                  <td>
                                      <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" name="satuan[]" id="satuan-0" disabled>
                                          <option value="unit">Unit</option>
                                      </select>
                                  </td>
                                  <td>
                                      <input type="text" id="jumlah_aset-0" name="jumlah_aset[]" class="form-control" placeholder="Jumlah Aset" value="{{ old('jumlah_aset') }}" disabled oninput="calculate(0)">
                                  </td>
                                  <td>
                                      <input type="text" id="hargasatuan_aset-0" name="hargasatuan_aset[]" class="form-control" placeholder="Harga Satuan" value="{{ old('hargasatuan_aset') }}" disabled oninput="calculate(0)">
                                  </td>
                                  <td>
                                      <input type="text" id="diskon-0" name="diskon[]" class="form-control" placeholder="Diskon" value="{{ old('diskon') }}" disabled oninput="calculate(0)">
                                  </td>
                                  <td>
                                      <input type="text" id="ppn-0" name="ppn[]" class="form-control" placeholder="PPN" value="{{ old('ppn') ?? 11 }}" disabled oninput="calculate(0)">
                                  </td>
                                  <td>
                                      <input type="text" id="harga_total-0" name="harga_total[]" class="form-control" placeholder="Harga Total" value="{{ old('harga_total') }}" disabled>
                                  </td>
                              </tr>
                              @else
                                  @php
                                      $i = 0;
                                  @endphp
                                  @foreach ($data->komponen as $index => $komponen)
                                  <tr id="row_{{ $i }}" class="mt-1">
                                      <td>
                                          <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" name="aset_id[]" id="aset_id-{{ $i }}" disabled>
                                              <option value="">Pilih Aset Tetap</option>
                                              @foreach ($asets as $item)
                                                  <option value="{{ $item->id }}" {{ $komponen->aset_id == $item->id ? 'selected' : '' }}>{{ $item->nama_aset }}</option>
                                              @endforeach
                                          </select>
                                      </td>
                                      <td>
                                          <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" name="satuan[]" id="satuan-{{ $i }}" disabled>
                                              <option value="unit" {{ $komponen->unit == 'unit' ? 'selected' : '' }}>Unit</option>
                                          </select>
                                      </td>
                                      <td>
                                          <input type="text" id="jumlah_aset-{{ $i }}" name="jumlah_aset[]" class="form-control" placeholder="Jumlah Aset" value="{{ $komponen->jumlah }}" disabled oninput="calculate({{ $i }})">
                                      </td>
                                      <td>
                                          <input type="text" id="hargasatuan_aset-{{ $i }}" name="hargasatuan_aset[]" class="form-control" placeholder="Harga Satuan" value="{{ $komponen->harga_satuan }}" disabled oninput="calculate({{ $i }})">
                                      </td>
                                      <td>
                                          <input type="text" id="diskon-{{ $i }}" name="diskon[]" class="form-control" placeholder="Diskon" value="{{ $komponen->diskon }}" disabled oninput="calculate({{ $i }})">
                                      </td>
                                      <td>
                                          <input type="text" id="ppn-{{ $i }}" name="ppn[]" class="form-control" placeholder="PPN" value="{{ $komponen->ppn ?? 11 }}" disabled oninput="calculate({{ $i }})">
                                      </td>
                                      <td>
                                          <input type="text" id="harga_total-{{ $i }}" name="harga_total[]" class="form-control" placeholder="Harga Total" value="{{ $komponen->harga_total }}" disabled>
                                      </td>
                                  </tr>
                                  @php
                                      $i++;
                                  @endphp
                                  @endforeach
                              @endif
                          </tbody>
                          <tfoot>
                              <tr>
                                  <td colspan="6" class="text-right pr-3">Total</td>
                                  <td><input type="text" id="total" name="total" value="{{ $data->total }}" class="form-control" disabled readonly></td>
                              </tr>
                          </tfoot>
                      </table>
                  </div>
                  <hr>
                  <div class="row mb-3">
                      <div class="col-sm-6">
                          <label>Bukti <a href="javascript:void(0)" id="clearFile" class="text-danger" onclick="clearFile()" title="Clear Image">clear</a>
                          </label>
                            <input type="file" id="bukti" class="form-control" name="file" accept="image/*" disabled>
                          <p class="text-danger">max 2mb</p>
                          <img id="preview" src="{{ $data->file ? '/storage/' . $data->file : '' }}" alt="Preview" style="max-width: 40%;"/>
                      </div>
                  </div>
                  <div>
                      <a href="{{ route('pembelian-aset.index', ['instansi' => $instansi]) }}" class="btn btn-secondary" type="button">Batal</a>
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
      $(document).ready(function(){
          if ($('#preview').attr('src') === '') {
              $('#preview').attr('src', defaultImg);
          }
          $('[id^=jumlah_aset], [id^=hargasatuan_aset], [id^=harga_total], #total').each(function() {
              let input = $(this);
              let value = input.val();
              let formattedValue = formatNumber(value);

              input.val(formattedValue);
          });
        })
    </script>
@endsection