<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Keuangan PAPB</title>
  <link rel="icon" href="{{ asset('logo.png') }}" type="image/x-icon">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="../plugins/toastr/toastr.min.css">
  <style>
    .title-container {
      background-color: #007bff;
      color: white;
      padding: 20px;
      border-radius: 0 0 10px 10px;
      margin-bottom: 20px;
      width: 100vw;
      position: fixed;
      top: 0;
      left: 0;
      z-index: 1000;
      text-align: center;
    }
    .title-container h1 {
      font-size: 2.5rem;
      margin: 0;
    }
    .address {
      font-size: 1.25rem;
      margin: 0;
    }

    @media (max-width: 576px) {
      .title-container {
        padding: 10px;
      }
      .title-container h1 {
        font-size: 1.5rem;
      }
      .address {
        font-size: 1rem;
      }
    }

    .login-box {
      margin-top: 140px;
      max-width: 400px;
      width: 100%;
      margin-left: auto;
      margin-right: auto;
    }

    body {
      background-color: #f4f6f9;
    }
  </style>
</head>
<body class="hold-transition login-page">
<div class="container text-center">
  <div class="title-container">
    <h1>SISTEM INFORMASI AKUNTANSI PAPB</h1>
    <p class="address">Jl. Panda Bar. No.44, Palebon, <br>Kec. Pedurungan, Kota Semarang, Jawa Tengah 50199</p>
  </div>
</div>
<div class="login-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <img src="{{ asset('logo-text.png') }}" alt="Logo PAPB" style="max-width:100%;width: auto; height: 20%;">
    </div>
    <div class="card-body">
      <p class="login-box-msg">Sign in to start your session</p>
      <form action="{{ route('login') }}" method="post">
        @csrf
        <div class="input-group mb-3">
          <input type="text" name="name" class="form-control" placeholder="Username" value="{{ old('name') }}" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- Toastr -->
<script src="../plugins/toastr/toastr.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    let sessionData = @json(session()->all());
    @if(session('fail'))
      toastr.error(sessionData.fail, {
        closeButton: true,
        tapToDismiss: false,
        rtl: false,
        progressBar: true
      });
    @endif
    @if(session('success'))
      toastr.success(sessionData.success, {
        closeButton: true,
        tapToDismiss: false,
        rtl: false,
        progressBar: true
      });
    @endif
    @if(session('warning'))
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