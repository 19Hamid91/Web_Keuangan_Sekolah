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
            <h1 class="m-0">Dashboard</h1>
          </div>
        </div>
      </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="card">
          <div class="card-header">
            <h3 class="text-center mt-3">TK-KB-TPA</h3>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-lg-4 col-6">
                <div class="small-box bg-warning">
                  <div class="inner">
                    <h3>{{ $kelas2 }}</h3>
    
                    <p>Kelas</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                  </div>
                  <a href="{{ route('kelas.index', ['instansi' => 'tk-kb-tpa']) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <div class="col-lg-4 col-6">
                <div class="small-box bg-white">
                  <div class="inner">
                    <h3>{{ $siswa2 }}</h3>
    
                    <p>Siswa</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                  </div>
                  <a href="{{ route('siswa.index', ['instansi' => 'tk-kb-tpa']) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <div class="col-lg-4 col-6">
                <div class="small-box bg-secondary">
                  <div class="inner">
                    <h3>{{ $guru2 }}</h3>
    
                    <p>Guru & Karyawan</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                  </div>
                  <a href="{{ route('pegawai.index', ['instansi' => 'tk-kb-tpa']) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-4 col-6">
                <div class="small-box bg-success">
                  <div class="inner">
                    <h3><sup style="font-size: 20px">Rp</sup>{{ formatRupiah2($pemasukan2) }}</h3>
    
                    <p>Pemasukan</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                  </div>
                  <a href="{{ route('pembayaran_siswa.daftar', ['instansi' => 'tk-kb-tpa']) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <div class="col-lg-4 col-6">
                <div class="small-box bg-danger">
                  <div class="inner">
                    <h3><sup style="font-size: 20px">Rp</sup>{{ formatRupiah2($pengeluaran2) }}</h3>
    
                    <p>Pengeluaran</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                  </div>
                  <a href="{{ route('pembelian-aset.index', ['instansi' => 'tk-kb-tpa']) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <div class="col-lg-4 col-6">
                <div class="small-box bg-info">
                  <div class="inner">
                    <h3><sup style="font-size: 20px">Rp</sup>{{ formatRupiah2($saldo2) }}</h3>
    
                    <p>Saldo</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                  </div>
                  <a href="{{ route('jurnal.index', ['instansi' => 'tk-kb-tpa']) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header">
            <h3 class="text-center mt-3">SMP</h3>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-lg-4 col-6">
                <div class="small-box bg-warning">
                  <div class="inner">
                    <h3>{{ $kelas3 }}</h3>
    
                    <p>Kelas</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                  </div>
                  <a href="{{ route('kelas.index', ['instansi' => 'smp']) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <div class="col-lg-4 col-6">
                <div class="small-box bg-white">
                  <div class="inner">
                    <h3>{{ $siswa3 }}</h3>
    
                    <p>Siswa</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                  </div>
                  <a href="{{ route('siswa.index', ['instansi' => 'smp']) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <div class="col-lg-4 col-6">
                <div class="small-box bg-secondary">
                  <div class="inner">
                    <h3>{{ $guru3 }}</h3>
    
                    <p>Guru & Karyawan</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                  </div>
                  <a href="{{ route('pegawai.index', ['instansi' => 'smp']) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-4 col-6">
                <div class="small-box bg-success">
                  <div class="inner">
                    <h3><sup style="font-size: 20px">Rp</sup>{{ formatRupiah2($pemasukan3) }}</h3>
    
                    <p>Pemasukan</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                  </div>
                  <a href="{{ route('pembayaran_siswa.daftar', ['instansi' => 'smp']) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <div class="col-lg-4 col-6">
                <div class="small-box bg-danger">
                  <div class="inner">
                    <h3><sup style="font-size: 20px">Rp</sup>{{ formatRupiah2($pengeluaran3) }}</h3>
    
                    <p>Pengeluaran</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                  </div>
                  <a href="{{ route('pembelian-aset.index', ['instansi' => 'smp']) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <div class="col-lg-4 col-6">
                <div class="small-box bg-info">
                  <div class="inner">
                    <h3><sup style="font-size: 20px">Rp</sup>{{ formatRupiah2($saldo3) }}</h3>
    
                    <p>Saldo</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                  </div>
                  <a href="{{ route('jurnal.index', ['instansi' => 'smp']) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header">
            <h3 class="text-center mt-3">Yayasan</h3>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-lg-3 col-6">
                <div class="small-box bg-secondary">
                  <div class="inner">
                    <h3>{{ $pengurus1 }}</h3>
    
                    <p>Pengurus</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                  </div>
                  <a href="{{ route('pengurus.index', ['instansi' => 'yayasan']) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                  <div class="inner">
                    <h3><sup style="font-size: 20px">Rp</sup>{{ formatRupiah2($pemasukan1) }}</h3>
    
                    <p>Pemasukan</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                  </div>
                  <a href="{{ route('pemasukan_yayasan.index', ['instansi' => 'yayasan']) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                  <div class="inner">
                    <h3><sup style="font-size: 20px">Rp</sup>{{ formatRupiah2($pengeluaran1) }}</h3>
    
                    <p>Pengeluaran</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                  </div>
                  <a href="{{ route('pembelian-aset.index', ['instansi' => 'yayasan']) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                  <div class="inner">
                    <h3><sup style="font-size: 20px">Rp</sup>{{ formatRupiah2($saldo1) }}</h3>
    
                    <p>Saldo</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                  </div>
                  <a href="{{ route('jurnal.index', ['instansi' => 'yayasan']) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
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
    
@endsection