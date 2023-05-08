<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RematriController;
use App\Http\Controllers\Admin\StokObatController;
use App\Http\Controllers\Admin\KabController;

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
    return view('dashboard');
});
// Kabupaten
Route::resource('kabupaten', KabController::class);
// user
Route::get('user', [UserController::class, 'index'])->name('user.index');
Route::get('user/create', [UserController::class, 'create'])->name('user.create');
Route::get('user/edit', [UserController::class, 'edit'])->name('user.edit');
// Rematri
Route::get('rematri', [RematriController::class, 'index'])->name('rematri.index');
Route::get('rematri/create', [RematriController::class, 'create'])->name('rematri.create');
Route::get('rematri/edit', [RematriController::class, 'edit'])->name('rematri.edit');
