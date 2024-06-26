<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="/{{ $instansi }}/dashboard" class="brand-link text-center">
      <img src="{{ asset('logo-text.png') }}" alt="Logo PAPB" style="max-width: 100%; height: 60px;">
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
      @php
      use Illuminate\Support\Str;
      @endphp
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
          <li class="nav-item {{ Str::is(['instansi*', 'kelas*', 'tahun_ajaran*', 'supplier*', 'akun*', 'user*', 'aset', 'atk*', 'jabatan*', 'teknisi*', 'biro*', 'donatur*', 'siswa*', 'pegawai*', 'pengurus*', 'penyewa_kantin*', 'utilitas*'], Request::segment(2)) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Master
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @if(!Str::contains(Auth::user()->role, 'SARPRAS') && !Str::contains(Auth::user()->role, 'TU'))
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
              @endif
              <li class="nav-item">
                <a href="{{ route('supplier.index', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is(['supplier*'], Request::segment(2)) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Supplier</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('aset.index', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is(['aset'], Request::segment(2)) ? 'active' : '' }}">
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
              @if(!Str::contains(Auth::user()->role, 'SARPRAS') && !Str::contains(Auth::user()->role, 'TU'))
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
              <li class="nav-item">
                <a href="{{ route('penyewa_kantin.index', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is(['penyewa_kantin*'], Request::segment(2)) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Penyewa Kantin</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('utilitas.index', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is(['utilitas*'], Request::segment(2)) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Utilitas</p>
                </a>
              </li>
              @endif
              <li class="nav-item">
                <a href="{{ route('user.index', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is(['user*'], Request::segment(2)) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>User</p>
                </a>
              </li>
              @endif
            </ul>
          </li>
          @if(!Str::contains(Auth::user()->role, 'SARPRAS') && !Str::contains(Auth::user()->role, 'TU'))
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
          @if(!Str::contains(Auth::user()->role, 'SARPRAS') && !Str::contains(Auth::user()->role, 'TU'))
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
          @endif
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
              @if(!Str::contains(Auth::user()->role, 'SARPRAS') && !Str::contains(Auth::user()->role, 'TU'))
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
              @endif
            </ul>
          </li>
          @if(!Str::contains(Auth::user()->role, 'SARPRAS') && !Str::contains(Auth::user()->role, 'TU'))
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
            <a href="{{ route('neraca.index', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is(['neraca*'], Request::segment(2)) ? 'active' : '' }}">
              <i class="nav-icon fas fa-balance-scale"></i>
              <p>Neraca</p>
            </a>  
          </li>
          <li class="nav-item {{ Str::is(['laporan*'], Request::segment(2)) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-file-csv"></i>
              <p>
                Laporan
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">             
              <li class="nav-item {{ Str::is(['laporan_data*'], Request::segment(3)) ? 'menu-open' : '' }}">
                <a href="{{ route('laporan_data.spp', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is("$instansi/laporan_data/spp*", request()->path()) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>SPP</p>
                </a>  
              </li>
              <li class="nav-item {{ Str::is(['laporan_data*'], Request::segment(3)) ? 'menu-open' : '' }}">
                <a href="{{ route('laporan_data.jpi', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is("$instansi/laporan_data/jpi*", request()->path()) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>JPI</p>
                </a>  
              </li>
              <li class="nav-item {{ Str::is(['laporan_data*'], Request::segment(3)) ? 'menu-open' : '' }}">
                <a href="{{ route('laporan_data.registrasi', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is("$instansi/laporan_data/registrasi*", request()->path()) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Registrasi</p>
                </a>  
              </li>
              <li class="nav-item {{ Str::is(['laporan_data*'], Request::segment(3)) ? 'menu-open' : '' }}">
                <a href="{{ route('laporan_data.donasi', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is("$instansi/laporan_data/donasi*", request()->path()) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Donasi</p>
                </a>  
              </li>
              <li class="nav-item {{ Str::is(['laporan_data*'], Request::segment(3)) ? 'menu-open' : '' }}">
                <a href="{{ route('laporan_data.sewa_kantin', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is("$instansi/laporan_data/sewa_kantin*", request()->path()) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sewa Kantin</p>
                </a>  
              </li>
              <li class="nav-item {{ Str::is(['laporan_data*'], Request::segment(3)) ? 'menu-open' : '' }}">
                <a href="{{ route('laporan_data.pemasukan_lainnya', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is("$instansi/laporan_data/pemasukan_lainnya*", request()->path()) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pemasukan Lainnya</p>
                </a>  
              </li>
              <li class="nav-item {{ Str::is(['laporan_data*'], Request::segment(3)) ? 'menu-open' : '' }}">
                <a href="{{ route('laporan_data.aset', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is("$instansi/laporan_data/aset*", request()->path()) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pembelian Aset</p>
                </a>  
              </li>
              <li class="nav-item {{ Str::is(['laporan_data*'], Request::segment(3)) ? 'menu-open' : '' }}">
                <a href="{{ route('laporan_data.atk', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is("$instansi/laporan_data/atk*", request()->path()) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pembelian Atk</p>
                </a>  
              </li>
              <li class="nav-item {{ Str::is(['laporan_data*'], Request::segment(3)) ? 'menu-open' : '' }}">
                <a href="{{ route('laporan_data.perbaikan_aset', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is("$instansi/laporan_data/perbaikan_aset*", request()->path()) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Perbaikan Aset</p>
                </a>  
              </li>
              <li class="nav-item {{ Str::is(['laporan_data*'], Request::segment(3)) ? 'menu-open' : '' }}">
                <a href="{{ route('laporan_data.operasional', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is("$instansi/laporan_data/operasional*", request()->path()) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Operasional</p>
                </a>  
              </li>
              <li class="nav-item {{ Str::is(['laporan_data*'], Request::segment(3)) ? 'menu-open' : '' }}">
                <a href="{{ route('laporan_data.outbond', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is("$instansi/laporan_data/outbond*", request()->path()) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Outbond</p>
                </a>  
              </li>
              <li class="nav-item {{ Str::is(['laporan_data*'], Request::segment(3)) ? 'menu-open' : '' }}">
                <a href="{{ route('laporan_data.gaji', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is("$instansi/laporan_data/gaji*", request()->path()) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Gaji</p>
                </a>  
              </li>
              <li class="nav-item {{ Str::is(['laporan_data*'], Request::segment(3)) ? 'menu-open' : '' }}">
                <a href="{{ route('laporan_data.pengeluaran_lainnya', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is("$instansi/laporan_data/pengeluaran_lainnya*", request()->path()) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pengeluaran Lainnya</p>
                </a>  
              </li>
            </ul>
          </li>
          <li class="nav-item {{ Str::is(['komprehensif*', 'posisi*', 'aset_netto*', 'arus_kas*'], Request::segment(2)) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Str::is(['komprehensif*', 'posisi*', 'aset_netto*', 'arus_kas*'], Request::segment(2)) ? 'active' : '' }}">
              <i class="nav-icon fas fa-file-invoice-dollar"></i>
              <p>
                Laporan Keuangan
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">             
              <li class="nav-item {{ Str::is(['komprehensif*'], Request::segment(2)) ? 'menu-open' : '' }}">
                <a href="{{ route('komprehensif.index', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is(['komprehensif*'], Request::segment(2)) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pengahsilan Komprehensif</p>
                </a>  
              </li>
              <li class="nav-item {{ Str::is(['posisi*'], Request::segment(2)) ? 'menu-open' : '' }}">
                <a href="{{ route('posisi.index', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is(['posisi*'], Request::segment(2)) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Posisi Keuangan</p>
                </a>  
              </li>
              <li class="nav-item {{ Str::is(['aset_netto*'], Request::segment(2)) ? 'menu-open' : '' }}">
                <a href="{{ route('aset_netto.index', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is(['aset_netto*'], Request::segment(2)) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Aset Netto</p>
                </a>  
              </li>
              <li class="nav-item {{ Str::is(['arus_kas*'], Request::segment(2)) ? 'menu-open' : '' }}">
                <a href="{{ route('arus_kas.index', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is(['arus_kas*'], Request::segment(2)) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Arus Kas</p>
                </a>  
              </li>
            </ul>
          </li>
          @endif
          @if(Auth::user()->role == 'ADMIN')
          <hr style="border: 1px solid white;width: 100%">
          <li class="nav-item {{ Str::is(['log*'], Request::segment(2)) ? 'menu-open' : '' }}">
            <a href="{{ route('log.index', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is(['log*'], Request::segment(2)) ? 'active' : '' }}">
              <i class="nav-icon fas fa-list-alt"></i>
              <p>Log</p>
            </a>
          </li>
          <li class="nav-item {{ Str::is(['backup*'], Request::segment(2)) ? 'menu-open' : '' }}">
            <a href="{{ route('backup.index', ['instansi' => $instansi]) }}" class="nav-link {{ Str::is(['backup*'], Request::segment(2)) ? 'active' : '' }}">
              <i class="nav-icon fas fa-database"></i>
              <p>Backup</p>
            </a>
          </li>
          @endif
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>