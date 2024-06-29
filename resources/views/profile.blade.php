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
                    <form action="{{ route('profile.update', ['id' => $data->id, 'instansi' => $instansi]) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <h3 class="text-center font-weight-bold">Data User</h3>
                        <br><br>
                        <input type="hidden" name="instansi" value="{{ $instansi }}">
                        <input type="hidden" name="id" value="{{ Auth::user()->id }}">
                        <div class="row d-flex justify-content-center align-items-center mb-4" style="height: 200px;">
                          <div class="col-sm-4 text-center">
                              <div class="form-group">
                                  <div>
                                      <img id="current-photo" src="{{ $data->foto ? 'data:image/png;base64,'.$data->foto : asset('/blank-profile.png') }}" alt="Foto Profil"
                                           style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%; cursor: pointer;border:1px solid black;" title="Edit Profile Picture">
                                  </div>
                                  <input type="file" id="photo" name="photo" style="display: none" accept="image/*" onchange="previewPhoto(event)">
                              </div>
                          </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                <label>Nama</label>
                                <input type="text" id="name" name="name" class="form-control" placeholder="Nama User" value="{{ $data->name }}" readonly required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                <label>Email</label>
                                <input type="email" id="email" name="email" class="form-control" placeholder="Email" value="{{ $data->email }}" readonly required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                              <div class="form-group">
                              <label>Role</label>
                              <input type="text" id="role" name="role" class="form-control" placeholder="Role" value="{{ $data->role }}" readonly required>
                              </div>
                            </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-4">
                            <div class="form-group">
                            <label>Password Lama</label>
                            <input type="password" id="old_password" name="old_password" class="form-control" placeholder="Password Lama" value="" readonly>
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                            <label>Password Baru</label>
                            <input type="password" id="new_password" name="new_password" class="form-control" placeholder="Password Baru" value="" readonly>
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                            <label>Konfirmasi Password Baru</label>
                            <input type="password" id="confirm_new_password" name="confirm_new_password" class="form-control" placeholder="Konfirmasi Password Baru" value="" readonly oninput="checkPassword(this)">
                            <p class="text-danger" style="display: none" id="passMatch">Password tidak sesuai</p>
                            </div>
                          </div>
                        </div>
                        <div>
                            <a href="{{ route('dashboard', ['instansi' => $instansi]) }}" class="btn btn-secondary" type="button">Batal</a>
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
                $('#old_password').attr('readonly', false);
                $('#new_password').attr('readonly', false);
                $('#confirm_new_password').attr('readonly', false);
            })
            $('#btnCancel').click(function(){
                $('#btnEdit').toggle();
                $('#btnSubmit').toggle();
                $(this).toggle();
                $('#name').attr('readonly', true);
                $('#email').attr('readonly', true);
                $('#old_password').attr('readonly', true);
                $('#new_password').attr('readonly', true);
                $('#confirm_new_password').attr('readonly', true);
            })
        })
        $(document).ready(function() {
            $('#current-photo').on('click', function() {
                $('#photo').click();
            });

            $('#photo').on('change', function(event) {
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
                      $('#current-photo').attr('src', e.target.result);
                  }
                  reader.readAsDataURL(file);
              }
            });
        });
        function checkPassword(element){
          var new_password = $('#new_password').val();
          var confirm_new_password = $(element).val();
          if(confirm_new_password == new_password){
            $('#btnSubmit').attr('disabled', false)
            $('#passMatch').css('display', 'none')
          } else {
            $('#btnSubmit').attr('disabled', true)
            $('#passMatch').css('display', 'block')
          }
        }
    </script>
@endsection