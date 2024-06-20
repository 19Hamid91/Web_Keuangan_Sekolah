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
            <h1 class="m-0">Detail Log Aktivitas</h1>
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
                            <h3 class="text-center font-weight-bold">Detail Log Aktivitas</h3>
                            <br><br>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <input type="text" class="form-control" placeholder="Description" value="{{ $data->description ?? '-' }}" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Subject Type</label>
                                        <input type="text" class="form-control" placeholder="Subject Type" value="{{ $data->subject_type ?? '-' }}" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Subject ID</label>
                                        <input type="text" class="form-control" placeholder="Subject ID" value="{{ $data->subject_id ?? '-' }}" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Causer</label>
                                        <input type="text" class="form-control" placeholder="Causer" value="{{ $data->causer->name ?? '-' }}" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Created At</label>
                                        <input type="text" class="form-control" placeholder="Created At" value="{{ $data->created_at ?? '-' }}" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Old Data</label>
                                        <textarea class="form-control" rows="10" disabled>{{ json_encode($data->properties['old'] ?? [], JSON_PRETTY_PRINT) }}</textarea>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>New Data</label>
                                        <textarea class="form-control" rows="10" disabled>{{ json_encode($data->properties['attributes'] ?? [], JSON_PRETTY_PRINT) }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <a href="{{ route('log.index', ['instansi' => $instansi]) }}" class="btn btn-secondary">Back</a>
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
            $('[id^=hargasatuan_atk], [id^=jumlahbayar_atk]').each(function() {
                  let input = $(this);
                  let value = input.val();
                  let formattedValue = formatNumber(value);

                  input.val(formattedValue);
              });
        })
    </script>
@endsection