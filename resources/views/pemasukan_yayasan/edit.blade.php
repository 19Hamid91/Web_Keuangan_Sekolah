@extends('layout')

@section('css')
    <!-- Tambahkan CSS tambahan di sini jika diperlukan -->
@endsection

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Data Pemasukan Yayasan</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form id="editForm" action="{{ route('pemasukan_yayasan.update', ['instansi' => $instansi, 'pemasukan_yayasan' => $data->id]) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('patch')
                                <h3 class="text-center font-weight-bold">Edit Data Pemasukan Yayasan</h3>
                                <br><br>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Jenis</label>
                                            <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" name="jenis" required>
                                                <option value="">Pilih Jenis</option>
                                                <option value="JPI" {{ $data->jenis == 'JPI' ? 'selected' : '' }}>JPI</option>
                                                <option value="SPP" {{ $data->jenis == 'SPP' ? 'selected' : '' }}>SPP</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Tanggal</label>
                                            <input type="date" name="tanggal" class="form-control" value="{{ $data->tanggal }}" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Total</label>
                                            <input type="text" name="total" id="total" class="form-control" placeholder="Total" value="{{ $data->total }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                  <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Keterangan</label>
                                        <textarea name="keterangan" class="form-control" placeholder="Keterangan">{{ $data->keterangan }}</textarea>
                                    </div>
                                </div>
                                    <div class="col-sm-6">
                                        <label>Bukti <a href="javascript:void(0)" id="clearFile" class="text-danger" onclick="clearFile()" title="Clear Image">clear</a>
                                        </label>
                                        <input type="file" id="bukti" class="form-control" name="file" accept="image/*">
                                        <p class="text-danger">max 2mb</p>
                                        @if ($data->bukti)
                                            <img id="preview" src="{{ asset('storage/' . $data->bukti) }}" alt="Preview" style="max-width: 40%;"/>
                                        @else
                                            <img id="preview" src="" alt="Preview" style="max-width: 40%;"/>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <a href="{{ route('pemasukan_yayasan.index', ['instansi' => $instansi]) }}" class="btn btn-secondary">Batal</a>
                                        <button type="submit" class="btn btn-success">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function () {
        if ($('#preview').attr('src') === '') {
            $('#preview').attr('src', defaultImg);
        }
    });
    $(document).on('input', '[id^=total]', function() {
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
    $('#editForm').on('submit', function(e) {
        let inputs = $('#editForm').find('[id^=total]');
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