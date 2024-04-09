<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Registration Page (v2)</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="../../index2.html" class="h1">Sistem PAPB</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Register a new account</p>

      <form action="{{ route('register') }}" method="post">
        @csrf
        <div class="input-group mb-3">
          <input type="text" name="name" class="form-control" placeholder="Full name" value="{{ old('name') }}" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" name="nip" class="form-control" placeholder="NIP" value="{{ old('nip') }}" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-id-badge"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" id="repassword" class="form-control" placeholder="Retype password" required>
          <div class="input-group-append">
              <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
            </div>
        </div>
        <span id="passNotMatched" style="display: none" class="text-danger">Password tidak sesuai</span>
        <div class="row">
          <!-- /.col -->
          <div class="col-12">
            <button id="submitBtn" type="submit" class="btn btn-primary btn-block" disabled>Register</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <a href="{{ route('formLogin') }}" class="text-center">I already have an account</a>

    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $('#repassword, #password').on('input', function(){
        var repassword = $('#repassword').val();
        var password = $('#password').val();

        if(repassword === password && password){
            $('#submitBtn').attr('disabled', false);
            $('#passNotMatched').css('display', 'none')
        } else {
            $('#submitBtn').attr('disabled', true);
            if(repassword){
                $('#passNotMatched').css('display', 'block')
            } else {
                $('#passNotMatched').css('display', 'none')
            }
        }
    })
</script>
<script type="text/javascript">
  $( document ).ready(function() {
    let sessionData = @json(session()->all());
    @if(session('fail'))
      toastr.error(sessionData.fail, {
        closeButton: true,
        tapToDismiss: false,
        rtl: false,
        progressBar: true
      });
    @endif
    @if ( session('success'))
      toastr.success(sessionData.success, {
        closeButton: true,
        tapToDismiss: false,
        rtl: false,
        progressBar: true
      });
    @endif
    @if ( session('warning'))
      toastr.warning(sessionData.warning, {
        closeButton: true,
        tapToDismiss: false,
        rtl: false,
        progressBar: true
      });
        @endif
  });
</script>
</body>
</html>
