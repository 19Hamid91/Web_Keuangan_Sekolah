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
            <h1 class="m-0">Edit Data Pembelian ATK</h1>
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
                    <form id="form" action="{{ route('pembelian-atk.update', ['id' => $data->id, 'instansi' => $instansi]) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <h3 class="text-center font-weight-bold">Data Pembelian ATK</h3>
                        <br><br>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label>Supplier</label>
                                <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" name="supplier_id" required>
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
                                <input type="date" name="tgl_beliatk" class="form-control" placeholder="Tanggal Beli ATK" value="{{ $data->tgl_beliatk }}" required>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div>
                            <table style="min-width: 100%">
                                <thead>
                                    <tr>
                                        <th>ATK</th>
                                        <th>Satuan</th>
                                        <th>Jumlah</th>
                                        <th>Harga Satuan</th>
                                        <th>Harga Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="body_komponen">
                                    @if(count($data->komponen) == 0)
                                    <tr id="row_0" class="mt-1">
                                        <td>
                                            <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" name="atk_id[]" id="atk_id-0" required>
                                                <option value="">Pilih ATK</option>
                                                @foreach ($atks as $item)
                                                    <option value="{{ $item->id }}">{{ $item->nama_atk }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" name="satuan[]" id="satuan-0" required>
                                                <option value="pcs">pcs</option>
                                                <option value="rem">rem</option>
                                                <option value="box">box</option>
                                                <option value="lusin">lusin</option>
                                                <option value="kodi">kodi</option>
                                                <option value="pack">pack</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" id="jumlah_atk-0" name="jumlah_atk[]" class="form-control" placeholder="Jumlah ATK" value="{{ old('jumlah_atk') }}" required oninput="calculate(0)">
                                        </td>
                                        <td>
                                            <input type="text" id="hargasatuan_atk-0" name="hargasatuan_atk[]" class="form-control text-right" placeholder="Harga Satuan" value="{{ old('hargasatuan_atk') }}" required oninput="calculate(0)">
                                        </td>
                                            <input type="hidden" id="diskon-0" name="diskon[]" class="form-control" placeholder="Diskon" value="0" required oninput="calculate(0)">
                                            <input type="hidden" id="ppn-0" name="ppn[]" class="form-control" placeholder="PPN" value="0" required oninput="calculate(0)">
                                        <td>
                                            <input type="text" id="harga_total-0" name="harga_total[]" class="form-control text-right" placeholder="Harga Total" value="{{ old('harga_total') }}" required>
                                        </td>
                                        <td>
                                            <button class="btn btn-success" id="addRow">+</button>
                                        </td>
                                    </tr>
                                    @else
                                        @php
                                            $i = 0;
                                        @endphp
                                        @foreach ($data->komponen as $index => $komponen)
                                        <tr id="row_{{ $i }}" class="mt-1">
                                            <td>
                                                <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" name="atk_id[]" id="atk_id-{{ $i }}" required>
                                                    <option value="">Pilih ATK</option>
                                                    @foreach ($atks as $item)
                                                        <option value="{{ $item->id }}" {{ $komponen->atk_id == $item->id ? 'selected' : '' }}>{{ $item->nama_atk }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" name="satuan[]" id="satuan-{{ $i }}" required>
                                                    <option value="pcs" {{ $komponen->satuan == 'pcs' ? 'selected' : '' }}>pcs</option>
                                                    <option value="rem" {{ $komponen->satuan == 'rem' ? 'selected' : '' }}>rem</option>
                                                    <option value="box" {{ $komponen->satuan == 'box' ? 'selected' : '' }}>box</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" id="jumlah_atk-{{ $i }}" name="jumlah_atk[]" class="form-control" placeholder="Jumlah ATK" value="{{ $komponen->jumlah }}" required oninput="calculate({{ $i }})">
                                            </td>
                                            <td>
                                                <input type="text" id="hargasatuan_atk-{{ $i }}" name="hargasatuan_atk[]" class="form-control text-right" placeholder="Harga Satuan" value="{{ $komponen->harga_satuan }}" required oninput="calculate({{ $i }})">
                                            </td>
                                                <input type="hidden" id="diskon-{{ $i }}" name="diskon[]" class="form-control" placeholder="Diskon" value="0" required oninput="calculate({{ $i }})">
                                                <input type="hidden" id="ppn-{{ $i }}" name="ppn[]" class="form-control" placeholder="PPN" value="0" required oninput="calculate({{ $i }})">
                                            <td>
                                                <input type="text" id="harga_total-{{ $i }}" name="harga_total[]" class="form-control text-right" placeholder="Harga Total" value="{{ $komponen->harga_total }}" required>
                                            </td>
                                            <td>
                                                @if($index == 0)
                                                <button class="btn btn-success" id="addRow">+</button>
                                                @else
                                                <button type="button" class="btn btn-danger removeRow">-</button>
                                                @endif
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
                                        <td colspan="4" class="text-right pr-3">Total</td>
                                        <td><input type="text" id="total" name="total" value="{{ $data->total }}" class="form-control text-right" required readonly></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <label>Bukti <a href="javascript:void(0)" id="clearFile" class="text-danger" onclick="clearFile()" title="Clear Image">clear</a>
                                </label>
                                  <input type="file" id="bukti" class="form-control" name="file" accept="image/*">
                                <p class="text-danger">max 2mb</p>
                                <img id="preview" src="{{ $data->file ? '/storage/' . $data->file : '' }}" alt="Preview" style="max-width: 40%;"/>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('pembelian-atk.index', ['instansi' => $instansi]) }}" class="btn btn-secondary" type="button">Batal</a>
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
        $(document).ready(function(){
            if ($('#preview').attr('src') === '') {
                $('#preview').attr('src', defaultImg);
            }
            var rowCount = {{ count($data->komponen) }};
            $('#addRow').on('click', function(e){
                e.preventDefault();
                if($('[id^=row_]').length <= 15){
                    var newRow = `
                        <tr id="row_${rowCount}">
                            <td>
                                <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" name="atk_id[]" id="atk_id-${rowCount}" required>
                                    <option value="">Pilih ATK</option>
                                    @foreach ($atks as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama_atk }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" name="satuan[]" id="satuan-${rowCount}" required>
                                    <option value="pcs">pcs</option>
                                    <option value="rem">rem</option>
                                    <option value="box">box</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" id="jumlah_atk-${rowCount}" name="jumlah_atk[]" class="form-control" placeholder="Jumlah ATK" value="" required oninput="calculate(${rowCount})">
                            </td>
                            <td>
                                <input type="text" id="hargasatuan_atk-${rowCount}" name="hargasatuan_atk[]" class="form-control text-right" placeholder="Harga Satuan" value="" required oninput="calculate(${rowCount})">
                            </td>
                                <input type="hidden" id="diskon-${rowCount}" name="diskon[]" class="form-control" placeholder="Diskon" value="0" required oninput="calculate(${rowCount})">
                                <input type="hidden" id="ppn-${rowCount}" name="ppn[]" class="form-control" placeholder="PPN" value="0" required oninput="calculate(${rowCount})">
                            <td>
                                <input type="text" id="harga_total-${rowCount}" name="harga_total[]" class="form-control text-right" placeholder="Harga Total" value="" required>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger removeRow">-</button>
                            </td>
                        </tr>
                    `;
                    $('#body_komponen').append(newRow); 
                    rowCount++;
        
                    $('.select2').select2();
                }
            });

            $(document).on('click', '.removeRow', function() {
                $(this).closest('tr').remove();
            });
            $('[id^=jumlah_atk], [id^=hargasatuan_atk], [id^=harga_total], #total').each(function() {
                let input = $(this);
                let value = input.val();
                let formattedValue = formatNumber(value);

                input.val(formattedValue);
            });
        })
        $(document).on('input', '[id^=jumlah_atk], [id^=hargasatuan_atk], [id^=harga_total]', function() {
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
        $('#form').on('submit', function(e) {
            let inputs = $('#form').find('[id^=jumlah_atk], [id^=hargasatuan_atk], [id^=harga_total], #total');
            inputs.each(function() {
                let input = $(this);
                let value = input.val();
                let cleanedValue = cleanNumber(value);

                input.val(cleanedValue);
            });

            return true;
        });
        $('#bukti').on('change', function() {
          const file = $(this)[0].files[0];
          if (file.size > 2 * 1024 * 1024) { 
              toastr.warning('Ukuran file tidak boleh lebih dari 2mb', {
                  closeButton: true,
                  tapToDismiss: false,
                  rtl: false,
                  progressBar: true
              });
              $(this).val(''); 
              return;
          }
          if (file) {
              const reader = new FileReader();
              reader.onload = function(e) {
                  $('#preview').attr('src', e.target.result);
              }
              reader.readAsDataURL(file);
          }
        });

        function clearFile(){
            $('#bukti').val('');
            $('#preview').attr('src', defaultImg);
        };
        function calculate(id){
            validatePersen($('#diskon-' + id))
            validatePersen($('#ppn-' + id))
            var jumlah = cleanNumber($('#jumlah_atk-' + id).val())
            var harga_satuan = cleanNumber($('#hargasatuan_atk-' + id).val())
            var diskon = $('#diskon-' + id).val()
            var ppn = $('#ppn-' + id).val()

            var total = jumlah * harga_satuan;
            var total_after_diskon = total * ((100 - diskon) / 100);
            var total_ppn = total_after_diskon * ppn / 100;
            var final_total = total_after_diskon + total_ppn;
            $('#harga_total-' + id).val(formatNumber(final_total))

            var all_final_total = $('input[name="harga_total[]"]');
                var total_keseluruhan = 0;
                all_final_total.each(function() {
                    total_keseluruhan += parseInt(cleanNumber($(this).val())) || 0;
                });
            $('#total').val(formatNumber(total_keseluruhan))
        }
    </script>
@endsection