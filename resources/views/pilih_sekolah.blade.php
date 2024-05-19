<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Log in (v2)</title>

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
</head>
<body class="hold-transition login-page">
<div class="card card-outline card-primary w-50 mt-5">
    <div class="card-header text-center col">
        <h1>Pilih Sekolah</h1>
        <span>Pilih salah satu untuk melanjutkan</span>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-lg-4">
            <a href="{{ route('dashboard', ['sekolah' => 'yayasan']) }}">
                <div class="small-box bg-success text-center p-3">
                    <h3>Yayasan</h3>
                </div>
            </a>
        </div>
        <div class="col-lg-4">
            <a href="{{ route('dashboard', ['sekolah' => 'tk']) }}">
                <div class="small-box bg-warning text-center p-3">
                    <h3>TK</h3>
                </div>
            </a>
        </div>
        <div class="col-lg-4">
            <a href="{{ route('dashboard', ['sekolah' => 'smp']) }}">
                <div class="small-box bg-primary text-center p-3">
                    <h3>SMP</h3>
                </div>
            </a>
        </div>
      </div>
    </div>
    <!-- /.card-body -->
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
