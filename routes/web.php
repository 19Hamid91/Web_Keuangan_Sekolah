<?php

use App\Http\Controllers\AkunController;
use App\Http\Controllers\AsetController;
use App\Http\Controllers\AtkController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\BiroController;
use App\Http\Controllers\BukuBesarController;
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
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\NeracaController;
use App\Http\Controllers\PemasukanLainnyaController;
use App\Http\Controllers\PemasukanYayasanController;
use App\Http\Controllers\PembayaranSiswaController;
use App\Http\Controllers\PembelianAsetController;
use App\Http\Controllers\PembelianAtkController;
use App\Http\Controllers\PengeluaranLainnyaController;
use App\Http\Controllers\PenggajianController;
use App\Http\Controllers\PengurusController;
use App\Http\Controllers\PenyewaKantinController;
use App\Http\Controllers\PresensiKaryawanController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TagihanSiswaController;
use App\Http\Controllers\TeknisiController;
use App\Http\Controllers\UtilitasController;

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

Route::group(['middleware' => ['auth','prevent.multiple.logins']], function() {
    // start new route
    Route::get('/pilih-instansi', [AuthController::class, 'pilih_instansi']);
    Route::get('findKaryawan', [PegawaiController::class, 'findKaryawan'])->name('findKaryawan');
    Route::get('/datakelas/{sekolah_id}', [KelasController::class, 'datakelas']);
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/email', [TagihanSiswaController::class, 'email'])->name('tagihan_siswa.email');
    
    Route::group(['prefix' => '{instansi}', 'middleware' => 'checkInstansi'], function() {
        Route::get('/notification', [AuthController::class, 'notification'])->name('notification');
        Route::get('profile', [AuthController::class, 'profile'])->name('profile');
        Route::post('profile', [AuthController::class, 'profile_update'])->name('profile.update');
        Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

        Route::group(['prefix' => 'user'], function() {
            Route::get('/',  [UserController::class, 'index'])->name('user.index')->middleware('checkRole:ADMIN,KEPALA SEKOLAH,KEPALA YAYASAN');
            Route::post('/create',[UserController::class, 'store'])->name('user.store')->middleware('checkRole:ADMIN');
            Route::patch('/{user}/update', [UserController::class, 'update'])->name('user.update')->middleware('checkRole:ADMIN');
            Route::get('/{user}/delete', [UserController::class, 'destroy'])->name('user.destroy')->middleware('checkRole:ADMIN');
        });

        Route::group(['prefix' => 'instansi'], function() {
            Route::get('/', [InstansiController::class, 'index'])->name('instansi.index')->middleware('checkRole:ADMIN,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::post('/create', [InstansiController::class, 'store'])->name('instansi.store')->middleware('checkRole:ADMIN');
            Route::patch('/{id}/update', [InstansiController::class, 'update'])->name('instansi.update')->middleware('checkRole:ADMIN');
            Route::get('/{id}/delete', [InstansiController::class, 'destroy'])->name('instansi.destroy')->middleware('checkRole:ADMIN');
        });
    
        Route::group(['prefix' => 'kelas'], function() {
            Route::get('/', [KelasController::class, 'index'])->name('kelas.index')->middleware('checkRole:TU,KEPALA SEKOLAH,KEPALA YAYASAN');
            Route::post('/create', [KelasController::class, 'store'])->name('kelas.store')->middleware('checkRole:TU');
            Route::patch('/{id}/update', [KelasController::class, 'update'])->name('kelas.update')->middleware('checkRole:TU');
            Route::get('/{id}/delete', [KelasController::class, 'destroy'])->name('kelas.destroy')->middleware('checkRole:TU');
        });

        Route::group(['prefix' => 'tahun_ajaran'], function() {
            Route::get('/', [TahunAjaranController::class, 'index'])->name('tahun_ajaran.index')->middleware('checkRole:TU,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::post('/create', [TahunAjaranController::class, 'store'])->name('tahun_ajaran.store')->middleware('checkRole:TU');
            Route::patch('/{tahun_ajaran}/update', [TahunAjaranController::class, 'update'])->name('tahun_ajaran.update')->middleware('checkRole:TU');
            Route::get('/{tahun_ajaran}/delete', [TahunAjaranController::class, 'destroy'])->name('tahun_ajaran.destroy')->middleware('checkRole:TU');
        });

        Route::group(['prefix' => 'supplier'], function() {
            Route::get('/', [SupplierController::class, 'index'])->name('supplier.index')->middleware('checkRole:TU,BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::post('/create', [SupplierController::class, 'store'])->name('supplier.store')->middleware('checkRole:TU,BENDAHARA');
            Route::patch('/{id}/update', [SupplierController::class, 'update'])->name('supplier.update')->middleware('checkRole:TU,BENDAHARA');
            Route::get('/{id}/delete', [SupplierController::class, 'destroy'])->name('supplier.destroy')->middleware('checkRole:TU,BENDAHARA');
        });

        Route::group(['prefix' => 'aset'], function() {
            Route::get('/', [AsetController::class, 'index'])->name('aset.index')->middleware('checkRole:TU,BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::post('/create', [AsetController::class, 'store'])->name('aset.store')->middleware('checkRole:TU,BENDAHARA');
            Route::patch('/{aset}/update', [AsetController::class, 'update'])->name('aset.update')->middleware('checkRole:TU,BENDAHARA');
            Route::get('/{aset}/delete', [AsetController::class, 'destroy'])->name('aset.destroy')->middleware('checkRole:TU,BENDAHARA');
        });

        Route::group(['prefix' => 'atk'], function() {
            Route::get('/', [AtkController::class, 'index'])->name('atk.index')->middleware('checkRole:TU,BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::post('/create', [AtkController::class, 'store'])->name('atk.store')->middleware('checkRole:TU,BENDAHARA');
            Route::patch('/{atk}/update', [AtkController::class, 'update'])->name('atk.update')->middleware('checkRole:TU,BENDAHARA');
            Route::get('/{atk}/delete', [AtkController::class, 'destroy'])->name('atk.destroy')->middleware('checkRole:TU,BENDAHARA');
        });

        Route::group(['prefix' => 'siswa'], function() {
            Route::get('/', [SiswaController::class, 'index'])->name('siswa.index')->middleware('checkRole:TU,KEPALA SEKOLAH,KEPALA YAYASAN');
            Route::get('/create', [SiswaController::class, 'create'])->name('siswa.create')->middleware('checkRole:TU');
            Route::post('/create', [SiswaController::class, 'store'])->name('siswa.store')->middleware('checkRole:TU');
            Route::get('/{siswa}/edit', [SiswaController::class, 'edit'])->name('siswa.edit')->middleware('checkRole:TU');
            Route::get('/{siswa}/show', [SiswaController::class, 'show'])->name('siswa.show')->middleware('checkRole:TU');
            Route::patch('/{siswa}/update', [SiswaController::class, 'update'])->name('siswa.update')->middleware('checkRole:TU');
            Route::get('/{siswa}/delete', [SiswaController::class, 'destroy'])->name('siswa.destroy')->middleware('checkRole:TU');
            Route::get('/template', [SiswaController::class, 'downloadTemplate'])->name('siswa.downloadTemplate')->middleware('checkRole:TU');
            Route::post('/import', [SiswaController::class, 'import'])->name('siswa.import')->middleware('checkRole:TU');
        });

        Route::group(['prefix' => 'pembelian-aset'], function() {
            Route::get('/', [PembelianAsetController::class, 'index'])->name('pembelian-aset.index')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::get('/create', [PembelianAsetController::class, 'create'])->name('pembelian-aset.create')->middleware('checkRole:BENDAHARA');
            Route::post('/create', [PembelianAsetController::class, 'store'])->name('pembelian-aset.store')->middleware('checkRole:BENDAHARA');
            Route::get('/{id}/edit', [PembelianAsetController::class, 'edit'])->name('pembelian-aset.edit')->middleware('checkRole:BENDAHARA');
            Route::get('/{id}/show', [PembelianAsetController::class, 'show'])->name('pembelian-aset.show')->middleware('checkRole:BENDAHARA');
            Route::patch('/{id}/update', [PembelianAsetController::class, 'update'])->name('pembelian-aset.update')->middleware('checkRole:BENDAHARA');
            Route::get('/{id}/delete', [PembelianAsetController::class, 'destroy'])->name('pembelian-aset.destroy')->middleware('checkRole:BENDAHARA');
            Route::get('/{id}/cetak', [PembelianAsetController::class, 'cetak'])->name('pembelian-aset.cetak')->middleware('checkRole:BENDAHARA');
        });

        Route::group(['prefix' => 'pembelian-atk'], function() {
            Route::get('/', [PembelianAtkController::class, 'index'])->name('pembelian-atk.index')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::get('/create', [PembelianAtkController::class, 'create'])->name('pembelian-atk.create')->middleware('checkRole:BENDAHARA');
            Route::post('/create', [PembelianAtkController::class, 'store'])->name('pembelian-atk.store')->middleware('checkRole:BENDAHARA');
            Route::get('/{id}/edit', [PembelianAtkController::class, 'edit'])->name('pembelian-atk.edit')->middleware('checkRole:BENDAHARA');
            Route::get('/{id}/show', [PembelianAtkController::class, 'show'])->name('pembelian-atk.show')->middleware('checkRole:BENDAHARA');
            Route::patch('/{id}/update', [PembelianAtkController::class, 'update'])->name('pembelian-atk.update')->middleware('checkRole:BENDAHARA');
            Route::get('/{id}/delete', [PembelianAtkController::class, 'destroy'])->name('pembelian-atk.destroy')->middleware('checkRole:BENDAHARA');
            Route::get('/{id}/cetak', [PembelianAtkController::class, 'cetak'])->name('pembelian-atk.cetak')->middleware('checkRole:BENDAHARA');
        });

        Route::group(['prefix' => 'kartu-stok'], function() {
            Route::get('/getNominal', [KartuStokController::class, 'getNominal'])->name('kartu-stok.getNominal')->middleware('checkRole:TU,SARPRAS YAYASAN');
            Route::get('/', [KartuStokController::class, 'index'])->name('kartu-stok.index')->middleware('checkRole:TU,SARPRAS YAYASAN,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS,BENDAHARA');
            Route::get('/create', [KartuStokController::class, 'create'])->name('kartu-stok.create')->middleware('checkRole:TU,SARPRAS YAYASAN');
            Route::post('/create', [KartuStokController::class, 'store'])->name('kartu-stok.store')->middleware('checkRole:TU,SARPRAS YAYASAN');
            Route::get('/{id}/edit', [KartuStokController::class, 'edit'])->name('kartu-stok.edit')->middleware('checkRole:TU,SARPRAS YAYASAN');
            Route::get('/{id}/show', [KartuStokController::class, 'show'])->name('kartu-stok.show')->middleware('checkRole:TU,SARPRAS YAYASAN');
            Route::patch('/{id}/update', [KartuStokController::class, 'update'])->name('kartu-stok.update')->middleware('checkRole:TU,SARPRAS YAYASAN');
            Route::get('/{id}/delete', [KartuStokController::class, 'destroy'])->name('kartu-stok.destroy')->middleware('checkRole:TU,SARPRAS YAYASAN');
            Route::get('/jurnal', [KartuStokController::class, 'jurnal'])->name('kartu-stok.jurnal')->middleware('checkRole:TU,SARPRAS YAYASAN');
        });

        Route::group(['prefix' => 'kartu-penyusutan'], function() {
            Route::get('/save', [KartuPenyusutanController::class, 'save'])->name('kartu-penyusutan.save')->middleware('checkRole:TU,BENDAHARA');
            Route::get('/', [KartuPenyusutanController::class, 'index'])->name('kartu-penyusutan.index')->middleware('checkRole:TU,BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::get('/create', [KartuPenyusutanController::class, 'create'])->name('kartu-penyusutan.create')->middleware('checkRole:TU,BENDAHARA');
            Route::post('/create', [KartuPenyusutanController::class, 'store'])->name('kartu-penyusutan.store')->middleware('checkRole:TU,BENDAHARA');
            Route::get('/{id}/edit', [KartuPenyusutanController::class, 'edit'])->name('kartu-penyusutan.edit')->middleware('checkRole:TU,BENDAHARA');
            Route::get('/{id}/show', [KartuPenyusutanController::class, 'show'])->name('kartu-penyusutan.show')->middleware('checkRole:TU,BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::patch('/{id}/update', [KartuPenyusutanController::class, 'update'])->name('kartu-penyusutan.update')->middleware('checkRole:TU,BENDAHARA');
            Route::get('/{id}/delete', [KartuPenyusutanController::class, 'destroy'])->name('kartu-penyusutan.destroy')->middleware('checkRole:TU,BENDAHARA');
            Route::post('/jurnal', [KartuPenyusutanController::class, 'jurnal'])->name('kartu-penyusutan.jurnal')->middleware('checkRole:TU,BENDAHARA');
            Route::get('/cetak', [KartuPenyusutanController::class, 'cetak'])->name('kartu-penyusutan.cetak')->middleware('checkRole:TU,BENDAHARA');
        });

        Route::group(['prefix' => 'jabatan'], function() {
            Route::get('/', [JabatanController::class, 'index'])->name('jabatan.index')->middleware('checkRole:TU,BENDAHARA,KEPALA SEKOLAH');
            Route::post('/create', [JabatanController::class, 'store'])->name('jabatan.store')->middleware('checkRole:TU,BENDAHARA');
            Route::patch('/{jabatan}/update', [JabatanController::class, 'update'])->name('jabatan.update')->middleware('checkRole:TU,BENDAHARA');
            Route::get('/{jabatan}/delete', [JabatanController::class, 'destroy'])->name('jabatan.destroy')->middleware('checkRole:TU,BENDAHARA');
        });

        Route::group(['prefix' => 'teknisi'], function() {
            Route::get('/', [TeknisiController::class, 'index'])->name('teknisi.index')->middleware('checkRole:TU,BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::post('/create', [TeknisiController::class, 'store'])->name('teknisi.store')->middleware('checkRole:TU,BENDAHARA');
            Route::patch('/{teknisi}/update', [TeknisiController::class, 'update'])->name('teknisi.update')->middleware('checkRole:TU,BENDAHARA');
            Route::get('/{teknisi}/delete', [TeknisiController::class, 'destroy'])->name('teknisi.destroy')->middleware('checkRole:TU,BENDAHARA');
        });

        Route::group(['prefix' => 'penyewa_kantin'], function() {
            Route::get('/', [PenyewaKantinController::class, 'index'])->name('penyewa_kantin.index')->middleware('checkRole:TU,BENDAHARA,KEPALA YAYASAN,SEKRETARIS');
            Route::post('/create', [PenyewaKantinController::class, 'store'])->name('penyewa_kantin.store')->middleware('checkRole:TU,BENDAHARA');
            Route::patch('/{penyewa_kantin}/update', [PenyewaKantinController::class, 'update'])->name('penyewa_kantin.update')->middleware('checkRole:TU,BENDAHARA');
            Route::get('/{penyewa_kantin}/delete', [PenyewaKantinController::class, 'destroy'])->name('penyewa_kantin.destroy')->middleware('checkRole:TU,BENDAHARA');
        });

        Route::group(['prefix' => 'utilitas'], function() {
            Route::get('/', [UtilitasController::class, 'index'])->name('utilitas.index')->middleware('checkRole:TU,BENDAHARA,KEPALA YAYASAN,SEKRETARIS');
            Route::post('/create', [UtilitasController::class, 'store'])->name('utilitas.store')->middleware('checkRole:TU,BENDAHARA');
            Route::patch('/{utilitas}/update', [UtilitasController::class, 'update'])->name('utilitas.update')->middleware('checkRole:TU,BENDAHARA');
            Route::get('/{utilitas}/delete', [UtilitasController::class, 'destroy'])->name('utilitas.destroy')->middleware('checkRole:TU,BENDAHARA');
        });

        Route::group(['prefix' => 'biro'], function() {
            Route::get('/', [BiroController::class, 'index'])->name('biro.index')->middleware('checkRole:TU,BENDAHARA,KEPALA SEKOLAH');
            Route::post('/create', [BiroController::class, 'store'])->name('biro.store')->middleware('checkRole:TU,BENDAHARA');
            Route::patch('/{biro}/update', [BiroController::class, 'update'])->name('biro.update')->middleware('checkRole:TU,BENDAHARA');
            Route::get('/{biro}/delete', [BiroController::class, 'destroy'])->name('biro.destroy')->middleware('checkRole:TU,BENDAHARA');
        });

        Route::group(['prefix' => 'donatur'], function() {
            Route::get('/', [DonaturController::class, 'index'])->name('donatur.index')->middleware('checkRole:TU,BENDAHARA,KEPALA YAYASAN,SEKRETARIS');
            Route::post('/create', [DonaturController::class, 'store'])->name('donatur.store')->middleware('checkRole:TU,BENDAHARA');
            Route::patch('/{donatur}/update', [DonaturController::class, 'update'])->name('donatur.update')->middleware('checkRole:TU,BENDAHARA');
            Route::get('/{donatur}/delete', [DonaturController::class, 'destroy'])->name('donatur.destroy')->middleware('checkRole:TU,BENDAHARA');
        });

        Route::group(['prefix' => 'akun'], function() {
            Route::get('/', [AkunController::class, 'index'])->name('akun.index')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::post('/create', [AkunController::class, 'store'])->name('akun.store')->middleware('checkRole:BENDAHARA');
            Route::patch('/{akun}/update', [AkunController::class, 'update'])->name('akun.update')->middleware('checkRole:BENDAHARA');
            Route::get('/{akun}/delete', [AkunController::class, 'destroy'])->name('akun.destroy')->middleware('checkRole:BENDAHARA');
        });

        Route::group(['prefix' => 'kenaikan'], function() {
            Route::get('/', [KenaikanController::class, 'index'])->name('kenaikan.index')->middleware('checkRole:TU,KEPALA SEKOLAH');
            Route::get('/create', [KenaikanController::class, 'create'])->name('kenaikan.create')->middleware('checkRole:TU');
            Route::post('/create', [KenaikanController::class, 'store'])->name('kenaikan.store')->middleware('checkRole:TU');
            Route::get('/{kenaikan}/edit', [KenaikanController::class, 'edit'])->name('kenaikan.edit')->middleware('checkRole:TU');
            Route::get('/{kenaikan}/show', [KenaikanController::class, 'show'])->name('kenaikan.show')->middleware('checkRole:TU');
            Route::patch('/{kenaikan}/update', [KenaikanController::class, 'update'])->name('kenaikan.update')->middleware('checkRole:TU');
            Route::get('/{kenaikan}/delete', [KenaikanController::class, 'destroy'])->name('kenaikan.destroy')->middleware('checkRole:TU');
        });
    
        Route::group(['prefix' => 'kelulusan'], function() {
            Route::get('/', [KelulusanController::class, 'index'])->name('kelulusan.index')->middleware('checkRole:TU,KEPALA SEKOLAH');
            Route::get('/create', [KelulusanController::class, 'create'])->name('kelulusan.create')->middleware('checkRole:TU');
            Route::post('/create', [KelulusanController::class, 'store'])->name('kelulusan.store')->middleware('checkRole:TU');
            Route::get('/{kelulusan}/edit', [KelulusanController::class, 'edit'])->name('kelulusan.edit')->middleware('checkRole:TU');
            Route::get('/{kelulusan}/show', [KelulusanController::class, 'show'])->name('kelulusan.show')->middleware('checkRole:TU');
            Route::patch('/{kelulusan}/update', [KelulusanController::class, 'update'])->name('kelulusan.update')->middleware('checkRole:TU');
            Route::get('/{kelulusan}/delete', [KelulusanController::class, 'destroy'])->name('kelulusan.destroy')->middleware('checkRole:TU');
        });

        Route::group(['prefix' => 'pegawai'], function() {
            Route::get('/', [PegawaiController::class, 'index'])->name('pegawai.index')->middleware('checkRole:TU,KEPALA SEKOLAH,KEPALA YAYASAN');
            Route::get('/create', [PegawaiController::class, 'create'])->name('pegawai.create')->middleware('checkRole:TU');
            Route::post('/create', [PegawaiController::class, 'store'])->name('pegawai.store')->middleware('checkRole:TU');
            Route::get('/{pegawai}/edit', [PegawaiController::class, 'edit'])->name('pegawai.edit')->middleware('checkRole:TU');
            Route::get('/{pegawai}/show', [PegawaiController::class, 'show'])->name('pegawai.show')->middleware('checkRole:TU');
            Route::patch('/{pegawai}/update', [PegawaiController::class, 'update'])->name('pegawai.update')->middleware('checkRole:TU');
            Route::get('/{pegawai}/delete', [PegawaiController::class, 'destroy'])->name('pegawai.destroy')->middleware('checkRole:TU');
        });

        Route::group(['prefix' => 'pengurus'], function() {
            Route::get('/', [PengurusController::class, 'index'])->name('pengurus.index')->middleware('checkRole:TU,BENDAHARA,KEPALA YAYASAN,SEKRETARIS');
            Route::get('/create', [PengurusController::class, 'create'])->name('pengurus.create')->middleware('checkRole:TU,BENDAHARA');
            Route::post('/create', [PengurusController::class, 'store'])->name('pengurus.store')->middleware('checkRole:TU,BENDAHARA');
            Route::get('/{pengurus}/edit', [PengurusController::class, 'edit'])->name('pengurus.edit')->middleware('checkRole:TU,BENDAHARA');
            Route::get('/{pengurus}/show', [PengurusController::class, 'show'])->name('pengurus.show')->middleware('checkRole:TU,BENDAHARA');
            Route::patch('/{pengurus}/update', [PengurusController::class, 'update'])->name('pengurus.update')->middleware('checkRole:TU,BENDAHARA');
            Route::get('/{pengurus}/delete', [PengurusController::class, 'destroy'])->name('pengurus.destroy')->middleware('checkRole:TU,BENDAHARA');
        });

        Route::group(['prefix' => 'tagihan_siswa'], function() {
            Route::get('/', [TagihanSiswaController::class, 'index'])->name('tagihan_siswa.index')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH');
            Route::get('/create', [TagihanSiswaController::class, 'create'])->name('tagihan_siswa.create')->middleware('checkRole:BENDAHARA');
            Route::post('/create', [TagihanSiswaController::class, 'store'])->name('tagihan_siswa.store')->middleware('checkRole:BENDAHARA');
            Route::get('/{tagihan_siswa}/edit', [TagihanSiswaController::class, 'edit'])->name('tagihan_siswa.edit')->middleware('checkRole:BENDAHARA');
            Route::get('/{tagihan_siswa}/show', [TagihanSiswaController::class, 'show'])->name('tagihan_siswa.show')->middleware('checkRole:BENDAHARA');
            Route::patch('/{tagihan_siswa}/update', [TagihanSiswaController::class, 'update'])->name('tagihan_siswa.update')->middleware('checkRole:BENDAHARA');
            Route::get('/{tagihan_siswa}/delete', [TagihanSiswaController::class, 'destroy'])->name('tagihan_siswa.destroy')->middleware('checkRole:BENDAHARA');
        });

        Route::group(['prefix' => 'pembayaran_siswa'], function() {
            Route::get('/getNominal', [PembayaranSiswaController::class, 'getNominal'])->name('pembayaran_siswa.getNominal')->middleware('checkRole:BENDAHARA');
            Route::get('/getTagihanSiswa', [PembayaranSiswaController::class, 'getTagihanSiswa'])->name('pembayaran_siswa.getTagihanSiswa')->middleware('checkRole:BENDAHARA');
            Route::get('/daftar', [PembayaranSiswaController::class, 'daftar'])->name('pembayaran_siswa.daftar')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH');
            Route::get('/{kelas}', [PembayaranSiswaController::class, 'index'])->name('pembayaran_siswa.index')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH');
            Route::get('/create/{kelas}', [PembayaranSiswaController::class, 'create'])->name('pembayaran_siswa.create')->middleware('checkRole:BENDAHARA');
            Route::post('/create/{kelas}', [PembayaranSiswaController::class, 'store'])->name('pembayaran_siswa.store')->middleware('checkRole:BENDAHARA');
            Route::get('/{pembayaran_siswa}/edit/{kelas}', [PembayaranSiswaController::class, 'edit'])->name('pembayaran_siswa.edit')->middleware('checkRole:BENDAHARA');
            Route::get('/{pembayaran_siswa}/show/{kelas}', [PembayaranSiswaController::class, 'show'])->name('pembayaran_siswa.show')->middleware('checkRole:BENDAHARA');
            Route::patch('/{pembayaran_siswa}/update/{kelas}', [PembayaranSiswaController::class, 'update'])->name('pembayaran_siswa.update')->middleware('checkRole:BENDAHARA');
            Route::get('/{pembayaran_siswa}/delete', [PembayaranSiswaController::class, 'destroy'])->name('pembayaran_siswa.destroy')->middleware('checkRole:BENDAHARA');
            Route::get('/{pembayaran_siswa}/cetak', [PembayaranSiswaController::class, 'cetak'])->name('pembayaran_siswa.cetak')->middleware('checkRole:BENDAHARA');
        });
            
        Route::group(['prefix' => 'pemasukan_lainnya'], function() {
            Route::get('/getNominal', [PemasukanLainnyaController::class, 'getNominal'])->name('pemasukan_lainnya.getNominal')->middleware('checkRole:BENDAHARA');
            Route::get('/', [PemasukanLainnyaController::class, 'index'])->name('pemasukan_lainnya.index')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::get('/create', [PemasukanLainnyaController::class, 'create'])->name('pemasukan_lainnya.create')->middleware('checkRole:BENDAHARA');
            Route::post('/create', [PemasukanLainnyaController::class, 'store'])->name('pemasukan_lainnya.store')->middleware('checkRole:BENDAHARA');
            Route::get('/{pemasukan_lainnya}/edit', [PemasukanLainnyaController::class, 'edit'])->name('pemasukan_lainnya.edit')->middleware('checkRole:BENDAHARA');
            Route::get('/{pemasukan_lainnya}/show', [PemasukanLainnyaController::class, 'show'])->name('pemasukan_lainnya.show')->middleware('checkRole:BENDAHARA');
            Route::patch('/{pemasukan_lainnya}/update', [PemasukanLainnyaController::class, 'update'])->name('pemasukan_lainnya.update')->middleware('checkRole:BENDAHARA');
            Route::get('/{pemasukan_lainnya}/delete', [PemasukanLainnyaController::class, 'destroy'])->name('pemasukan_lainnya.destroy')->middleware('checkRole:BENDAHARA');
            Route::get('/cetak/{id}', [PemasukanLainnyaController::class, 'cetak'])->name('pemasukan_lainnya.cetak')->middleware('checkRole:BENDAHARA');
        });
            
        Route::group(['prefix' => 'presensi'], function() {
            Route::get('/', [PresensiKaryawanController::class, 'index'])->name('presensi.index')->middleware('checkRole:TU,KEPALA SEKOLAH');
            Route::get('/create', [PresensiKaryawanController::class, 'create'])->name('presensi.create')->middleware('checkRole:TU');
            Route::post('/create', [PresensiKaryawanController::class, 'store'])->name('presensi.store')->middleware('checkRole:TU');
            Route::get('/{presensi}/edit', [PresensiKaryawanController::class, 'edit'])->name('presensi.edit')->middleware('checkRole:TU');
            Route::get('/{presensi}/show', [PresensiKaryawanController::class, 'show'])->name('presensi.show')->middleware('checkRole:TU');
            Route::patch('/{presensi}/update', [PresensiKaryawanController::class, 'update'])->name('presensi.update')->middleware('checkRole:TU');
            Route::get('/{presensi}/delete', [PresensiKaryawanController::class, 'destroy'])->name('presensi.destroy')->middleware('checkRole:TU');
        });
            
        Route::group(['prefix' => 'penggajian'], function() {
            Route::get('/getNominal', [PenggajianController::class, 'getNominal'])->name('penggajian.getNominal')->middleware('checkRole:TU,BENDAHARA');
            Route::get('/', [PenggajianController::class, 'index'])->name('penggajian.index')->middleware('checkRole:TU,BENDAHARA,KEPALA SEKOLAH');
            Route::get('/create', [PenggajianController::class, 'create'])->name('penggajian.create')->middleware('checkRole:TU,BENDAHARA');
            Route::post('/create', [PenggajianController::class, 'store'])->name('penggajian.store')->middleware('checkRole:TU,BENDAHARA');
            Route::get('/{penggajian}/edit', [PenggajianController::class, 'edit'])->name('penggajian.edit')->middleware('checkRole:TU,BENDAHARA');
            Route::get('/{penggajian}/show', [PenggajianController::class, 'show'])->name('penggajian.show')->middleware('checkRole:TU,BENDAHARA');
            Route::patch('/{penggajian}/update', [PenggajianController::class, 'update'])->name('penggajian.update')->middleware('checkRole:TU,BENDAHARA');
            Route::get('/{penggajian}/delete', [PenggajianController::class, 'destroy'])->name('penggajian.destroy')->middleware('checkRole:TU,BENDAHARA');
            Route::get('/{penggajian}/cetak', [PenggajianController::class, 'cetak'])->name('penggajian.cetak')->middleware('checkRole:TU,BENDAHARA');
        });

        Route::group(['prefix' => 'pengeluaran_lainnya'], function() {
            Route::get('/getNominal', [PengeluaranLainnyaController::class, 'getNominal'])->name('pengeluaran_lainnya.getNominal')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::get('/', [PengeluaranLainnyaController::class, 'index'])->name('pengeluaran_lainnya.index')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::get('/create', [PengeluaranLainnyaController::class, 'create'])->name('pengeluaran_lainnya.create')->middleware('checkRole:BENDAHARA');
            Route::post('/create', [PengeluaranLainnyaController::class, 'store'])->name('pengeluaran_lainnya.store')->middleware('checkRole:BENDAHARA');
            Route::get('/{pengeluaran_lainnya}/edit/{id}', [PengeluaranLainnyaController::class, 'edit'])->name('pengeluaran_lainnya.edit')->middleware('checkRole:BENDAHARA');
            Route::get('/{pengeluaran_lainnya}/show/{id}', [PengeluaranLainnyaController::class, 'show'])->name('pengeluaran_lainnya.show')->middleware('checkRole:BENDAHARA');
            Route::patch('/{pengeluaran_lainnya}/update/{id}', [PengeluaranLainnyaController::class, 'update'])->name('pengeluaran_lainnya.update')->middleware('checkRole:BENDAHARA');
            Route::get('/{pengeluaran_lainnya}/delete/{id}', [PengeluaranLainnyaController::class, 'destroy'])->name('pengeluaran_lainnya.destroy')->middleware('checkRole:BENDAHARA');
            Route::get('/getData', [PengeluaranLainnyaController::class, 'getData'])->name('pengeluaran_lainnya.getData')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::get('/{pengeluaran_lainnya}/cetak/{id}', [PengeluaranLainnyaController::class, 'cetak'])->name('pengeluaran_lainnya.cetak')->middleware('checkRole:BENDAHARA');
        });

        Route::group(['prefix' => 'jurnal'], function() {
            Route::get('/', [JurnalController::class, 'index'])->name('jurnal.index')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::post('/create', [JurnalController::class, 'store'])->name('jurnal.store')->middleware('checkRole:BENDAHARA,TU,SARPRAS YAYASAN');
            Route::get('/{jurnal}/edit', [JurnalController::class, 'edit'])->name('jurnal.edit')->middleware('checkRole:BENDAHARA');
            Route::get('/{jurnal}/show', [JurnalController::class, 'show'])->name('jurnal.show')->middleware('checkRole:BENDAHARA');
            Route::patch('/{jurnal}/update', [JurnalController::class, 'update'])->name('jurnal.update')->middleware('checkRole:BENDAHARA');
            Route::get('/{jurnal}/delete', [JurnalController::class, 'destroy'])->name('jurnal.destroy')->middleware('checkRole:BENDAHARA');
            Route::post('/save', [JurnalController::class, 'save'])->name('jurnal.save')->middleware('checkRole:BENDAHARA');
            Route::get('/excel', [JurnalController::class, 'excel'])->name('jurnal.excel')->middleware('checkRole:BENDAHARA');
            Route::get('/pdf', [JurnalController::class, 'pdf'])->name('jurnal.pdf')->middleware('checkRole:BENDAHARA');
        });

        Route::group(['prefix' => 'bukubesar'], function() {
            Route::get('/', [BukuBesarController::class, 'index'])->name('bukubesar.index')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::get('/{bukubesar}/edit', [BukuBesarController::class, 'edit'])->name('bukubesar.edit')->middleware('checkRole:BENDAHARA');
            Route::get('/{bukubesar}/show', [BukuBesarController::class, 'show'])->name('bukubesar.show')->middleware('checkRole:BENDAHARA');
            Route::patch('/{bukubesar}/update', [BukuBesarController::class, 'update'])->name('bukubesar.update')->middleware('checkRole:BENDAHARA');
            Route::post('/save', [BukuBesarController::class, 'save'])->name('bukubesar.save')->middleware('checkRole:BENDAHARA');
            Route::get('/excel', [BukuBesarController::class, 'excel'])->name('bukubesar.excel')->middleware('checkRole:BENDAHARA');
            Route::get('/pdf', [BukuBesarController::class, 'pdf'])->name('bukubesar.pdf')->middleware('checkRole:BENDAHARA');
        });

        Route::group(['prefix' => 'pemasukan_yayasan'], function() {
            Route::get('/', [PemasukanYayasanController::class, 'index'])->name('pemasukan_yayasan.index')->middleware('checkRole:BENDAHARA,KEPALA YAYASAN,SEKRETARIS');
            Route::get('/create', [PemasukanYayasanController::class, 'create'])->name('pemasukan_yayasan.create')->middleware('checkRole:BENDAHARA');
            Route::post('/create', [PemasukanYayasanController::class, 'store'])->name('pemasukan_yayasan.store')->middleware('checkRole:BENDAHARA');
            Route::get('/{pemasukan_yayasan}/edit', [PemasukanYayasanController::class, 'edit'])->name('pemasukan_yayasan.edit')->middleware('checkRole:BENDAHARA');
            Route::get('/{pemasukan_yayasan}/show', [PemasukanYayasanController::class, 'show'])->name('pemasukan_yayasan.show')->middleware('checkRole:BENDAHARA');
            Route::patch('/{pemasukan_yayasan}/update', [PemasukanYayasanController::class, 'update'])->name('pemasukan_yayasan.update')->middleware('checkRole:BENDAHARA');
            Route::get('/{pemasukan_yayasan}/delete', [PemasukanYayasanController::class, 'destroy'])->name('pemasukan_yayasan.destroy')->middleware('checkRole:BENDAHARA');
            Route::post('/save', [PemasukanYayasanController::class, 'save'])->name('pemasukan_yayasan.save')->middleware('checkRole:BENDAHARA');
            Route::get('/excel', [PemasukanYayasanController::class, 'excel'])->name('pemasukan_yayasan.excel')->middleware('checkRole:BENDAHARA');
            Route::get('/{pemasukan_yayasan}/cetak', [PemasukanYayasanController::class, 'cetak'])->name('pemasukan_yayasan.cetak')->middleware('checkRole:BENDAHARA');
        });

        Route::group(['prefix' => 'log'], function() {
            Route::get('/', [AuthController::class, 'index_log'])->name('log.index')->middleware('checkRole:ADMIN,KEPALA SEKOLAH,KEPALA YAYASAN');
            Route::get('/{log}/show', [AuthController::class, 'show_log'])->name('log.show')->middleware('checkRole:ADMIN,KEPALA SEKOLAH,KEPALA YAYASAN');
        });

        Route::group(['prefix' => 'backup'], function() {
            Route::get('/', [BackupController::class, 'index'])->name('backup.index')->middleware('checkRole:ADMIN,KEPALA SEKOLAH,KEPALA YAYASAN');
            Route::get('/run', [BackupController::class, 'run'])->name('backup.run')->middleware('checkRole:ADMIN');
            Route::get('/list', [BackupController::class, 'list'])->name('backup.list')->middleware('checkRole:ADMIN,KEPALA SEKOLAH,KEPALA YAYASAN');
            Route::post('/delete', [BackupController::class, 'delete'])->name('backup.delete')->middleware('checkRole:ADMIN');
        });

        Route::group(['prefix' => 'laporan_data'], function() {
            Route::get('/spp', [LaporanController::class, 'index_spp'])->name('laporan_data.spp')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::get('/print_spp', [LaporanController::class, 'print_spp'])->name('laporan_data.print_spp')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::get('/pemasukan_outbond', [LaporanController::class, 'index_pem_outbond'])->name('laporan_data.pemasukan_outbond')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::get('/print_pemasukan_outbond', [LaporanController::class, 'print_pem_outbond'])->name('laporan_data.print_pemasukan_outbond')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::get('/jpi', [LaporanController::class, 'index_jpi'])->name('laporan_data.jpi')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::get('/print_jpi', [LaporanController::class, 'print_jpi'])->name('laporan_data.print_jpi')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::get('/pemasukan_yayasan', [LaporanController::class, 'index_yayasan'])->name('laporan_data.yayasan')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::get('/print_pemasukan_yayasan', [LaporanController::class, 'print_yayasan'])->name('laporan_data.print_yayasan')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::get('/registrasi', [LaporanController::class, 'index_registrasi'])->name('laporan_data.registrasi')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::get('/print_registrasi', [LaporanController::class, 'print_registrasi'])->name('laporan_data.print_registrasi')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::get('/donasi', [LaporanController::class, 'index_donasi'])->name('laporan_data.donasi')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::get('/print_donasi', [LaporanController::class, 'print_donasi'])->name('laporan_data.print_donasi')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::get('/overtime', [LaporanController::class, 'index_overtime'])->name('laporan_data.overtime')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::get('/print_overtime', [LaporanController::class, 'print_overtime'])->name('laporan_data.print_overtime')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::get('/sewa_kantin', [LaporanController::class, 'index_sewa_kantin'])->name('laporan_data.sewa_kantin')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::get('/print_sewa_kantin', [LaporanController::class, 'print_sewa_kantin'])->name('laporan_data.print_sewa_kantin')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::get('/pemasukan_lainnya', [LaporanController::class, 'index_pemasukan_lainnya'])->name('laporan_data.pemasukan_lainnya')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::get('/pemasukan_lainnya_print', [LaporanController::class, 'print_pemasukan_lainnya'])->name('laporan_data.print_pemasukan_lainnya')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');

            Route::get('/aset', [LaporanController::class, 'index_aset'])->name('laporan_data.aset')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::get('/print_aset', [LaporanController::class, 'print_aset'])->name('laporan_data.print_aset')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::get('/atk', [LaporanController::class, 'index_atk'])->name('laporan_data.atk')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::get('/print_atk', [LaporanController::class, 'print_atk'])->name('laporan_data.print_atk')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::get('/gaji', [LaporanController::class, 'index_gaji'])->name('laporan_data.gaji')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::get('/print_gaji', [LaporanController::class, 'print_gaji'])->name('laporan_data.print_gaji')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::get('/perbaikan_aset', [LaporanController::class, 'index_perbaikan_aset'])->name('laporan_data.perbaikan_aset')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::get('/print_perbaikan_aset', [LaporanController::class, 'print_perbaikan_aset'])->name('laporan_data.print_perbaikan_aset')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::get('/operasional', [LaporanController::class, 'index_operasional'])->name('laporan_data.operasional')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::get('/print_operasional', [LaporanController::class, 'print_operasional'])->name('laporan_data.print_operasional')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::get('/outbond', [LaporanController::class, 'index_outbond'])->name('laporan_data.outbond')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::get('/print_outbond', [LaporanController::class, 'print_outbond'])->name('laporan_data.print_outbond')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::get('/pengeluaran_lainnya', [LaporanController::class, 'index_pengeluaran_lainnya'])->name('laporan_data.pengeluaran_lainnya')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::get('/pengeluaran_lainnya_print', [LaporanController::class, 'print_pengeluaran_lainnya'])->name('laporan_data.print_pengeluaran_lainnya')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
        });
        
        Route::group(['prefix' => 'neraca'], function() {
            Route::get('/', [NeracaController::class, 'index'])->name('neraca.index')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::get('/excel', [NeracaController::class, 'excel'])->name('neraca.excel')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::get('/pdf', [NeracaController::class, 'pdf'])->name('neraca.pdf')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
        });
        
        Route::group(['prefix' => 'komprehensif'], function() {
            Route::get('/', [LaporanController::class, 'index_komprehensif'])->name('komprehensif.index')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::get('/excel', [LaporanController::class, 'excel_komprehensif'])->name('komprehensif.excel')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::get('/pdf', [LaporanController::class, 'pdf_komprehensif'])->name('komprehensif.pdf')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
        });
        
        Route::group(['prefix' => 'posisi'], function() {
            Route::get('/', [LaporanController::class, 'index_posisi'])->name('posisi.index')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::get('/excel', [LaporanController::class, 'excel_posisi'])->name('posisi.excel')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::get('/pdf', [LaporanController::class, 'pdf_posisi'])->name('posisi.pdf')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
        });
        
        Route::group(['prefix' => 'aset_netto'], function() {
            Route::get('/', [LaporanController::class, 'index_aset_netto'])->name('aset_netto.index')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::get('/excel', [LaporanController::class, 'excel_aset_netto'])->name('aset_netto.excel')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::get('/pdf', [LaporanController::class, 'pdf_aset_netto'])->name('aset_netto.pdf')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
        });
        
        Route::group(['prefix' => 'arus_kas'], function() {
            Route::get('/', [LaporanController::class, 'index_arus_kas'])->name('arus_kas.index')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::get('/excel', [LaporanController::class, 'excel_arus_kas'])->name('arus_kas.excel')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::get('/pdf', [LaporanController::class, 'pdf_arus_kas'])->name('arus_kas.pdf')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
        });
        
        Route::group(['prefix' => 'kartu-piutang'], function() {
            Route::get('/', [PembayaranSiswaController::class, 'index_kartu_piutang'])->name('kartu_piutang.index')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::get('/excel', [PembayaranSiswaController::class, 'excel_kartu_piutang'])->name('kartu_piutang.excel')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::get('/pdf', [PembayaranSiswaController::class, 'pdf_kartu_piutang'])->name('kartu_piutang.pdf')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
        });
        
        Route::group(['prefix' => 'laporan-piutang'], function() {
            Route::get('/', [PembayaranSiswaController::class, 'index_laporan_piutang'])->name('laporan_piutang.index')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::get('/excel', [PembayaranSiswaController::class, 'excel_laporan_piutang'])->name('laporan_piutang.excel')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::get('/pdf', [PembayaranSiswaController::class, 'pdf_laporan_piutang'])->name('laporan_piutang.pdf')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
        });

        Route::group(['prefix' => 'posisi_konsolidasi'], function() {
            Route::get('/', [LaporanController::class, 'index_posisi_konsolidasi'])->name('posisi_konsolidasi.index')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::get('/excel', [LaporanController::class, 'excel_posisi_konsolidasi'])->name('posisi_konsolidasi.excel')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
            Route::get('/pdf', [LaporanController::class, 'pdf_posisi_konsolidasi'])->name('posisi_konsolidasi.pdf')->middleware('checkRole:BENDAHARA,KEPALA SEKOLAH,KEPALA YAYASAN,SEKRETARIS');
        });
    });
    // end new route
    
    Route::get('/datasiswa/{nis_siswa}', [SiswaController::class, 'datasiswa']);
});
