<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\UserPuskesController;
use App\Http\Controllers\Admin\UserSekolahController;
use App\Http\Controllers\Admin\UserPosyanduController;
use App\Http\Controllers\Admin\RematriController;
use App\Http\Controllers\Admin\RematriPosyanduController;
use App\Http\Controllers\Admin\StokObatController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KabController;
use App\Http\Controllers\Admin\KecController;
use App\Http\Controllers\Admin\DesaController;
use App\Http\Controllers\Admin\JurusanController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\PuskesController;
use App\Http\Controllers\Admin\PosyanduController;
use App\Http\Controllers\Admin\SekolahController;
use App\Http\Controllers\Admin\SekolahBinaanController;
use App\Http\Controllers\Admin\PosyanduBinaanController;
use App\Http\Controllers\Admin\SesiController;
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
        Route::post('kabupaten/get-kabupaten', [KabController::class, 'getKabupaten']);

        // Kecamatan
        Route::resource('kecamatan', KecController::class);
        Route::post('kecamatan/get-kecamatan', [KecController::class, 'getKecamatan']);

        // Desa/Kelurahan
        Route::resource('desa', DesaController::class);
        Route::post('desa/get-desa', [DesaController::class, 'getDesa']);

        // Puskesmas
        Route::resource('puskesmas', PuskesController::class);
        Route::post('puskesmas/get-puskes', [PuskesController::class, 'getPuskes']);

        // Posyandu
        Route::resource('posyandu', PosyanduController::class);

        // Sekolah
        Route::resource('sekolah', SekolahController::class);
        Route::post('sekolah/get-jenjang', [SekolahController::class, 'getJenjang']);
        Route::post('sekolah/get-status', [SekolahController::class, 'getStatus']);

        // Users Puskemas
        Route::get('users-puskesmas', [UserPuskesController::class, 'index'])->name('userpuskes.index');
        Route::post('users-puskesmas', [UserPuskesController::class, 'store'])->name('userpuskes.store');
        Route::get('users-puskesmas/{id}/edit', [UserPuskesController::class, 'edit'])->name('userpuskes.edit');
        Route::delete('users-puskesmas/{user}/destroy', [UserPuskesController::class, 'destroy'])->name('userpuskes.destroy');
        Route::post('users-puskesmas/getpuskesmas', [UserPuskesController::class, 'getPuskes'])->name('userpuskes.getpuskes');
    });

    Route::group(['middleware' => ['checkUser:2']], function () {

        // Route::post('kecamatan/get-kecamatan', [KecController::class, 'getKecamatan']);
        // Route::post('puskesmas/get-puskes', [PuskesController::class, 'getPuskes']);
        Route::post('desa/get-desa', [DesaController::class, 'getDesa']);
        Route::post('posyandu/get-posyandu', [PosyanduController::class, 'getPosyandu']);
        Route::post('sekolah/get-sekolah', [SekolahController::class, 'getSekolah']);
        Route::post('sekolah/get-jenjang', [SekolahController::class, 'getJenjang']);
        Route::post('sekolah/get-status', [SekolahController::class, 'getStatus']);
        Route::post('sekolah/get-jenjang-auto', [SekolahController::class, 'getJenjangAuto']);


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

        // Jurusan
        Route::resource('jurusan', JurusanController::class);
        Route::post('jurusan/get-jurusan', [JurusanController::class, 'getJurusan']);

        // Kelas
        Route::resource('kelas', KelasController::class);
        Route::post('kelas/get-kelas', [KelasController::class, 'getKelas']);

        // Rematri
        Route::get('rematri', [RematriController::class, 'index'])->name('rematri.index');
        Route::get('rematri-create', [RematriController::class, 'create'])->name('rematri.create');
        Route::post('rematri/store', [RematriController::class, 'store'])->name('rematri.store');
        Route::get('rematri/edit/{rematri}', [RematriController::class, 'edit'])->name('rematri.edit');
        Route::post('rematri/update/{rematri}', [RematriController::class, 'update'])->name('rematri.update');
        Route::delete('rematri/{rematri}/destroy', [RematriController::class, 'destroy'])->name('rematri.destroy');
        Route::post('rematri/get-jurusan', [RematriController::class, 'getJurusan']);
        Route::post('rematri/get-desa', [RematriController::class, 'getDesa']);
        Route::get('rematri/{rematri}/hb', [RematriController::class, 'hb'])->name('rematri.hb');
        Route::post('rematri/hb', [RematriController::class, 'storehb'])->name('hb.store');
        Route::delete('rematri/{rematri}/destroyhb', [RematriController::class, 'destroyhb'])->name('rematri.destroyhb');

        // Sesi
        Route::resource('sesi', SesiController::class);
        Route::get('sesi/{id}/rematri', [SesiController::class, 'rematri'])->name('sesi.rematri');
        Route::get('sesi/ttd/{id}/{ids}/{ttd}', [SesiController::class, 'ttd'])->name('sesi.ttd');
        Route::post('sesi/upload', [SesiController::class, 'upload'])->name('sesi.uploadfoto');
        Route::get('sesi/{id}/foto-rematri', [SesiController::class, 'foto'])->name('sesi.foto');
    });
    Route::group(['middleware' => ['checkUser:4']], function () {
        // Rematri
        Route::get('rematri-posyandu', [RematriPosyanduController::class, 'index'])->name('rematri.posyandu.index');
        Route::get('rematri-posyandu-create', [RematriPosyanduController::class, 'create'])->name('rematri.posyandu.create');
        Route::post('rematri-posyandu/store', [RematriPosyanduController::class, 'store'])->name('rematri.posyandu.store');
        Route::get('rematri-posyandu/edit/{rematri}', [RematriPosyanduController::class, 'edit'])->name('rematri.posyandu.edit');
        Route::post('rematri-posyandu/update/{rematri}', [RematriPosyanduController::class, 'update'])->name('rematri.posyandu.update');
        Route::delete('rematri-posyandu/{rematri}/destroy', [RematriPosyanduController::class, 'destroy'])->name('rematri.posyandu.destroy');
        Route::post('rematri-posyandu/get-desa', [RematriPosyanduController::class, 'getDesa']);
        Route::get('rematri-posyandu/{rematri}/hb', [RematriPosyanduController::class, 'hb'])->name('rematri.posyandu.hb');
        Route::post('rematri-posyandu/hb', [RematriPosyanduController::class, 'storehb'])->name('hb.posyandu.store');
        Route::delete('rematri-posyandu/{rematri}/destroyhb', [RematriPosyanduController::class, 'destroyhb'])->name('rematri.posyandu.destroyhb');
    });
});
