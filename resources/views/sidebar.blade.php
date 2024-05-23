<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="/{{ $instansi }}/dashboard" class="brand-link">
      <img src="/../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Web PAPB</span>
    </a>

    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="/../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <span class="d-block text-white">{{ Auth::user()->name }}</span>
        </div>
      </div>

      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item {{ Str::is(['dashboard*'], Request::segment(2)) ? 'menu-open' : '' }}">
            <a href="{{ route('dashboard', ['instansi' => $instansi]) }}" class="nav-link {{ request()->is(['dashboard*', 'users*']) ? 'active' : '' }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item {{ Str::is(['instansi*', 'kelas*', 'tahun_ajaran*', 'akun*', 'user*', 'aset*', 'atk*'], Request::segment(2)) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Master
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('instansi.index', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is(['instansi*'], Request::segment(2)) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Instansi</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('kelas.index', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is(['kelas*'], Request::segment(2)) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kelas</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('tahun_ajaran.index', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is(['tahun_ajaran*'], Request::segment(2)) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Tahun Ajaran</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('aset.index', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is(['aset*'], Request::segment(2)) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Aset</p>
                </a>
              </li>
              </li>
              <li class="nav-item">
                <a href="{{ route('atk.index', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is(['atk*'], Request::segment(2)) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>ATK</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link {{ Str::is(['akun*'], Request::segment(2)) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Akun</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('user.index', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is(['user*'], Request::segment(2)) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>User</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item {{ Str::is(['kenaikan*', 'kelulusan*', 'siswa*'], Request::segment(2)) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link ">
              <i class="fas fa-users"></i>
              <p>
                SDM
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item {{ Str::is(['kenaikan*', 'kelulusan*', 'siswa*'], Request::segment(2)) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Kesiswaan
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('siswa.index', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is(['siswa*'], Request::segment(2)) ? 'active' : '' }}">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Siswa</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('kenaikan.index', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is(['kenaikan*'], Request::segment(2)) ? 'active' : '' }}">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Kenaikan</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('kelulusan.index', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is(['kelulusan*'], Request::segment(2)) ? 'active' : '' }}">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Kelulusan</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pegawai</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item {{ Str::is(['pembelian-aset*', 'kartu-aset*', 'pembelian-atk*', 'kartu-atk*'], Request::segment(2)) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is(['inven*', 'inven_log*']) ? 'active' : '' }}">
              <i class="fas fa-boxes"></i>
              <p>
                Inventaris
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item {{ Str::is(['pembelian-aset*', 'kartu-aset*'], Request::segment(2)) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    ATK
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Pembelian</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Kartu</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item {{ Str::is(['pembelian-aset*', 'kartu-aset*'], Request::segment(2)) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Aset
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Pembelian</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Kartu</p>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
          </li>
          <li class="nav-item {{ Str::is(['spp*', 'jpi*', 'registrasi*', 'overtime*', 'outbound*', 'donatur*', 'sewa-kantin*'], Request::segment(2)) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is(['inven*', 'inven_log*']) ? 'active' : '' }}">
              <i class="fas fa-hand-holding-usd"></i>
              <p>
                Pemasukan Kas
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link {{ request()->is(['inven*']) && request()->get('jenis') == 'Sekolah' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>SPP</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link {{ request()->is(['inven*']) && request()->get('jenis') == 'Yayasan' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>JPI</p>
                </a>  
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link {{ request()->is(['inven*']) && request()->get('jenis') == 'Yayasan' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Registrasi</p>
                </a>  
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link {{ request()->is(['inven*']) && request()->get('jenis') == 'Yayasan' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Overtime</p>
                </a>  
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link {{ request()->is(['inven*']) && request()->get('jenis') == 'Yayasan' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Outbound</p>
                </a>  
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link {{ request()->is(['inven*']) && request()->get('jenis') == 'Yayasan' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Donatur</p>
                </a>  
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link {{ request()->is(['inven*']) && request()->get('jenis') == 'Yayasan' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sewa Kantin</p>
                </a>  
              </li>
            </ul>
          </li>
          <li class="nav-item {{ Str::is(['pembelian-aset*', 'perbaikan-aset*', 'pembelian-atk*', 'kegiatan-siswa*', 'gaji*', 'operasional*', 'outbond*', 'transport*', 'honor-dokter*'], Request::segment(2)) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is(['inven*', 'inven_log*']) ? 'active' : '' }}">
              <i class="fas fa-receipt"></i>
              <p>
                Pengeluaran Kas
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link {{ request()->is(['inven*']) && request()->get('jenis') == 'Sekolah' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pembelian Aset</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link {{ request()->is(['inven*']) && request()->get('jenis') == 'Yayasan' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Perbaikan Aset</p>
                </a>  
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link {{ request()->is(['inven*']) && request()->get('jenis') == 'Yayasan' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pembelian ATK</p>
                </a>  
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link {{ request()->is(['inven*']) && request()->get('jenis') == 'Yayasan' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kegiatan Siswa</p>
                </a>  
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link {{ request()->is(['inven*']) && request()->get('jenis') == 'Yayasan' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Gaji</p>
                </a>  
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link {{ request()->is(['inven*']) && request()->get('jenis') == 'Yayasan' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Operasional</p>
                </a>  
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link {{ request()->is(['inven*']) && request()->get('jenis') == 'Yayasan' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Outbond</p>
                </a>  
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link {{ request()->is(['inven*']) && request()->get('jenis') == 'Yayasan' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Transport</p>
                </a>  
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link {{ request()->is(['inven*']) && request()->get('jenis') == 'Yayasan' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Honor Dokter</p>
                </a>  
              </li>
            </ul>
          </li>
          <li class="nav-item {{ Str::is(['jurnal*', 'buku_besar*', 'neraca*', 'laporan*'], Request::segment(2)) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is(['inven*', 'inven_log*']) ? 'active' : '' }}">
              <i class="fas fa-book"></i>
              <p>
                Rekapitulasi
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link {{ request()->is(['inven*']) && request()->get('jenis') == 'Sekolah' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Jurnal</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link {{ request()->is(['inven*']) && request()->get('jenis') == 'Yayasan' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Buku Besar</p>
                </a>  
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link {{ request()->is(['inven*']) && request()->get('jenis') == 'Yayasan' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Neraca</p>
                </a>  
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link {{ request()->is(['inven*']) && request()->get('jenis') == 'Yayasan' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Laporan</p>
                </a>  
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>