<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Web PAPB</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/../plugins/fontawesome-free/css/all.min.css">
  <!-- Ekko Lightbox -->
  <link rel="stylesheet" href="/../plugins/ekko-lightbox/ekko-lightbox.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/../dist/css/adminlte.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="/../plugins/toastr/toastr.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="/../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="/../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="/../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="/../plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="/../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <!-- Profile and Logout Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="fas fa-sign-out-alt"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
          <span class="dropdown-item dropdown-header">Profile</span>
          <div class="dropdown-divider"></div>
          <a href="{{ route('logout') }}" class="dropdown-item dropdown-header bg-danger">Logout</a>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/../index3.html" class="brand-link">
      <img src="/../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Web PAPB</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="/../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <span class="d-block text-white">{{ Auth::user()->name }}</span>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->is(['dashboard*', 'users*']) ? 'active' : '' }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          @if (in_array(Auth::user()->role, ['SUPERADMIN']))
          <li class="nav-item {{ request()->is(['sekolah*', 'kelas*', 'tahun_ajaran*', 'akun*', 'user*', 'transaksi*', 'yayasan*']) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is(['sekolah*', 'kelas*', 'tahun_ajaran*', 'akun*', 'user*', 'transaksi*', 'yayasan*']) ? 'active' : '' }}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Master
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('yayasan.index') }}" class="nav-link {{ request()->is(['yayasan*']) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Yayasan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('sekolah.index') }}" class="nav-link {{ request()->is(['sekolah*']) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sekolah</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('kelas.index') }}" class="nav-link {{ request()->is(['kelas*']) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kelas</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('tahun_ajaran.index') }}" class="nav-link {{ request()->is(['tahun_ajaran*']) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Tahun Ajaran</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('akun.index') }}" class="nav-link {{ request()->is(['akun*']) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Akun</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('transaksi.index') }}" class="nav-link {{ request()->is(['transaksi*']) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Transaksi</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('user.index') }}" class="nav-link {{ request()->is(['user*']) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>User</p>
                </a>
              </li>
            </ul>
          </li>
          @endif
          @if (in_array(Auth::user()->role, ['SUPERADMIN', 'BENDAHARA_SEKOLAH']))
          <li class="nav-item {{ request()->is(['siswa*', 'pegawai*']) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is(['siswa*', 'pegawai*']) ? 'active' : '' }}">
              <i class="fas fa-users"></i>
              <p>
                Siswa & Pegawai
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('siswa.index') }}" class="nav-link {{ request()->is(['siswa*']) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Siswa</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('pegawai.index') }}" class="nav-link {{ request()->is(['pegawai*']) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pegawai</p>
                </a>
              </li>
            </ul>
          </li>
          @endif
          @if (in_array(Auth::user()->role, ['SUPERADMIN', 'BENDAHARA_SEKOLAH']))
          <li class="nav-item {{ request()->is(['daftar_tagihan*', 'tagihan*']) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is(['daftar_tagihan*', 'tagihan*']) ? 'active' : '' }}">
              <i class="fas fa-money-bill-wave"></i>
              <p>
                Tagihan
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('daftar_tagihan.index') }}" class="nav-link {{ request()->is(['daftar_tagihan*']) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Daftar Tagihan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('tagihan.index') }}" class="nav-link {{ request()->is(['tagihan*']) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Tagihan Siswa</p>
                </a>
              </li>
            </ul>
          </li>
          @endif
          @if (in_array(Auth::user()->role, ['SUPERADMIN']))
          <li class="nav-item {{ request()->is(['kenaikan*', 'kelulusan*']) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is(['sikenaikanswa*', 'kelulusan*']) ? 'active' : '' }}">
              <i class="fas fa-graduation-cap"></i>
              <p>
                Kenaikan & Kelulusan
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('kenaikan.index') }}" class="nav-link {{ request()->is(['kenaikan*']) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kenaikan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('kelulusan.index') }}" class="nav-link {{ request()->is(['kelulusan*']) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kelulusan</p>
                </a>
              </li>
            </ul>
          </li>
          @endif
          <li class="nav-header">MULTI LEVEL EXAMPLE</li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-circle nav-icon"></i>
              <p>Level 1</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-circle"></i>
              <p>
                Level 1
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Level 2</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Level 2
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Level 3</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Level 3</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Level 3</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Level 2</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-circle nav-icon"></i>
              <p>Level 1</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

    <!-- Content Wrapper. Contains page content -->
        @yield('content')
       
    <!-- /.content-wrapper -->

  <footer class="main-footer">
    <strong>Copyright &copy; 2024</strong>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="/../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="/../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Ekko Lightbox -->
<script src="/../plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
<!-- AdminLTE App -->
<script src="/../dist/js/adminlte.min.js"></script>
<!-- Filterizr-->
<script src="/../plugins/filterizr/jquery.filterizr.min.js"></script>
<!-- AdminLTE for demo purposes -->
<!-- Page specific script -->
<!-- Toastr -->
<script src="/../plugins/toastr/toastr.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="/../plugins/datatables/jquery.dataTables.min.js"></script>
<!-- Select2 -->
<script src="/../plugins/select2/js/select2.full.min.js"></script>
<script src="/../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="/../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="/../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="/../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="/../plugins/jszip/jszip.min.js"></script>
<script src="/../plugins/pdfmake/pdfmake.min.js"></script>
<script src="/../plugins/pdfmake/vfs_fonts.js"></script>
<script src="/../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="/../plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="/../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  $(function () {
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
      event.preventDefault();
      $(this).ekkoLightbox({
        alwaysShowClose: true
      });
    });

    $('.btn[data-filter]').on('click', function() {
      $('.btn[data-filter]').removeClass('active');
      $(this).addClass('active');
    });
  });
  $('.select2').select2()

  $('.select2bs4').select2({
    theme: 'bootstrap4'
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
@yield('js')
</body>
</html>