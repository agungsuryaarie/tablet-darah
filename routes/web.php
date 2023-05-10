<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\UserPuskesController;
use App\Http\Controllers\Admin\UserSekolahController;
use App\Http\Controllers\Admin\RematriController;
use App\Http\Controllers\Admin\StokObatController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KabController;
use App\Http\Controllers\Admin\KecController;
use App\Http\Controllers\Admin\DesaController;
use App\Http\Controllers\Admin\PuskesController;
use App\Http\Controllers\Admin\PosyanduController;
use App\Http\Controllers\Admin\SekolahController;
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
Route::group(['middleware' => ['auth:admdinas,admpuskes']], function () {
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
        // Sekolah
        Route::resource('sekolah', SekolahController::class);
        // Users Puskemas
        Route::get('users-puskesmas', [UserPuskesController::class, 'index'])->name('userpuskes.index');
        Route::post('users-puskesmas', [UserPuskesController::class, 'store'])->name('userpuskes.store');
        Route::get('users-puskesmas/{id}/edit', [UserPuskesController::class, 'edit'])->name('userpuskes.edit');
        Route::delete('users-puskesmas/{user}/destroy', [UserPuskesController::class, 'destroy'])->name('userpuskes.destroy');
        Route::post('users-puskesmas/getkecamatan', [UserPuskesController::class, 'getKec'])->name('userpuskes.getkec');
        Route::post('users-puskesmas/getpuskesmas', [UserPuskesController::class, 'getPuskes'])->name('userpuskes.getpuskes');
    });
    Route::group(['middleware' => ['checkUser:2']], function () {
        // Users Sekolah
        Route::get('users-sekolah', [UserSekolahController::class, 'index'])->name('usersekolah.index');
        Route::post('users-sekolah', [UserSekolahController::class, 'store'])->name('usersekolah.store');
        Route::get('users-sekolah/{id}/edit', [UserSekolahController::class, 'edit'])->name('usersekolah.edit');
        Route::delete('users-sekolah/{user}/destroy', [UserSekolahController::class, 'destroy'])->name('usersekolah.destroy');
        Route::post('users-sekolah/getkecamatan', [UserSekolahController::class, 'getKec'])->name('usersekolah.getkec');
        Route::post('users-sekolah/getsekolah', [UserSekolahController::class, 'getPuskes'])->name('usersekolah.getpuskes');
        // Rematri
        Route::get('rematri', [RematriController::class, 'index'])->name('rematri.index');
        Route::get('rematri/create', [RematriController::class, 'create'])->name('rematri.create');
        Route::get('rematri/edit', [RematriController::class, 'edit'])->name('rematri.edit');
    });
});
