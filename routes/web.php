<?php

use App\Http\Controllers\AkunController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TahunAjaranController;

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
    Route::get('/datakelas/{kode_sekolah}', [KelasController::class, 'datakelas']);
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    Route::group(['prefix' => 'users'], function() {
        Route::get('/', 'UsersController@index')->name('users.index');
        Route::post('/create', 'UsersController@store')->name('users.store');
        Route::patch('/{user}/update', 'UsersController@update')->name('users.update');
        Route::get('/{user}/delete', 'UsersController@destroy')->name('users.destroy');
    });

    Route::group(['prefix' => 'sekolah'], function() {
        Route::get('/', [SekolahController::class, 'index'])->name('sekolah.index');
        Route::post('/create', [SekolahController::class, 'store'])->name('sekolah.store');
        Route::patch('/{sekolah}/update', [SekolahController::class, 'update'])->name('sekolah.update');
        Route::get('/{sekolah}/delete', [SekolahController::class, 'destroy'])->name('sekolah.destroy');
    });

    Route::group(['prefix' => 'kelas'], function() {
        Route::get('/', [KelasController::class, 'index'])->name('kelas.index');
        Route::post('/create', [KelasController::class, 'store'])->name('kelas.store');
        Route::patch('/{kelas}/update', [KelasController::class, 'update'])->name('kelas.update');
        Route::get('/{kelas}/delete', [KelasController::class, 'destroy'])->name('kelas.destroy');
    });

    Route::group(['prefix' => 'tahun_ajaran'], function() {
        Route::get('/', [TahunAjaranController::class, 'index'])->name('tahun_ajaran.index');
        Route::post('/create', [TahunAjaranController::class, 'store'])->name('tahun_ajaran.store');
        Route::patch('/{tahun_ajaran}/update', [TahunAjaranController::class, 'update'])->name('tahun_ajaran.update');
        Route::get('/{tahun_ajaran}/delete', [TahunAjaranController::class, 'destroy'])->name('tahun_ajaran.destroy');
    });

    Route::group(['prefix' => 'akun'], function() {
        Route::get('/', [AkunController::class, 'index'])->name('akun.index');
        Route::post('/create', [AkunController::class, 'store'])->name('akun.store');
        Route::patch('/{akun}/update', [AkunController::class, 'update'])->name('akun.update');
        Route::get('/{akun}/delete', [AkunController::class, 'destroy'])->name('akun.destroy');
    });

    Route::group(['prefix' => 'siswa'], function() {
        Route::get('/', [SiswaController::class, 'index'])->name('siswa.index');
        Route::get('/create', [SiswaController::class, 'create'])->name('siswa.create');
        Route::post('/create', [SiswaController::class, 'store'])->name('siswa.store');
        Route::get('/{siswa}/edit', [SiswaController::class, 'edit'])->name('siswa.edit');
        Route::get('/{siswa}/show', [SiswaController::class, 'show'])->name('siswa.show');
        Route::patch('/{siswa}/update', [SiswaController::class, 'update'])->name('siswa.update');
        Route::get('/{siswa}/delete', [SiswaController::class, 'destroy'])->name('siswa.destroy');
    });

    Route::group(['prefix' => 'pegawai'], function() {
        Route::get('/', [PegawaiController::class, 'index'])->name('pegawai.index');
        Route::get('/create', [PegawaiController::class, 'create'])->name('pegawai.create');
        Route::post('/create', [PegawaiController::class, 'store'])->name('pegawai.store');
        Route::get('/{pegawai}/edit', [PegawaiController::class, 'edit'])->name('pegawai.edit');
        Route::get('/{pegawai}/show', [PegawaiController::class, 'show'])->name('pegawai.show');
        Route::patch('/{pegawai}/update', [PegawaiController::class, 'update'])->name('pegawai.update');
        Route::get('/{pegawai}/delete', [PegawaiController::class, 'destroy'])->name('pegawai.destroy');
    });
});
