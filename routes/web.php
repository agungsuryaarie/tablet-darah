<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\UserPuskesController;
use App\Http\Controllers\Admin\UserSekolahController;
use App\Http\Controllers\Admin\UserPosyanduController;
use App\Http\Controllers\Admin\RematriController;
use App\Http\Controllers\Admin\RematriPController;
use App\Http\Controllers\Admin\StokObatController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KabController;
use App\Http\Controllers\Admin\KecController;
use App\Http\Controllers\Admin\DesaController;
use App\Http\Controllers\Admin\PuskesController;
use App\Http\Controllers\Admin\PosyanduController;
use App\Http\Controllers\Admin\SekolahController;
use App\Http\Controllers\Admin\SekolahBinaanController;
use App\Http\Controllers\Admin\PosyanduBinaanController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::controller(AuthController::class)->group(function () {
    // Login
    Route::get('login', 'index')->name('login')->middleware('guest');
    Route::post('login', 'login')->middleware('guest');
    Route::get('logout', 'logout')->name('logout');
});
Route::group(['middleware' => ['auth:admdinas,admpuskes,admsekolah,admposyandu']], function () {
    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::group(['middleware' => ['checkUser:1']], function () {
        // Kabupaten
        Route::resource('kabupaten', KabController::class);
        // Kecamatan
        Route::resource('kecamatan', KecController::class);
        // Desa/Kelurahan
        Route::resource('desa', DesaController::class);
        // Puskesmas
        Route::resource('puskesmas', PuskesController::class);
        // Posyandu
        Route::resource('posyandu', PosyanduController::class);
        Route::post('posyandu/getpuskesmas', [PosyanduController::class, 'getPuskes'])->name('posyandu.getpuskes');
        Route::post('posyandu/getdesa', [PosyanduController::class, 'getDesa'])->name('posyandu.getdesa');
        // Sekolah
        Route::resource('sekolah', SekolahController::class);
        // Users Puskemas
        Route::get('users-puskesmas', [UserPuskesController::class, 'index'])->name('userpuskes.index');
        Route::post('users-puskesmas', [UserPuskesController::class, 'store'])->name('userpuskes.store');
        Route::get('users-puskesmas/{id}/edit', [UserPuskesController::class, 'edit'])->name('userpuskes.edit');
        Route::delete('users-puskesmas/{user}/destroy', [UserPuskesController::class, 'destroy'])->name('userpuskes.destroy');
        Route::post('users-puskesmas/getpuskesmas', [UserPuskesController::class, 'getPuskes'])->name('userpuskes.getpuskes');
    });
    Route::group(['middleware' => ['checkUser:2']], function () {
        // Sekolah Binaan
        Route::resource('sekolah-binaan', SekolahBinaanController::class);
        // Posyandu Binaan
        Route::resource('posyandu-binaan', PosyanduBinaanController::class);
        // Users Sekolah
        Route::get('users-sekolah', [UserSekolahController::class, 'index'])->name('usersekolah.index');
        Route::post('users-sekolah', [UserSekolahController::class, 'store'])->name('usersekolah.store');
        Route::get('users-sekolah/{id}/edit', [UserSekolahController::class, 'edit'])->name('usersekolah.edit');
        Route::delete('users-sekolah/{user}/destroy', [UserSekolahController::class, 'destroy'])->name('usersekolah.destroy');
        // Users Posyandu
        Route::get('users-posyandu', [UserPosyanduController::class, 'index'])->name('userposyandu.index');
        Route::post('users-posyandu', [UserPosyanduController::class, 'store'])->name('userposyandu.store');
        Route::get('users-posyandu/{id}/edit', [UserPosyanduController::class, 'edit'])->name('userposyandu.edit');
        Route::delete('users-posyandu/{user}/destroy', [UserPosyanduController::class, 'destroy'])->name('userposyandu.destroy');
        // Rematri
        Route::get('rematri', [RematriController::class, 'index'])->name('rematri.index');
        Route::get('rematri/create', [RematriController::class, 'create'])->name('rematri.create');
        Route::get('rematri/edit', [RematriController::class, 'edit'])->name('rematri.edit');
    });
    Route::group(['middleware' => ['checkUser:3']], function () {
        // Rematri
        Route::get('rematri', [RematriController::class, 'index'])->name('rematri.index');
        Route::get('rematri/create', [RematriController::class, 'create'])->name('rematri.create');
        Route::get('rematri/edit', [RematriController::class, 'edit'])->name('rematri.edit');
    });
    Route::group(['middleware' => ['checkUser:4']], function () {
        // Rematri
        Route::get('rematri-posyandu', [RematriPController::class, 'index'])->name('rematrip.index');
        Route::get('rematri-posyandu/create', [RematriPController::class, 'create'])->name('rematrip.create');
        Route::get('rematri-posyandu/edit', [RematriPController::class, 'edit'])->name('rematrip.edit');
    });
});
