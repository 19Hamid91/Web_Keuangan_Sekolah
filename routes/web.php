<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SekolahController;

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
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    Route::group(['prefix' => 'users'], function() {
        Route::get('/', 'UsersController@index')->name('users.index');
        Route::get('/create', 'UsersController@create')->name('users.create');
        Route::post('/create', 'UsersController@store')->name('users.store');
        Route::get('/{user}/show', 'UsersController@show')->name('users.show');
        Route::get('/{user}/edit', 'UsersController@edit')->name('users.edit');
        Route::patch('/{user}/update', 'UsersController@update')->name('users.update');
        Route::get('/{user}/delete', 'UsersController@destroy')->name('users.destroy');
    });

    Route::group(['prefix' => 'sekolah'], function() {
        Route::get('/', [SekolahController::class, 'index'])->name('sekolah.index');
        Route::get('/create', [SekolahController::class, 'create'])->name('sekolah.create');
        Route::post('/create', [SekolahController::class, 'store'])->name('sekolah.store');
        Route::get('/{sekolah}/show', [SekolahController::class, 'show'])->name('sekolah.show');
        Route::get('/{sekolah}/edit', [SekolahController::class, 'edit'])->name('sekolah.edit');
        Route::patch('/{sekolah}/update', [SekolahController::class, 'update'])->name('sekolah.update');
        Route::get('/{sekolah}/delete', [SekolahController::class, 'destroy'])->name('sekolah.destroy');
    });
});
