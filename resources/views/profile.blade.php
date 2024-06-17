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
                    <form action="{{ route('profile.update') }}" method="post">
                        @csrf
                        <h3 class="text-center font-weight-bold">Data User</h3>
                        <br><br>
                        <input type="hidden" name="sekolah" value="{{ $sekolah }}">
                        <input type="hidden" name="id" value="{{ Auth::user()->id }}">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label>Nama</label>
                                <input type="text" id="name" name="name" class="form-control" placeholder="Nama User" value="{{ $data->name }}" readonly required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label>Email</label>
                                <input type="email" id="email" name="email" class="form-control" placeholder="Email" value="{{ $data->email }}" readonly required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label>NIP</label>
                                <input type="text" id="nip" name="nip" class="form-control" placeholder="No Handphone Guru & Karyawan" value="{{ $data->nip }}" readonly required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label>Role</label>
                                <input type="text" id="role" name="role" class="form-control" placeholder="Role" value="{{ $data->role }}" readonly required>
                                </div>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('dashboard', ['sekolah' => $sekolah]) }}" class="btn btn-secondary" type="button">Batal</a>
                            <button id="btnEdit" type="button" class="btn btn-warning">Edit</button>
                            <button id="btnCancel" type="button" class="btn btn-info" style="display: none">Cancel</button>
                            <button id="btnSubmit" type="submit" class="btn btn-success" style="display: none">Save</button>
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
            $('#btnEdit').click(function(){
                $('#btnCancel').toggle();
                $('#btnSubmit').toggle();
                $(this).toggle();
                $('#name').attr('readonly', false);
                $('#email').attr('readonly', false);
            })
            $('#btnCancel').click(function(){
                $('#btnEdit').toggle();
                $('#btnSubmit').toggle();
                $(this).toggle();
                $('#name').attr('readonly', true);
                $('#email').attr('readonly', true);
            })
        })
    </script>
@endsection