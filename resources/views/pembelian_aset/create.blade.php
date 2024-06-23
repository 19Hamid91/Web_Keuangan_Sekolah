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
            <h1 class="m-0">Tambah Pembelian Aset Tetap</h1>
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
                    <form id="addForm" action="{{ route('pembelian-aset.store', ['instansi' => $instansi]) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <h3 class="text-center font-weight-bold">Data Pembelian Aset Tetap</h3>
                        <br><br>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                <label>Supplier</label>
                                <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" name="supplier_id" required>
                                    <option value="">Pilih Supplier</option>
                                    @foreach ($suppliers as $item)
                                        <option value="{{ $item->id }}" {{ old('supplier_id') == $item->id ? 'selected' : '' }}>{{ $item->nama_supplier }}</option>
                                    @endforeach
                                </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                <label>Aset Tetap</label>
                                <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" name="aset_id" required>
                                    <option value="">Pilih Aset Tetap</option>
                                    @foreach ($asets as $item)
                                        <option value="{{ $item->id }}" {{ old('aset_id') == $item->id ? 'selected' : '' }}>{{ $item->nama_aset }}</option>
                                    @endforeach
                                </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                <label>Tanggal Beli</label>
                                <input type="date" name="tgl_beliaset" class="form-control" placeholder="Tanggal Beli Aset" value="{{ old('tgl_beliaset') ?? date('Y-m-d') }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label>Satuan</label>
                                <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" name="satuan" required>
                                    <option value="pcs" {{ old('satuan') == 'pcs' ? 'selected' : '' }}>pcs</option>
                                    <option value="rem" {{ old('satuan') == 'rem' ? 'selected' : '' }}>rem</option>
                                    <option value="box" {{ old('satuan') == 'box' ? 'selected' : '' }}>box</option>
                                </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label>Jumlah</label>
                                <input type="number" id="jumlah_aset" name="jumlah_aset" class="form-control" placeholder="Jumlah Aset" value="{{ old('jumlah_aset') }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label>Harga Satuan</label>
                                <input type="text" id="hargasatuan_aset" name="hargasatuan_aset" class="form-control" placeholder="Jumlah Aset" value="{{ old('hargasatuan_aset') }}" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label>Jumlah Bayar</label>
                                <input type="text" id="jumlahbayar_aset" name="jumlahbayar_aset" class="form-control" placeholder="Jumlah Bayar" value="{{ old('jumlahbayar_aset') }}" readonly required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <label>Bukti <a href="javascript:void(0)" id="clearFile" class="text-danger" onclick="clearFile()" title="Clear Image">clear</a>
                                </label>
                                  <input type="file" id="bukti" class="form-control" name="file" accept="image/*">
                                <p class="text-danger">max 2mb</p>
                                <img id="preview" src="" alt="Preview" style="max-width: 40%;"/>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label>Akun</label>
                                <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" id="akun_id" name="akun_id" required>
                                  <option value="">Pilih Akun</option>
                                    @foreach ($akun as $item)
                                      <option value="{{ $item->id }}">{{ $item->kode }} {{  $item->nama }}</option>
                                    @endforeach
                                  </select>
                                </div>
                            </div>
                          </div>
                        <div>
                            <a href="{{ route('pembelian-aset.index', ['instansi' => $instansi]) }}" class="btn btn-secondary" type="button">Batal</a>
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
      })
        $(document).on('input', '#jumlah_aset, #hargasatuan_aset', function(){
            var jumlah = cleanNumber($('#jumlah_aset').val());
            var harga = cleanNumber($('#hargasatuan_aset').val());
            $('#jumlahbayar_aset').val(formatNumber(jumlah * harga));
        });
        $(document).on('input', '[id^=hargasatuan_aset]', function() {
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
        $('#addForm').on('submit', function(e) {
            let inputs = $('#addForm').find('[id^=hargasatuan_aset], #jumlahbayar_aset');
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
    </script>
@endsection