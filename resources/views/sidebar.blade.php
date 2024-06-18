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
          <li class="nav-item {{ Str::is(['instansi*', 'kelas*', 'tahun_ajaran*', 'supplier*', 'akun*', 'user*', 'aset*', 'atk*', 'jabatan*', 'teknisi*', 'biro*', 'donatur*', 'siswa*', 'pegawai*', 'pengurus*'], Request::segment(2)) ? 'menu-open' : '' }}">
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
              @if($instansi != 'yayasan')
              <li class="nav-item">
                <a href="{{ route('kelas.index', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is(['kelas*'], Request::segment(2)) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kelas</p>
                </a>
              </li>
              @endif
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
                  <p>Aset Tetap</p>
                </a>
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
              @if($instansi == 'tk-kb-tpa')
              <li class="nav-item">
                <a href="{{ route('biro.index', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is(['biro*'], Request::segment(2)) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Biro</p>
                </a>
              </li>
              @endif
              @if($instansi == 'yayasan')
              <li class="nav-item">
                <a href="{{ route('donatur.index', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is(['donatur*'], Request::segment(2)) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Donatur</p>
                </a>
              </li>
              @endif
              <li class="nav-item">
                <a href="{{ route('akun.index', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is(['akun*'], Request::segment(2)) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Akun</p>
                </a>
              </li>
              @if($instansi != 'yayasan')
              <li class="nav-item">
                <a href="{{ route('siswa.index', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is(['siswa*'], Request::segment(2)) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Siswa</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('pegawai.index', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is(['pegawai*'], Request::segment(2)) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Guru & Karyawan</p>
                </a>
              </li>
              @endif
              @if($instansi == 'yayasan')
              <li class="nav-item">
                <a href="{{ route('pengurus.index', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is(['pengurus*'], Request::segment(2)) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pengurus</p>
                </a>
              </li>
              @endif
              <li class="nav-item">
                <a href="{{ route('user.index', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is(['user*'], Request::segment(2)) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>User</p>
                </a>
              </li>
            </ul>
          </li>
          @if($instansi != 'yayasan')
          <li class="nav-item {{ Str::is(['kenaikan*', 'kelulusan*', 'presensi*'], Request::segment(2)) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                SDM
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item {{ Str::is(['kenaikan*', 'kelulusan*'], Request::segment(2)) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Kesiswaan
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
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
              <li class="nav-item {{ Str::is(['pegawai*', 'presensi*'], Request::segment(2)) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Kepegawaian
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('presensi.index', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is(['presensi*'], Request::segment(2)) ? 'active' : '' }}">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Presensi</p>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
          </li>
          @endif
          <li class="nav-item {{ Str::is(['kartu-penyusutan*','kartu-stok*'], Request::segment(2)) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-boxes"></i>
              <p>
                Inventaris
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item {{ Str::is(['kartu-stok*'], Request::segment(2)) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    ATK
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  
                  <li class="nav-item"><source sizes="" srcset="">
                    <a href="{{ route('kartu-stok.index', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is(['kartu-stok*'], Request::segment(2)) ? 'active' : '' }}">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Kartu Stok</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item {{ Str::is(['kartu-penyusutan*'], Request::segment(2)) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Aset
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  
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
          @if($instansi != 'yayasan')
          <li class="nav-item {{ Str::is(['tagihan_siswa*'], Request::segment(2)) ? 'menu-open' : '' }}">
            <a href="{{ route('tagihan_siswa.index', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is(['tagihan_siswa*'], Request::segment(2)) ? 'active' : '' }}">
              <i class="nav-icon fas fa-file-invoice"></i>
              <p>
                Tagihan Siswa
              </p>
            </a>
          </li>
          @endif
          <li class="nav-item {{ Str::is(['pembayaran_siswa*', 'pemasukan_lainnya*', 'pemasukan_yayasan*'], Request::segment(2)) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-hand-holding-usd"></i>
              <p>
                Pemasukan Kas
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @if($instansi != 'yayasan')
              <li class="nav-item {{ Str::is(['pembayaran_siswa*'], Request::segment(2)) ? 'menu-open' : '' }}">
                <a href="{{ route('pembayaran_siswa.daftar', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is(['pembayaran_siswa*'], Request::segment(2)) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pembayaran Siswa</p>
                </a>
              </li>
              @endif
              @if($instansi == 'yayasan')
              <li class="nav-item {{ Str::is(['pemasukan_yayasan*'], Request::segment(2)) ? 'menu-open' : '' }}">
                <a href="{{ route('pemasukan_yayasan.index', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is(['pemasukan_yayasan*'], Request::segment(2)) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pemasukan Yayasan</p>
                </a>
              </li>
              @endif
              <li class="nav-item {{ Str::is(['pemasukan_lainnya*'], Request::segment(2)) ? 'menu-open' : '' }}">
                <a href="{{ route('pemasukan_lainnya.index', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is(['pemasukan_lainnya*'], Request::segment(2)) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Lainnya</p>
                </a>  
              </li>
            </ul>
          </li>
          <li class="nav-item {{ Str::is(['penggajian*', 'pengeluaran_lainnya*', 'pembelian-aset*', 'pembelian-atk*'], Request::segment(2)) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-receipt"></i>
              <p>
                Pengeluaran Kas
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('pembelian-aset.index', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is(['pembelian-aset*'], Request::segment(2)) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pembelian Aset Tetap</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('pembelian-atk.index', ['instansi' => 
                $instansi]) }}" class="nav-link {{ Str::is(['pembelian-atk*'], Request::segment(2)) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pembelian Atk</p>
                </a>
              </li>
              @if($instansi != 'yayasan')
              <li class="nav-item {{ Str::is(['penggajian*'], Request::segment(2)) ? 'menu-open' : '' }}">
                <a href="{{ route('penggajian.index', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is(['penggajian*'], Request::segment(2)) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Gaji</p>
                </a>
              </li>
              @endif
              <li class="nav-item {{ Str::is(['pengeluaran_lainnya*'], Request::segment(2)) ? 'menu-open' : '' }}">
                <a href="{{ route('pengeluaran_lainnya.index', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is(['pengeluaran_lainnya*'], Request::segment(2)) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Lainnya</p>
                </a>  
              </li>
            </ul>
          </li>
          <li class="nav-item {{ Str::is(['jurnal*'], Request::segment(2)) ? 'menu-open' : '' }}">
            <a href="{{ route('jurnal.index', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is(['jurnal*'], Request::segment(2)) ? 'active' : '' }}">
              <i class="nav-icon fas fa-journal-whills"></i>
              <p>Jurnal</p>
            </a>
          </li>
          <li class="nav-item {{ Str::is(['bukubesar*'], Request::segment(2)) ? 'menu-open' : '' }}">
            <a href="{{ route('bukubesar.index', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is(['bukubesar*'], Request::segment(2)) ? 'active' : '' }}">
              <i class="nav-icon fas fa-book"></i>
              <p>Buku Besar</p>
            </a>  
          </li>
          <li class="nav-item {{ Str::is(['neraca*'], Request::segment(2)) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Str::is(['neraca*'], Request::segment(2)) ? 'active' : '' }}">
              <i class="nav-icon fas fa-balance-scale"></i>
              <p>Neraca</p>
            </a>  
          </li>
          <li class="nav-item {{ Str::is(['laporan*'], Request::segment(2)) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Str::is(['laporan*'], Request::segment(2)) ? 'active' : '' }}">
              <i class="nav-icon fas fa-file-csv"></i>
              <p>
                Laporan
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">             
              {{-- <li class="nav-item {{ Str::is(['laporan*'], Request::segment(2)) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ Str::is(['laporan*'], Request::segment(2)) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Arus Kas</p>
                </a>  
              </li>
              <li class="nav-item {{ Str::is(['laporan*'], Request::segment(2)) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ Str::is(['laporan*'], Request::segment(2)) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Posisi Keuangan</p>
                </a>  
              </li>
              <li class="nav-item {{ Str::is(['laporan*'], Request::segment(2)) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ Str::is(['laporan*'], Request::segment(2)) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Aset Netto</p>
                </a>  
              </li>
              <li class="nav-item {{ Str::is(['laporan*'], Request::segment(2)) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ Str::is(['laporan*'], Request::segment(2)) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pengahsilan Komprehensif</p>
                </a>  
              </li> --}}
            </ul>
          </li>
          <li class="nav-item {{ Str::is(['laporan*'], Request::segment(2)) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Str::is(['laporan*'], Request::segment(2)) ? 'active' : '' }}">
              <i class="nav-icon fas fa-file-invoice-dollar"></i>
              <p>
                Laporan Keuangan
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">             
              <li class="nav-item {{ Str::is(['laporan*'], Request::segment(2)) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ Str::is(['laporan*'], Request::segment(2)) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Arus Kas</p>
                </a>  
              </li>
              <li class="nav-item {{ Str::is(['laporan*'], Request::segment(2)) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ Str::is(['laporan*'], Request::segment(2)) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Posisi Keuangan</p>
                </a>  
              </li>
              <li class="nav-item {{ Str::is(['laporan*'], Request::segment(2)) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ Str::is(['laporan*'], Request::segment(2)) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Aset Netto</p>
                </a>  
              </li>
              <li class="nav-item {{ Str::is(['laporan*'], Request::segment(2)) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ Str::is(['laporan*'], Request::segment(2)) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pengahsilan Komprehensif</p>
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