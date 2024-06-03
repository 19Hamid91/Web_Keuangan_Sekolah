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
          <small class="text-white">({{ Auth::user()->role }})</small>
        </div>
      </div>

      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item {{ Str::is(['dashboard*'], Request::segment(2)) ? 'menu-open' : '' }}">
            <a href="{{ route('dashboard', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is(['dashboard*'], Request::segment(2)) ? 'active' : '' }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item {{ Str::is(['instansi*', 'kelas*', 'tahun_ajaran*', 'supplier*', 'akun*','setakun*', 'user*', 'aset*', 'atk*', 'jabatan*', 'teknisi*', 'biro*', 'donatur*'], Request::segment(2)) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Str::is(['instansi*', 'kelas*', 'tahun_ajaran*', 'supplier*', 'akun*','setakun*', 'user*', 'aset*', 'atk*', 'jabatan*', 'teknisi*', 'biro*', 'donatur*'], Request::segment(2)) ? 'active' : '' }}">
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
                <a href="{{ route('supplier.index', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is(['supplier*'], Request::segment(2)) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Supplier</p>
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
                <a href="{{ route('jabatan.index', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is(['jabatan*'], Request::segment(2)) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Jabatan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('teknisi.index', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is(['teknisi*'], Request::segment(2)) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Teknisi</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('biro.index', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is(['biro*'], Request::segment(2)) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Biro</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('donatur.index', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is(['donatur*'], Request::segment(2)) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Donatur</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('akun.index', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is(['akun*'], Request::segment(2)) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Akun</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('setakun.index', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is(['setakun*'], Request::segment(2)) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Set Akun</p>
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
          <li class="nav-item {{ Str::is(['kenaikan*', 'kelulusan*', 'siswa*', 'pegawai*'], Request::segment(2)) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Str::is(['kenaikan*', 'kelulusan*', 'siswa*', 'pegawai*'], Request::segment(2)) ? 'active' : '' }}">
              <i class="nav-icon fas fa-users"></i>
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
              <li class="nav-item {{ Str::is(['pegawai*'], Request::segment(2)) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ Str::is(['pegawai*'], Request::segment(2)) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Kepegawaian
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('pegawai.index', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is(['pegawai*'], Request::segment(2)) ? 'active' : '' }}">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Pegawai</p>
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
            </ul>
          </li>
          <li class="nav-item {{ Str::is(['pembelian-aset*', 'kartu-penyusutan*', 'pembelian-atk*', 'kartu-stok*'], Request::segment(2)) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Str::is(['pembelian-aset*', 'kartu-penyusutan*', 'pembelian-atk*', 'kartu-stok*'], Request::segment(2)) ? 'active' : '' }}">
              <i class="nav-icon fas fa-boxes"></i>
              <p>
                Inventaris
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item {{ Str::is(['pembelian-atk*', 'kartu-stok*'], Request::segment(2)) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    ATK
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('pembelian-atk.index', ['instansi' => 
                    $instansi]) }}" class="nav-link {{ Str::is(['pembelian-atk*'], Request::segment(2)) ? 'active' : '' }}">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Pembelian</p>
                    </a>
                  </li>
                  <li class="nav-item"><source sizes="" srcset="">
                    <a href="{{ route('kartu-stok.index', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is(['kartu-stok*'], Request::segment(2)) ? 'active' : '' }}">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Kartu Stok</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item {{ Str::is(['pembelian-aset*', 'kartu-penyusutan*'], Request::segment(2)) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Aset
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('pembelian-aset.index', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is(['pembelian-aset*'], Request::segment(2)) ? 'active' : '' }}">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Pembelian</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('kartu-penyusutan.index', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is(['kartu-penyusutan*'], Request::segment(2)) ? 'active' : '' }}">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Kartu Penyusutan</p>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
          </li>
          <li class="nav-item {{ Str::is(['tagihan_siswa*'], Request::segment(2)) ? 'menu-open' : '' }}">
            <a href="{{ route('tagihan_siswa.index', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is(['tagihan_siswa*'], Request::segment(2)) ? 'active' : '' }}">
              <i class="nav-icon fas fa-file-invoice"></i>
              <p>
                Tagihan Siswa
              </p>
            </a>
          </li>
          <li class="nav-item {{ Str::is(['pembayaran_siswa*'], Request::segment(2)) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Str::is(['pembayaran_siswa*'], Request::segment(2)) ? 'active' : '' }}">
              <i class="nav-icon fas fa-hand-holding-usd"></i>
              <p>
                Pemasukan Kas
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item {{ Str::is(['pembayaran_siswa*'], Request::segment(2)) ? 'menu-open' : '' }}">
                <a href="{{ route('pembayaran_siswa.daftar', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is(['pembayaran_siswa*'], Request::segment(2)) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pembayaran Siswa</p>
                </a>
              </li>
              <li class="nav-item {{ Str::is(['pemasukan_lainnya*'], Request::segment(2)) ? 'menu-open' : '' }}">
                <a href="{{ route('pemasukan_lainnya.index', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is(['pemasukan_lainnya*'], Request::segment(2)) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Lainnya</p>
                </a>  
              </li>
            </ul>
          </li>
          <li class="nav-item {{ Str::is(['pembelian-aset*', 'perbaikan-aset*', 'pembelian-atk*', 'kegiatan-siswa*', 'gaji*', 'operasional*', 'outbond*', 'transport*', 'honor-dokter*'], Request::segment(2)) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is(['inven*', 'inven_log*']) ? 'active' : '' }}">
              <i class="nav-icon fas fa-receipt"></i>
              <p>
                Pengeluaran Kas
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link {{ request()->is(['inven*']) && request()->get('jenis') == 'Sekolah' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Gaji</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link {{ request()->is(['inven*']) && request()->get('jenis') == 'Yayasan' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Lainnya</p>
                </a>  
              </li>
            </ul>
          </li>
          <li class="nav-item {{ Str::is(['jurnal*', 'buku_besar*', 'neraca*', 'laporan*'], Request::segment(2)) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is(['inven*', 'inven_log*']) ? 'active' : '' }}">
              <i class="nav-icon fas fa-book"></i>
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