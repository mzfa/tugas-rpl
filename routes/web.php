<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\StrukturController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\BagianController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\ProfesiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HakAksesController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\KategoriStatusController;
use App\Http\Controllers\BidangPekerjaanController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\DokAdmController;
use App\Http\Controllers\GambarKerjaController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\HSEController;
use App\Http\Controllers\IjinPelaksanaanController;
use App\Http\Controllers\JenisPekerjaanController;
use App\Http\Controllers\KategoriDokumenController;
use App\Http\Controllers\KategoriSuratController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MaterialApprovalController;
use App\Http\Controllers\MetodeController;
use App\Http\Controllers\NotulenController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\PenerimaanController;
use App\Http\Controllers\PermintaanController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\ProyekController;
use App\Http\Controllers\RakController;
use App\Http\Controllers\StatusDokumenController;
use App\Http\Controllers\StokDepoController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SuratMenyuratController;

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


Route::get('/', [\App\Http\Controllers\LoginController::class, 'index'])->name('login');
Route::get('/login', [\App\Http\Controllers\LoginController::class, 'index'])->name('login');
Route::post('/login', [\App\Http\Controllers\LoginController::class, 'authenticate'])->name('login.store');
Route::get('/register', [\App\Http\Controllers\RegisterController::class, 'index'])->name('register');
Route::post('/register', [\App\Http\Controllers\RegisterController::class, 'store'])->name('register.store');
Route::get('/cetak', [\App\Http\Controllers\PenggajianManualController::class, 'createPDF'])->name('createPDF');
Route::get('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    
    return redirect('/');
})->name('logout');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::post('/ganti_proyek', [\App\Http\Controllers\HomeController::class, 'ganti_proyek'])->name('ganti_proyek');
    Route::post('/doc_command', [\App\Http\Controllers\HomeController::class, 'doc_command'])->name('doc_command');
    Route::POST('/buat_password', [\App\Http\Controllers\HomeController::class, 'buat_password'])->name('buat_password');
    Route::POST('/ubah_password', [\App\Http\Controllers\HomeController::class, 'ubah_password'])->name('ubah_password');
    
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/my_profile', 'index')->name('my_profile.index');
        Route::post('/my_profile/update', 'update');
        Route::post('/ganti_password', 'gantiPassword');
    });
    Route::controller(HakAksesController::class)->middleware('cek_login:hakakses.index')->group(function () {
        Route::get('/hakakses', 'index')->name('hakakses.index');
        Route::get('/hakakses/edit/{id}', 'edit');
        Route::get('/hakakses/delete/{id}', 'delete');
        Route::get('/hakakses/modul_akses/{id}', 'modul_akses');
        Route::post('/hakakses/modul_akses', 'modul_akses_store');
        Route::get('/hakakses/akses_proyek/{id}', 'akses_proyek');
        Route::post('/hakakses/akses_proyek', 'akses_proyek_store');
        Route::post('/hakakses/store', 'store');
        Route::post('/hakakses/update', 'update');
    });
    Route::controller(MenuController::class)->middleware('cek_login:menu.index')->group(function () {
        Route::get('/menu', 'index')->name('menu.index');
        Route::get('/menu/edit/{id}', 'edit');
        Route::get('/menu/status/{id}', 'status');
        Route::get('/menu/delete/{id}', 'delete');
        Route::post('/menu/store', 'store');
        Route::post('/menu/update', 'update');
    });
    Route::controller(StrukturController::class)->middleware('cek_login:struktur.index')->group(function () {
        Route::get('/struktur', 'index')->name('struktur.index');
        Route::get('/struktur/edit/{id}', 'edit');
        Route::get('/struktur/status/{id}', 'status');
        Route::get('/struktur/delete/{id}', 'delete');
        Route::post('/struktur/store', 'store');
        Route::post('/struktur/update', 'update');
    });
    Route::controller(LokasiController::class)->middleware('cek_login:lokasi.index')->group(function () {
        Route::get('/lokasi', 'index')->name('lokasi.index');
        Route::get('/lokasi/edit/{id}', 'edit');
        Route::get('/lokasi/status/{id}', 'status');
        Route::get('/lokasi/delete/{id}', 'delete');
        Route::post('/lokasi/store', 'store');
        Route::post('/lokasi/update', 'update');
    });
    Route::controller(UserController::class)->middleware('cek_login:user.index')->group(function () {
        Route::get('/user', 'index')->name('user.index');
        Route::get('/user/delete/{id}', 'delete');
        Route::post('/user/store', 'store');
        Route::post('/user/updateUser', 'updateUser');
        Route::get('/user/editUser/{id}', 'editUser');
        Route::get('/user/edit/{id}', 'edit');
        Route::post('/user/update', 'update');
    });
    Route::controller(BagianController::class)->middleware('cek_login:bagian.index')->group(function () {
        Route::get('/bagian', 'index')->name('bagian.index');
        Route::get('/bagian/delete/{id}', 'delete');
        Route::post('/bagian/store', 'store');
        Route::get('/bagian/edit/{id}', 'edit');
        Route::post('/bagian/update', 'update');
    });
    Route::controller(GudangController::class)->middleware('cek_login:gudang.index')->group(function () {
        Route::get('/gudang', 'index')->name('gudang.index');
        Route::get('/gudang/delete/{id}', 'delete');
        Route::post('/gudang/store', 'store');
        Route::get('/gudang/edit/{id}', 'edit');
        Route::post('/gudang/update', 'update');
        Route::get('/gudang/rak/{id}', 'rak');
    });
    Route::controller(BarangController::class)->middleware('cek_login:barang.index')->group(function () {
        Route::get('/barang', 'index')->name('barang.index');
        Route::get('/barang/delete/{id}', 'delete');
        Route::post('/barang/store', 'store');
        Route::get('/barang/edit/{id}', 'edit');
        Route::post('/barang/update', 'update');
    });
    Route::controller(SupplierController::class)->middleware('cek_login:supplier.index')->group(function () {
        Route::get('/supplier', 'index')->name('supplier.index');
        Route::get('/supplier/delete/{id}', 'delete');
        Route::post('/supplier/store', 'store');
        Route::get('/supplier/edit/{id}', 'edit');
        Route::post('/supplier/update', 'update');
    });
    Route::controller(RakController::class)->middleware('cek_login:rak.index')->group(function () {
        Route::get('/rak', 'index')->name('rak.index');
        Route::get('/rak/delete/{id}', 'delete');
        Route::post('/rak/store', 'store');
        Route::get('/rak/edit/{id}', 'edit');
        Route::get('/rak/barcode/{id}', 'barcode');
        Route::post('/rak/update', 'update');
    });
    Route::controller(PaketController::class)->middleware('cek_login:paket.index')->group(function () {
        Route::get('/paket', 'index')->name('paket.index');
        Route::get('/paket/delete/{id}', 'delete');
        Route::post('/paket/store', 'store');
        Route::get('/paket/edit/{id}', 'edit');
        Route::get('/paket/detail/{id}', 'detail');
        Route::post('/paket/update', 'update');
        Route::post('/paket/update_detail', 'update_detail');
    });
    Route::controller(PemesananController::class)->middleware('cek_login:pemesanan.index')->group(function () {
        Route::get('/pemesanan', 'index')->name('pemesanan.index');
        Route::get('/pemesanan/delete/{id}', 'delete');
        Route::post('/pemesanan/store', 'store');
        Route::get('/pemesanan/edit/{id}', 'edit');
        Route::get('/pemesanan/detail/{id}', 'detail');
        Route::post('/pemesanan/update', 'update');
        Route::post('/pemesanan/update_detail', 'update_detail');
    });
    Route::controller(PermintaanController::class)->middleware('cek_login:permintaan.index')->group(function () {
        Route::get('/permintaan', 'index')->name('permintaan.index');
        Route::get('/permintaan/delete/{id}', 'delete');
        Route::post('/permintaan/store', 'store');
        Route::get('/permintaan/edit/{id}', 'edit');
        Route::get('/permintaan/detail/{id}', 'detail');
        Route::post('/permintaan/update', 'update');
        Route::post('/permintaan/update_detail', 'update_detail');
    });
    Route::controller(PenerimaanController::class)->middleware('cek_login:penerimaan.index')->group(function () {
        Route::get('/penerimaan', 'index')->name('penerimaan.index');
        Route::get('/penerimaan/delete/{id}', 'delete');
        Route::post('/penerimaan/store', 'store');
        Route::get('/penerimaan/edit/{id}', 'edit');
        Route::get('/penerimaan/scan/{id}', 'scan');
        Route::get('/penerimaan/detail/{id}', 'detail');
        Route::get('/penerimaan/lihat/{id}', 'lihat');
        Route::get('/penerimaan/terima_barang/{id}/{rak}', 'terima_barang');
        Route::post('/penerimaan/update', 'update');
        Route::post('/penerimaan/update_detail', 'update_detail');
    });
    Route::controller(StokDepoController::class)->middleware('cek_login:stok_depo.index')->group(function () {
        Route::get('/stok_depo', 'index')->name('stok_depo.index');
    });

    Route::controller(LaporanController::class)->group(function () {
        Route::prefix('laporan')->group(function () {
            Route::get('/penerimaan', 'penerimaan')->name('laporan.penerimaan');
            Route::get('/pemesanan', 'pemesanan')->name('laporan.pemesanan');
            Route::get('/permintaan', 'permintaan')->name('laporan.permintaan');
            Route::get('/kartu_stok', 'kartu_stok')->name('laporan.kartu_stok');
        });
    });


    Route::group(['middleware' => ['cek_login:User']], function () {
        // Route::get('/profile', [\App\Http\Controllers\User\ProfileController::class, 'index'])->name('profile');
        // Route::get('/profesi', [\App\Http\Controllers\User\ProfesiController::class, 'index'])->name('profesi');
        // Route::get('/pekerjaan', [\App\Http\Controllers\User\PekerjaanController::class, 'index'])->name('pekerjaan');
        // Route::get('/pelatihan', [\App\Http\Controllers\User\PelatihanController::class, 'index'])->name('pelatihan');
        // Route::get('/kinerja', [\App\Http\Controllers\User\KinerjaController::class, 'index'])->name('kinerja');
        // Route::get('/kompetensi', [\App\Http\Controllers\User\KompetensiController::class, 'index'])->name('kompetensi');
    });
    // Route::get('/notification', [\App\Http\Controllers\Admin\HomeController::class, 'index'])->name('home');

});

