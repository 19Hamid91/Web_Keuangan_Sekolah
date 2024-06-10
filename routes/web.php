<?php

use App\Http\Controllers\AkunController;
use App\Http\Controllers\AsetController;
use App\Http\Controllers\AtkController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BiroController;
use App\Http\Controllers\DonaturController;
use App\Http\Controllers\InstansiController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\JurnalController;
use App\Http\Controllers\KartuPenyusutanController;
use App\Http\Controllers\KartuStokController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TahunAjaranController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KenaikanController;
use App\Http\Controllers\KelulusanController;
use App\Http\Controllers\PemasukanLainnyaController;
use App\Http\Controllers\PembayaranSiswaController;
use App\Http\Controllers\PembelianAsetController;
use App\Http\Controllers\PembelianAtkController;
use App\Http\Controllers\PengeluaranLainnyaController;
use App\Http\Controllers\PenggajianController;
use App\Http\Controllers\PresensiKaryawanController;
use App\Http\Controllers\SetAkunController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TagihanSiswaController;
use App\Http\Controllers\TeknisiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'formLogin'])->name('formLogin');
Route::post('/login',[AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'formRegister'])->name('formRegister');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::group(['middleware' => ['auth']], function() {
    // start new route
    Route::get('/pilih-instansi', [AuthController::class, 'pilih_instansi']);
    Route::get('findKaryawan', [PegawaiController::class, 'findKaryawan'])->name('findKaryawan');
    Route::get('profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('profile', [AuthController::class, 'profile_update'])->name('profile.update');
    Route::get('/datakelas/{sekolah_id}', [KelasController::class, 'datakelas']);
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::group(['prefix' => '{instansi}', 'middleware' => 'checkInstansi'], function() {
        Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

        Route::group(['prefix' => 'user', 'middleware' => ['checkRole:SUPERADMIN']], function() {
            Route::get('/',  [UserController::class, 'index'])->name('user.index');
            Route::post('/create',[UserController::class, 'store'])->name('user.store');
            Route::patch('/{user}/update', [UserController::class, 'update'])->name('user.update');
            Route::get('/{user}/delete', [UserController::class, 'destroy'])->name('user.destroy');
        });

        Route::group(['prefix' => 'instansi', 'middleware' => ['checkRole:SUPERADMIN']], function() {
            Route::get('/', [InstansiController::class, 'index'])->name('instansi.index');
            Route::post('/create', [InstansiController::class, 'store'])->name('instansi.store');
            Route::patch('/{id}/update', [InstansiController::class, 'update'])->name('instansi.update');
            Route::get('/{id}/delete', [InstansiController::class, 'destroy'])->name('instansi.destroy');
        });
    
        Route::group(['prefix' => 'kelas', 'middleware' => ['checkRole:SUPERADMIN']], function() {
            Route::get('/', [KelasController::class, 'index'])->name('kelas.index');
            Route::post('/create', [KelasController::class, 'store'])->name('kelas.store');
            Route::patch('/{id}/update', [KelasController::class, 'update'])->name('kelas.update');
            Route::get('/{id}/delete', [KelasController::class, 'destroy'])->name('kelas.destroy');
        });

        Route::group(['prefix' => 'tahun_ajaran', 'middleware' => ['checkRole:SUPERADMIN']], function() {
            Route::get('/', [TahunAjaranController::class, 'index'])->name('tahun_ajaran.index');
            Route::post('/create', [TahunAjaranController::class, 'store'])->name('tahun_ajaran.store');
            Route::patch('/{tahun_ajaran}/update', [TahunAjaranController::class, 'update'])->name('tahun_ajaran.update');
            Route::get('/{tahun_ajaran}/delete', [TahunAjaranController::class, 'destroy'])->name('tahun_ajaran.destroy');
        });

        Route::group(['prefix' => 'supplier', 'middleware' => ['checkRole:SUPERADMIN']], function() {
            Route::get('/', [SupplierController::class, 'index'])->name('supplier.index');
            Route::post('/create', [SupplierController::class, 'store'])->name('supplier.store');
            Route::patch('/{id}/update', [SupplierController::class, 'update'])->name('supplier.update');
            Route::get('/{id}/delete', [SupplierController::class, 'destroy'])->name('supplier.destroy');
        });

        Route::group(['prefix' => 'aset', 'middleware' => ['checkRole:SUPERADMIN']], function() {
            Route::get('/', [AsetController::class, 'index'])->name('aset.index');
            Route::post('/create', [AsetController::class, 'store'])->name('aset.store');
            Route::patch('/{aset}/update', [AsetController::class, 'update'])->name('aset.update');
            Route::get('/{aset}/delete', [AsetController::class, 'destroy'])->name('aset.destroy');
        });

        Route::group(['prefix' => 'atk', 'middleware' => ['checkRole:SUPERADMIN']], function() {
            Route::get('/', [AtkController::class, 'index'])->name('atk.index');
            Route::post('/create', [AtkController::class, 'store'])->name('atk.store');
            Route::patch('/{atk}/update', [AtkController::class, 'update'])->name('atk.update');
            Route::get('/{atk}/delete', [AtkController::class, 'destroy'])->name('atk.destroy');
        });

        Route::group(['prefix' => 'siswa', 'middleware' => ['checkRole:SUPERADMIN,BENDAHARA_SEKOLAH']], function() {
            Route::get('/', [SiswaController::class, 'index'])->name('siswa.index');
            Route::get('/create', [SiswaController::class, 'create'])->name('siswa.create');
            Route::post('/create', [SiswaController::class, 'store'])->name('siswa.store');
            Route::get('/{siswa}/edit', [SiswaController::class, 'edit'])->name('siswa.edit');
            Route::get('/{siswa}/show', [SiswaController::class, 'show'])->name('siswa.show');
            Route::patch('/{siswa}/update', [SiswaController::class, 'update'])->name('siswa.update');
            Route::get('/{siswa}/delete', [SiswaController::class, 'destroy'])->name('siswa.destroy');
        });

        Route::group(['prefix' => 'pembelian-aset', 'middleware' => ['checkRole:SUPERADMIN,BENDAHARA_SEKOLAH']], function() {
            Route::get('/', [PembelianAsetController::class, 'index'])->name('pembelian-aset.index');
            Route::get('/create', [PembelianAsetController::class, 'create'])->name('pembelian-aset.create');
            Route::post('/create', [PembelianAsetController::class, 'store'])->name('pembelian-aset.store');
            Route::get('/{id}/edit', [PembelianAsetController::class, 'edit'])->name('pembelian-aset.edit');
            Route::get('/{id}/show', [PembelianAsetController::class, 'show'])->name('pembelian-aset.show');
            Route::patch('/{id}/update', [PembelianAsetController::class, 'update'])->name('pembelian-aset.update');
            Route::get('/{id}/delete', [PembelianAsetController::class, 'destroy'])->name('pembelian-aset.destroy');
        });

        Route::group(['prefix' => 'pembelian-atk', 'middleware' => ['checkRole:SUPERADMIN,BENDAHARA_SEKOLAH']], function() {
            Route::get('/', [PembelianAtkController::class, 'index'])->name('pembelian-atk.index');
            Route::get('/create', [PembelianAtkController::class, 'create'])->name('pembelian-atk.create');
            Route::post('/create', [PembelianAtkController::class, 'store'])->name('pembelian-atk.store');
            Route::get('/{id}/edit', [PembelianAtkController::class, 'edit'])->name('pembelian-atk.edit');
            Route::get('/{id}/show', [PembelianAtkController::class, 'show'])->name('pembelian-atk.show');
            Route::patch('/{id}/update', [PembelianAtkController::class, 'update'])->name('pembelian-atk.update');
            Route::get('/{id}/delete', [PembelianAtkController::class, 'destroy'])->name('pembelian-atk.destroy');
        });

        Route::group(['prefix' => 'kartu-stok', 'middleware' => ['checkRole:SUPERADMIN,BENDAHARA_SEKOLAH']], function() {
            Route::get('/', [KartuStokController::class, 'index'])->name('kartu-stok.index');
            Route::get('/create', [KartuStokController::class, 'create'])->name('kartu-stok.create');
            Route::post('/create', [KartuStokController::class, 'store'])->name('kartu-stok.store');
            Route::get('/{id}/edit', [KartuStokController::class, 'edit'])->name('kartu-stok.edit');
            Route::get('/{id}/show', [KartuStokController::class, 'show'])->name('kartu-stok.show');
            Route::patch('/{id}/update', [KartuStokController::class, 'update'])->name('kartu-stok.update');
            Route::get('/{id}/delete', [KartuStokController::class, 'destroy'])->name('kartu-stok.destroy');
        });

        Route::group(['prefix' => 'kartu-penyusutan', 'middleware' => ['checkRole:SUPERADMIN,BENDAHARA_SEKOLAH']], function() {
            Route::get('/save', [KartuPenyusutanController::class, 'save'])->name('kartu-penyusutan.save');
            Route::get('/', [KartuPenyusutanController::class, 'index'])->name('kartu-penyusutan.index');
            Route::get('/create', [KartuPenyusutanController::class, 'create'])->name('kartu-penyusutan.create');
            Route::post('/create', [KartuPenyusutanController::class, 'store'])->name('kartu-penyusutan.store');
            Route::get('/{id}/edit', [KartuPenyusutanController::class, 'edit'])->name('kartu-penyusutan.edit');
            Route::get('/{id}/show', [KartuPenyusutanController::class, 'show'])->name('kartu-penyusutan.show');
            Route::patch('/{id}/update', [KartuPenyusutanController::class, 'update'])->name('kartu-penyusutan.update');
            Route::get('/{id}/delete', [KartuPenyusutanController::class, 'destroy'])->name('kartu-penyusutan.destroy');
        });

        Route::group(['prefix' => 'jabatan', 'middleware' => ['checkRole:SUPERADMIN']], function() {
            Route::get('/', [JabatanController::class, 'index'])->name('jabatan.index');
            Route::post('/create', [JabatanController::class, 'store'])->name('jabatan.store');
            Route::patch('/{jabatan}/update', [JabatanController::class, 'update'])->name('jabatan.update');
            Route::get('/{jabatan}/delete', [JabatanController::class, 'destroy'])->name('jabatan.destroy');
        });

        Route::group(['prefix' => 'teknisi', 'middleware' => ['checkRole:SUPERADMIN']], function() {
            Route::get('/', [TeknisiController::class, 'index'])->name('teknisi.index');
            Route::post('/create', [TeknisiController::class, 'store'])->name('teknisi.store');
            Route::patch('/{teknisi}/update', [TeknisiController::class, 'update'])->name('teknisi.update');
            Route::get('/{teknisi}/delete', [TeknisiController::class, 'destroy'])->name('teknisi.destroy');
        });

        Route::group(['prefix' => 'biro', 'middleware' => ['checkRole:SUPERADMIN']], function() {
            Route::get('/', [BiroController::class, 'index'])->name('biro.index');
            Route::post('/create', [BiroController::class, 'store'])->name('biro.store');
            Route::patch('/{biro}/update', [BiroController::class, 'update'])->name('biro.update');
            Route::get('/{biro}/delete', [BiroController::class, 'destroy'])->name('biro.destroy');
        });

        Route::group(['prefix' => 'donatur', 'middleware' => ['checkRole:SUPERADMIN']], function() {
            Route::get('/', [DonaturController::class, 'index'])->name('donatur.index');
            Route::post('/create', [DonaturController::class, 'store'])->name('donatur.store');
            Route::patch('/{donatur}/update', [DonaturController::class, 'update'])->name('donatur.update');
            Route::get('/{donatur}/delete', [DonaturController::class, 'destroy'])->name('donatur.destroy');
        });

        Route::group(['prefix' => 'akun', 'middleware' => ['checkRole:SUPERADMIN,BENDAHARA_SEKOLAH']], function() {
            Route::get('/', [AkunController::class, 'index'])->name('akun.index');
            Route::post('/create', [AkunController::class, 'store'])->name('akun.store');
            Route::patch('/{akun}/update', [AkunController::class, 'update'])->name('akun.update');
            Route::get('/{akun}/delete', [AkunController::class, 'destroy'])->name('akun.destroy');
        });

        Route::group(['prefix' => 'setakun', 'middleware' => ['checkRole:SUPERADMIN,BENDAHARA_SEKOLAH']], function() {
            Route::get('/', [SetAkunController::class, 'index'])->name('setakun.index');
            Route::post('/create', [SetAkunController::class, 'store'])->name('setakun.store');
            Route::patch('/{setakun}/update', [SetAkunController::class, 'update'])->name('setakun.update');
            Route::get('/{setakun}/delete', [SetAkunController::class, 'destroy'])->name('setakun.destroy');
        });

        Route::group(['prefix' => 'kenaikan', 'middleware' => ['checkRole:SUPERADMIN']], function() {
            Route::get('/', [KenaikanController::class, 'index'])->name('kenaikan.index');
            Route::get('/create', [KenaikanController::class, 'create'])->name('kenaikan.create');
            Route::post('/create', [KenaikanController::class, 'store'])->name('kenaikan.store');
            Route::get('/{kenaikan}/edit', [KenaikanController::class, 'edit'])->name('kenaikan.edit');
            Route::get('/{kenaikan}/show', [KenaikanController::class, 'show'])->name('kenaikan.show');
            Route::patch('/{kenaikan}/update', [KenaikanController::class, 'update'])->name('kenaikan.update');
            Route::get('/{kenaikan}/delete', [KenaikanController::class, 'destroy'])->name('kenaikan.destroy');
        });
    
        Route::group(['prefix' => 'kelulusan', 'middleware' => ['checkRole:SUPERADMIN']], function() {
            Route::get('/', [KelulusanController::class, 'index'])->name('kelulusan.index');
            Route::get('/create', [KelulusanController::class, 'create'])->name('kelulusan.create');
            Route::post('/create', [KelulusanController::class, 'store'])->name('kelulusan.store');
            Route::get('/{kelulusan}/edit', [KelulusanController::class, 'edit'])->name('kelulusan.edit');
            Route::get('/{kelulusan}/show', [KelulusanController::class, 'show'])->name('kelulusan.show');
            Route::patch('/{kelulusan}/update', [KelulusanController::class, 'update'])->name('kelulusan.update');
            Route::get('/{kelulusan}/delete', [KelulusanController::class, 'destroy'])->name('kelulusan.destroy');
        });

        Route::group(['prefix' => 'pegawai', 'middleware' => ['checkRole:SUPERADMIN,BENDAHARA_SEKOLAH']], function() {
            Route::get('/', [PegawaiController::class, 'index'])->name('pegawai.index');
            Route::get('/create', [PegawaiController::class, 'create'])->name('pegawai.create');
            Route::post('/create', [PegawaiController::class, 'store'])->name('pegawai.store');
            Route::get('/{pegawai}/edit', [PegawaiController::class, 'edit'])->name('pegawai.edit');
            Route::get('/{pegawai}/show', [PegawaiController::class, 'show'])->name('pegawai.show');
            Route::patch('/{pegawai}/update', [PegawaiController::class, 'update'])->name('pegawai.update');
            Route::get('/{pegawai}/delete', [PegawaiController::class, 'destroy'])->name('pegawai.destroy');
        });

        Route::group(['prefix' => 'tagihan_siswa', 'middleware' => ['checkRole:SUPERADMIN,BENDAHARA_SEKOLAH']], function() {
            Route::get('/', [TagihanSiswaController::class, 'index'])->name('tagihan_siswa.index');
            Route::get('/create', [TagihanSiswaController::class, 'create'])->name('tagihan_siswa.create');
            Route::post('/create', [TagihanSiswaController::class, 'store'])->name('tagihan_siswa.store');
            Route::get('/{tagihan_siswa}/edit', [TagihanSiswaController::class, 'edit'])->name('tagihan_siswa.edit');
            Route::get('/{tagihan_siswa}/show', [TagihanSiswaController::class, 'show'])->name('tagihan_siswa.show');
            Route::patch('/{tagihan_siswa}/update', [TagihanSiswaController::class, 'update'])->name('tagihan_siswa.update');
            Route::get('/{tagihan_siswa}/delete', [TagihanSiswaController::class, 'destroy'])->name('tagihan_siswa.destroy');
        });

        Route::group(['prefix' => 'pembayaran_siswa', 'middleware' => ['checkRole:SUPERADMIN,BENDAHARA_SEKOLAH']], function() {
            Route::get('/daftar', [PembayaranSiswaController::class, 'daftar'])->name('pembayaran_siswa.daftar');
            Route::get('/{kelas}', [PembayaranSiswaController::class, 'index'])->name('pembayaran_siswa.index');
            Route::get('/create/{kelas}', [PembayaranSiswaController::class, 'create'])->name('pembayaran_siswa.create');
            Route::post('/create', [PembayaranSiswaController::class, 'store'])->name('pembayaran_siswa.store');
            Route::get('/{pembayaran_siswa}/edit', [PembayaranSiswaController::class, 'edit'])->name('pembayaran_siswa.edit');
            Route::get('/{pembayaran_siswa}/show', [PembayaranSiswaController::class, 'show'])->name('pembayaran_siswa.show');
            Route::patch('/{pembayaran_siswa}/update', [PembayaranSiswaController::class, 'update'])->name('pembayaran_siswa.update');
            Route::get('/{pembayaran_siswa}/delete', [PembayaranSiswaController::class, 'destroy'])->name('pembayaran_siswa.destroy');
        });
            
        Route::group(['prefix' => 'pemasukan_lainnya', 'middleware' => ['checkRole:SUPERADMIN']], function() {
            Route::get('/', [PemasukanLainnyaController::class, 'index'])->name('pemasukan_lainnya.index');
            Route::get('/create', [PemasukanLainnyaController::class, 'create'])->name('pemasukan_lainnya.create');
            Route::post('/create', [PemasukanLainnyaController::class, 'store'])->name('pemasukan_lainnya.store');
            Route::get('/{pemasukan_lainnya}/edit', [PemasukanLainnyaController::class, 'edit'])->name('pemasukan_lainnya.edit');
            Route::get('/{pemasukan_lainnya}/show', [PemasukanLainnyaController::class, 'show'])->name('pemasukan_lainnya.show');
            Route::patch('/{pemasukan_lainnya}/update', [PemasukanLainnyaController::class, 'update'])->name('pemasukan_lainnya.update');
            Route::get('/{pemasukan_lainnya}/delete', [PemasukanLainnyaController::class, 'destroy'])->name('pemasukan_lainnya.destroy');
        });
            
        Route::group(['prefix' => 'presensi', 'middleware' => ['checkRole:SUPERADMIN']], function() {
            Route::get('/', [PresensiKaryawanController::class, 'index'])->name('presensi.index');
            Route::get('/create', [PresensiKaryawanController::class, 'create'])->name('presensi.create');
            Route::post('/create', [PresensiKaryawanController::class, 'store'])->name('presensi.store');
            Route::get('/{presensi}/edit', [PresensiKaryawanController::class, 'edit'])->name('presensi.edit');
            Route::get('/{presensi}/show', [PresensiKaryawanController::class, 'show'])->name('presensi.show');
            Route::patch('/{presensi}/update', [PresensiKaryawanController::class, 'update'])->name('presensi.update');
            Route::get('/{presensi}/delete', [PresensiKaryawanController::class, 'destroy'])->name('presensi.destroy');
        });
            
        Route::group(['prefix' => 'penggajian', 'middleware' => ['checkRole:SUPERADMIN']], function() {
            Route::get('/', [PenggajianController::class, 'index'])->name('penggajian.index');
            Route::get('/create', [PenggajianController::class, 'create'])->name('penggajian.create');
            Route::post('/create', [PenggajianController::class, 'store'])->name('penggajian.store');
            Route::get('/{penggajian}/edit', [PenggajianController::class, 'edit'])->name('penggajian.edit');
            Route::get('/{penggajian}/show', [PenggajianController::class, 'show'])->name('penggajian.show');
            Route::patch('/{penggajian}/update', [PenggajianController::class, 'update'])->name('penggajian.update');
            Route::get('/{penggajian}/delete', [PenggajianController::class, 'destroy'])->name('penggajian.destroy');
        });

        Route::group(['prefix' => 'pengeluaran_lainnya', 'middleware' => ['checkRole:SUPERADMIN']], function() {
            Route::get('/', [PengeluaranLainnyaController::class, 'index'])->name('pengeluaran_lainnya.index');
            Route::get('/create', [PengeluaranLainnyaController::class, 'create'])->name('pengeluaran_lainnya.create');
            Route::post('/create', [PengeluaranLainnyaController::class, 'store'])->name('pengeluaran_lainnya.store');
            Route::get('/{pengeluaran_lainnya}/edit/{id}', [PengeluaranLainnyaController::class, 'edit'])->name('pengeluaran_lainnya.edit');
            Route::get('/{pengeluaran_lainnya}/show/{id}', [PengeluaranLainnyaController::class, 'show'])->name('pengeluaran_lainnya.show');
            Route::patch('/{pengeluaran_lainnya}/update/{id}', [PengeluaranLainnyaController::class, 'update'])->name('pengeluaran_lainnya.update');
            Route::get('/{pengeluaran_lainnya}/delete/{id}', [PengeluaranLainnyaController::class, 'destroy'])->name('pengeluaran_lainnya.destroy');
            Route::get('/getData', [PengeluaranLainnyaController::class, 'getData'])->name('pengeluaran_lainnya.getData');
        });

        Route::group(['prefix' => 'jurnal', 'middleware' => ['checkRole:SUPERADMIN']], function() {
            Route::get('/', [JurnalController::class, 'index'])->name('jurnal.index');
            Route::get('/{jurnal}/edit', [JurnalController::class, 'edit'])->name('jurnal.edit');
            Route::get('/{jurnal}/show', [JurnalController::class, 'show'])->name('jurnal.show');
            Route::patch('/{jurnal}/update', [JurnalController::class, 'update'])->name('jurnal.update');
        });
    });
    // end new route
    
    Route::get('/datasiswa/{nis_siswa}', [SiswaController::class, 'datasiswa']);
});
