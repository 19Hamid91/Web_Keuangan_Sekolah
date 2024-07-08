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
            <h1 class="m-0">Edit Data Pembayaran Siswa</h1>
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
                  <form id="form" action="{{ route('pembayaran_siswa.update', ['instansi' => $instansi, 'kelas' => $data->first()->invoice, 'pembayaran_siswa' => $data->first()->id]) }}" method="post" enctype="multipart/form-data">
                      @csrf
                      @method('patch')
                      <h3 class="text-center font-weight-bold">Data Pembayaran Siswa</h3>
                      <br><br>
              
                      <!-- Siswa, Tanggal, Bukti -->
                      <div class="row">
                          <div class="col-sm-4">
                              <div class="form-group">
                                  <label>Siswa</label>
                                  <select class="form-control select2" style="width: 100%" data-dropdown-css-class="select2-danger" id="siswa_id" name="siswa_id" required>
                                      <option value="">Pilih Siswa</option>
                                      @foreach ($siswa as $siswaItem)
                                          <option value="{{ $siswaItem->id }}" {{ $data->first()->siswa_id == $siswaItem->id ? 'selected' : '' }} data-instansi="{{ $siswaItem->instansi_id }}" data-kelas="{{ $siswaItem->kelas_id }}">({{ $siswaItem->nis }}) {{ $siswaItem->nama_siswa }}</option>
                                      @endforeach
                                  </select>
                              </div>
                          </div>
                          <div class="col-sm-4">
                              <div class="form-group">
                                  <label>Tanggal</label>
                                  <div class="input-group mb-3">
                                      <input type="date" name="tanggal" class="form-control" placeholder="Tanggal" value="{{ $data->first()->tanggal ?? date('Y-m-d') }}" required>
                                  </div>
                              </div>
                          </div>
                          <div class="col-sm-4">
                              <div class="form-group">
                                  <label>Bukti</label>
                                  <input type="file" id="bukti" class="form-control" name="file" accept="image/*">
                                  <p class="text-danger">max 2mb</p>
                                  <img id="preview" src="{{ $data->first()->file ? '/storage/' . $data->first()->file : '' }}" alt="Preview" style="max-width: 40%;" />
                              </div>
                          </div>
                      </div>
              
                      <!-- Tagihan -->
                      <table class="table table-bordered">
                          <thead>
                              <tr>
                                  <th>Tagihan</th>
                                  <th>Total</th>
                                  <th>Sisa</th>
                                  <th>Tipe Pembayaran</th>
                              </tr>
                          </thead>
                          <tbody>
                            @php
                                $i = 0;
                            @endphp
                            @foreach ($data as $index => $item)
                            <tr>
                                <td>
                                    <select id="tagihan_siswa_id_{{ $i }}" name="tagihan_siswa_id[]" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%" disabled>
                                        <option value="">Pilih Tagihan</option>
                                        @foreach ($tagihan_siswa as $tagihan)
                                            <option value="{{ $tagihan->id }}" {{ $item->tagihan_siswa_id == $tagihan->id ? 'selected' : '' }} data-nominal="{{ $tagihan->nominal }}">{{ $tagihan->jenis_tagihan }} - {{ formatRupiah($tagihan->nominal) }}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="tagihan_siswa_id[]" value="{{ $item->tagihan_siswa_id }}">
                                </td>
                                <td>
                                    <input type="text" id="total_{{ $i }}" name="total[]" class="form-control" placeholder="Total Bayar" value="{{ $item->total ?? 0 }}" required>
                                </td>
                                <td>
                                    <input type="text" id="sisa_{{ $i }}" name="sisa[]" class="form-control" placeholder="Sisa Pembayaran" value="{{ $item->sisa ?? 0 }}" required readonly>
                                </td>
                                <td>
                                    <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" id="tipe_pembayaran_{{ $i }}" name="tipe_pembayaran[]" required>
                                        <option value="Cash" {{ $item->tipe_pembayaran == 'Cash' ? 'selected' : '' }}>Cash</option>
                                        <option value="Transfer" {{ $item->tipe_pembayaran == 'Transfer' ? 'selected' : '' }}>Transfer</option>
                                    </select>
                                </td>
                            </tr>
                            @php
                                $i++;
                            @endphp
                            @endforeach
                          </tbody>
                      </table>
              
                      <br>
                      <div>
                          <a href="{{ route('pembayaran_siswa.index', ['instansi' => $instansi, 'kelas' => $kelas]) }}" class="btn btn-secondary" type="button">Batal</a>
                          <button type="submit" class="btn btn-success">Update</button>
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
          $('[id^=total], [id^=sisa]').each(function() {
                let input = $(this);
                let value = input.val();
                let formattedValue = formatNumber(value);

                input.val(formattedValue);
            });
        })
      $(document).on('input', '[id^=total], [id^=sisa]', function() {
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
            let inputs = $('#form').find('[id^=total], [id^=sisa]');
            inputs.each(function() {
                let input = $(this);
                let value = input.val();
                let cleanedValue = cleanNumber(value);

                input.val(cleanedValue);
            });

            return true;
        });
      $('#tagihan_siswa_id').on('change', function(){
        let nominal = $(this).find(':selected').data('nominal');
        $('#total').val(formatNumber(nominal));
      });
      $('#total').on('input', function(){
        let bayar = cleanNumber($(this).val());
        let nominal = $('#tagihan_siswa_id').find(':selected').data('nominal');
        $('#sisa').val(formatNumber((parseInt(nominal) - parseInt(bayar))));
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