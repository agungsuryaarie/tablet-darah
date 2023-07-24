<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\UserPuskesController;
use App\Http\Controllers\Admin\UserSekolahController;
use App\Http\Controllers\Admin\UserPosyanduController;
use App\Http\Controllers\Admin\RematriController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KabController;
use App\Http\Controllers\Admin\KecController;
use App\Http\Controllers\Admin\DesaController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\PuskesController;
use App\Http\Controllers\Admin\PosyanduController;
use App\Http\Controllers\Admin\SekolahController;
use App\Http\Controllers\Admin\SekolahBinaanController;
use App\Http\Controllers\Admin\PosyanduBinaanController;
use App\Http\Controllers\Admin\RuanganController;
use App\Http\Controllers\Admin\SesiController;
use App\Http\Controllers\Admin\SesiPosyanduController;
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

Route::controller(AuthController::class)->group(function () {
    // Login
    Route::get('/', 'index')->name('index')->middleware('guest');
    Route::post('/', 'login')->name('login');
    Route::get('logout', 'logout')->name('logout');
});

Route::group(['middleware' => ['auth:admdinas,admpuskes,admsekolah,admposyandu']], function () {
    // Dashboard
    // API DESA
    Route::post('desa/get-desa', [DesaController::class, 'getDesa']);

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('puskesmas/rematri/count', [DashboardController::class, 'puskesmas'])->name('puskesmas.rematri.count');
    Route::group(['middleware' => ['checkUser:1']], function () {
        // Kabupaten
        Route::resource('kabupaten', KabController::class);
        Route::post('kabupaten/get-kabupaten', [KabController::class, 'getKabupaten']);

        // Kecamatan
        Route::resource('kecamatan', KecController::class);
        Route::post('kecamatan/get-kecamatan', [KecController::class, 'getKecamatan']);

        // Desa/Kelurahan
        Route::resource('desa', DesaController::class);

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
        Route::delete('users-puskesmas/{user}', [UserPuskesController::class, 'destroy'])->name('userpuskes.destroy');
        Route::post('users-puskesmas/getpuskesmas', [UserPuskesController::class, 'getPuskes'])->name('userpuskes.getpuskes');

        // Users Sekolah
        Route::get('users-sekolah/registered', [UserSekolahController::class, 'registered'])->name('userssekolah.registered');
    });

    Route::group(['middleware' => ['checkUser:2']], function () {
        Route::get('rematri/puskesmas/{id}', [DashboardController::class, 'chartPuskesmas'])->name('rematri.puskesmas');
        // Profil
        Route::get('profile-puskesmas', [UserPuskesController::class, 'profil'])->name('profilpuskes.index');
        Route::put('profile-puskesmas/{user}/update', [UserPuskesController::class, 'updateprofil'])->name('profilpuskes.update');
        Route::put('profile-puskesmas/{user}/update-password', [UserPuskesController::class, 'updatepassword'])->name('profilpuskes.update.password');
        Route::put('profile-puskesmas/{user}/update-foto', [UserPuskesController::class, 'updatefoto'])->name('profilpuskes.update.foto');
        //Posyandu
        Route::post('posyandu/get-posyandu', [PosyanduController::class, 'getPosyandu']);
        Route::post('sekolah/get-sekolah', [SekolahController::class, 'getSekolah']);
        Route::post('sekolah/get-sekolah-puskes', [SekolahController::class, 'getSekolahPuskes']);
        Route::post('sekolah/get-jenjang-puskes', [SekolahController::class, 'getJenjang']);
        Route::post('sekolah/get-status-puskes', [SekolahController::class, 'getStatus']);
        Route::post('sekolah/get-jenjang-auto', [SekolahController::class, 'getJenjangAuto']);

        // Sekolah Binaan
        Route::resource('sekolah-binaan', SekolahBinaanController::class);
        Route::get('sekolah-binaan/sekolah', [SekolahBinaanController::class, 'show'])->name('sekolah-binaan.take');
        Route::post('sekolah-binaan/take', [SekolahBinaanController::class, 'take'])->name('take.update');

        // Posyandu Binaan
        Route::resource('posyandu-binaan', PosyanduBinaanController::class);
        Route::get('posyandu-binaan/sekolah', [PosyanduBinaanController::class, 'show'])->name('posyandu-binaan.take');
        Route::post('posyandu-binaan/take', [PosyanduBinaanController::class, 'take'])->name('take.posyandu.update');
        Route::post('posyandu-binaan/get-kecamatan', [KecController::class, 'getKecamatan']);
        Route::post('posyandu-binaan/get-desa', [DesaController::class, 'getDesa']);
        Route::post('posyandu-binaan/save', [PosyanduController::class, 'store']);

        // Users Sekolah
        Route::get('users-sekolah', [UserSekolahController::class, 'index'])->name('usersekolah.index');
        Route::post('users-sekolah', [UserSekolahController::class, 'store'])->name('usersekolah.store');
        Route::get('users-sekolah/{id}/edit', [UserSekolahController::class, 'edit'])->name('usersekolah.edit');
        Route::delete('users-sekolah/{user}', [UserSekolahController::class, 'destroy'])->name('usersekolah.destroy');

        // Users Posyandu
        Route::get('users-posyandu', [UserPosyanduController::class, 'index'])->name('userposyandu.index');
        Route::post('users-posyandu', [UserPosyanduController::class, 'store'])->name('userposyandu.store');
        Route::get('users-posyandu/{id}/edit', [UserPosyanduController::class, 'edit'])->name('userposyandu.edit');
        Route::delete('users-posyandu/{user}', [UserPosyanduController::class, 'destroy'])->name('userposyandu.destroy');

        // Route::get('rematri', [RematriController::class, 'index'])->name('rematri.index');
        // Route::get('rematri/create', [RematriController::class, 'create'])->name('rematri.create');
        // Route::get('rematri/edit', [RematriController::class, 'edit'])->name('rematri.edit');
    });

    Route::group(['middleware' => ['checkUser:3']], function () {

        Route::get('rematri/sekolah/{id}', [DashboardController::class, 'chartSekolah'])->name('rematri.sekolah');
        // Profil
        Route::get('profile-sekolah', [UserSekolahController::class, 'profil'])->name('profilsekolah.index');
        Route::put('profile-sekolah/{user}/update', [UserSekolahController::class, 'updateprofil'])->name('profilsekolah.update');
        Route::put('profile-sekolah/{user}/update-password', [UserSekolahController::class, 'updatepassword'])->name('profilsekolah.update.password');
        Route::put('profile-sekolah/{user}/update-foto', [UserSekolahController::class, 'updatefoto'])->name('profilsekolah.update.foto');

        // Kelas
        Route::resource('kelas', KelasController::class);

        // Ruangan
        Route::resource('ruangan', RuanganController::class);
        Route::post('ruangan/get-ruangan', [RuanganController::class, 'getRuangan']);
        Route::post('ruangan/get-ruangan-sesi', [RuanganController::class, 'getRuanganSesi']);

        // Rematri
        Route::get('rematri', [RematriController::class, 'index'])->name('rematri.index');
        Route::get('rematri-create', [RematriController::class, 'create'])->name('rematri.create')->middleware('checkDataRuangan');
        Route::post('rematri/store', [RematriController::class, 'store'])->name('rematri.store');
        Route::get('rematri/edit/{rematri}', [RematriController::class, 'edit'])->name('rematri.edit');
        Route::post('rematri/update/{rematri}', [RematriController::class, 'update'])->name('rematri.update');
        Route::delete('rematri/{rematri}/destroy', [RematriController::class, 'destroy'])->name('rematri.destroy');
        Route::post('rematri/get-desa', [RematriController::class, 'getDesa']);
        Route::get('rematri/{rematri}/hb', [RematriController::class, 'hb'])->name('rematri.hb');
        Route::post('rematri/hb', [RematriController::class, 'storehb'])->name('hb.store');
        Route::delete('rematri/{rematri}/destroyhb', [RematriController::class, 'destroyhb'])->name('rematri.destroyhb');
        Route::post('kenaikan-kelas/naik', [RematriController::class, 'naik'])->name('kenaikan-kelas.naik');

        // Sesi
        Route::resource('sesi', SesiController::class)->middleware('checkDataRematri');
        Route::get('sesi/{id}/rematri', [SesiController::class, 'rematri'])->name('sesi.rematri');
        Route::get('sesi/{id}/rematri-view', [SesiController::class, 'rematriview'])->name('sesi.rematriview');
        Route::get('sesi/{id}/export', [SesiController::class, 'export'])->name('sesi.export');
        Route::get('sesi/ttd/{id}/{ids}/{ttd}', [SesiController::class, 'ttd'])->name('sesi.ttd');
        Route::post('sesi/upload', [SesiController::class, 'upload'])->name('sesi.uploadfoto');
        Route::get('sesi/{id}/foto-rematri', [SesiController::class, 'foto'])->name('sesi.foto');
        Route::get('get-sesi-page',  [SesiController::class, 'getPaginatedData'])->name('get_sesi_page');
    });
    Route::group(['middleware' => ['checkUser:4']], function () {
        //Profil
        Route::get('profile-posyandu', [UserPosyanduController::class, 'profil'])->name('profilposyandu.index');
        Route::put('profile-posyandu/{user}/update', [UserPosyanduController::class, 'updateprofil'])->name('profilposyandu.update');
        Route::put('profile-posyandu/{user}/update-password', [UserPosyanduController::class, 'updatepassword'])->name('profilposyandu.update.password');
        Route::put('profile-posyandu/{user}/update-foto', [UserPosyanduController::class, 'updatefoto'])->name('profilposyandu.update.foto');

        // Rematri
        Route::get('rematri-posyandu', [RematriController::class, 'index'])->name('rematri.posyandu.index');
        Route::get('rematri-posyandu-create', [RematriController::class, 'create'])->name('rematri.posyandu.create');
        Route::post('rematri-posyandu/store', [RematriController::class, 'store']);
        Route::get('rematri-posyandu/edit/{rematri}', [RematriController::class, 'edit'])->name('rematri.posyandu.edit');
        Route::post('rematri-posyandu/update/{rematri}', [RematriController::class, 'update'])->name('rematri.posyandu.update');
        Route::delete('rematri-posyandu/{rematri}/destroy', [RematriController::class, 'destroy'])->name('rematri.posyandu.destroy');
        Route::post('rematri-posyandu/get-desa', [RematriController::class, 'getDesa']);
        Route::get('rematri-posyandu/{rematri}/hb', [RematriController::class, 'hb'])->name('rematri.posyandu.hb');
        Route::post('rematri-posyandu/hb', [RematriController::class, 'storehb'])->name('hb.posyandu.store');
        Route::delete('rematri-posyandu/{rematri}/destroyhb', [RematriController::class, 'destroyhb'])->name('rematri.posyandu.destroyhb');

        // Sesi
        Route::resource('sesi-posyandu', SesiPosyanduController::class);
        Route::get('sesi-posyandu/{id}/rematri', [SesiPosyanduController::class, 'rematri'])->name('sesi.posyandu.rematri');
        Route::get('sesi-posyandu/ttd/{id}/{ids}/{ttd}', [SesiPosyanduController::class, 'ttd'])->name('sesi.posyandu.ttd');
        Route::post('sesi-posyandu/upload', [SesiPosyanduController::class, 'upload'])->name('sesi.posyandu.uploadfoto');
    });
});
