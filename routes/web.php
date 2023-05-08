<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserPuskesController;
use App\Http\Controllers\Admin\RematriController;
use App\Http\Controllers\Admin\StokObatController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KabController;
use App\Http\Controllers\Admin\KecController;
use App\Http\Controllers\Admin\DesaController;
use App\Http\Controllers\Admin\PuskesController;
use App\Http\Controllers\Admin\PosyanduController;
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
// Dashboard
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
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
// Users
Route::get('users-puskesmas', [UserPuskesController::class, 'index'])->name('userpuskes.index');
Route::post('users-puskesmas', [UserPuskesController::class, 'store'])->name('userpuskes.store');
Route::get('users-puskesmas/{id}/edit', [UserPuskesController::class, 'edit'])->name('userpuskes.edit');
Route::delete('users-puskesmas/{user}/destroy', [UserPuskesController::class, 'destroy'])->name('userpuskes.destroy');
Route::post('users-puskesmas/getkecamatan', [UserPuskesController::class, 'getKec'])->name('userpuskes.getkec');
Route::post('users-puskesmas/getpuskesmas', [UserPuskesController::class, 'getPuskes'])->name('userpuskes.getpuskes');
// Rematri
Route::get('rematri', [RematriController::class, 'index'])->name('rematri.index');
Route::get('rematri/create', [RematriController::class, 'create'])->name('rematri.create');
Route::get('rematri/edit', [RematriController::class, 'edit'])->name('rematri.edit');
