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
use App\Http\Controllers\HSEController;
use App\Http\Controllers\IjinPelaksanaanController;
use App\Http\Controllers\JenisPekerjaanController;
use App\Http\Controllers\KategoriDokumenController;
use App\Http\Controllers\KategoriSuratController;
use App\Http\Controllers\MaterialApprovalController;
use App\Http\Controllers\MetodeController;
use App\Http\Controllers\NotulenController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\PenerimaanController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\ProyekController;
use App\Http\Controllers\RakController;
use App\Http\Controllers\StatusDokumenController;
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
    Route::controller(PenerimaanController::class)->middleware('cek_login:penerimaan.index')->group(function () {
        Route::get('/penerimaan', 'index')->name('penerimaan.index');
        Route::get('/penerimaan/delete/{id}', 'delete');
        Route::post('/penerimaan/store', 'store');
        Route::get('/penerimaan/edit/{id}', 'edit');
        Route::get('/penerimaan/detail/{id}', 'detail');
        Route::post('/penerimaan/update', 'update');
        Route::post('/penerimaan/update_detail', 'update_detail');
    });

    Route::controller(CalendarController::class)->middleware('cek_login:calendar.index')->group(function () {
        Route::get('/calendar', 'index')->name('calendar.index');
        Route::get('/calendar/sync', 'sync');
        Route::post('/calendar/store', 'store');
        Route::post('/calendar/update', 'update');
        Route::get('/calendar/edit/{id}', 'edit');
        Route::get('/calendar/delete/{id}', 'delete');
    });
    Route::controller(ProyekController::class)->middleware('cek_login:proyek.index')->group(function () {
        Route::get('/proyek', 'index')->name('proyek.index');
        Route::get('/proyek/sync', 'sync');
        Route::post('/proyek/store', 'store');
        Route::post('/proyek/update', 'update');
        Route::get('/proyek/edit/{id}', 'edit');
        Route::get('/proyek/delete/{id}', 'delete');
        Route::get('/proyek/detail/{id}', 'detail');
    });
    Route::controller(SuratMenyuratController::class)->middleware('cek_login:surat_menyurat.index')->group(function () {
        Route::get('/surat_menyurat', 'index')->name('surat_menyurat.index');
        Route::get('/surat_menyurat/sync', 'sync');
        Route::post('/surat_menyurat/store', 'store');
        Route::post('/surat_menyurat/update', 'update');
        Route::get('/surat_menyurat/edit/{id}', 'edit');
        Route::get('/surat_menyurat/doc/{id}', 'doc');
        Route::post('/surat_menyurat/store_doc', 'store_doc');
        Route::get('/surat_menyurat/delete/{id}', 'delete');
        Route::get('/surat_menyurat/delete_doc/{id}', 'delete_doc');
    });
    Route::controller(DokAdmController::class)->middleware('cek_login:dok_adm.index')->group(function () {
        Route::get('/dok_adm', 'index')->name('dok_adm.index');
        Route::get('/dok_adm/sync', 'sync');
        Route::post('/dok_adm/store', 'store');
        Route::post('/dok_adm/update', 'update');
        Route::get('/dok_adm/edit/{id}', 'edit');
        Route::get('/dok_adm/doc/{id}', 'doc');
        Route::post('/dok_adm/store_doc', 'store_doc');
        Route::get('/dok_adm/delete/{id}', 'delete');
        Route::get('/dok_adm/delete_doc/{id}', 'delete_doc');
    });
    Route::controller(MaterialApprovalController::class)->middleware('cek_login:material_approval.index')->group(function () {
        Route::get('/material_approval', 'index')->name('material_approval.index');
        Route::get('/material_approval/sync', 'sync');
        Route::post('/material_approval/store', 'store');
        Route::post('/material_approval/dokumen_proses_store', 'dokumen_proses_store');
        Route::post('/material_approval/update', 'update');
        Route::post('/material_approval/dokumen_proses_update', 'dokumen_proses_update');
        Route::get('/material_approval/edit/{id}', 'edit');
        Route::get('/material_approval/dokumen_proses_edit/{id}', 'dokumen_proses_edit');
        Route::get('/material_approval/doc/{id}', 'doc');
        Route::post('/material_approval/store_doc', 'store_doc');
        Route::get('/material_approval/delete/{id}', 'delete');
        Route::get('/material_approval/delete_proses_store/{id}', 'delete_proses_store');
        Route::get('/material_approval/delete_doc/{id}', 'delete_doc');
    });
    Route::controller(IjinPelaksanaanController::class)->middleware('cek_login:ijin_pelaksanaan.index')->group(function () {
        Route::get('/ijin_pelaksanaan', 'index')->name('ijin_pelaksanaan.index');
        Route::get('/ijin_pelaksanaan/sync', 'sync');
        Route::post('/ijin_pelaksanaan/store', 'store');
        Route::post('/ijin_pelaksanaan/dokumen_proses_store', 'dokumen_proses_store');
        Route::post('/ijin_pelaksanaan/update', 'update');
        Route::post('/ijin_pelaksanaan/dokumen_proses_update', 'dokumen_proses_update');
        Route::get('/ijin_pelaksanaan/edit/{id}', 'edit');
        Route::get('/ijin_pelaksanaan/dokumen_proses_edit/{id}', 'dokumen_proses_edit');
        Route::get('/ijin_pelaksanaan/doc/{id}', 'doc');
        Route::post('/ijin_pelaksanaan/store_doc', 'store_doc');
        Route::get('/ijin_pelaksanaan/delete/{id}', 'delete');
        Route::get('/ijin_pelaksanaan/delete_proses_store/{id}', 'delete_proses_store');
        Route::get('/ijin_pelaksanaan/delete_doc/{id}', 'delete_doc');
    });
    Route::controller(MetodeController::class)->middleware('cek_login:metode.index')->group(function () {
        Route::get('/metode', 'index')->name('metode.index');
        Route::get('/metode/sync', 'sync');
        Route::post('/metode/store', 'store');
        Route::post('/metode/dokumen_proses_store', 'dokumen_proses_store');
        Route::post('/metode/update', 'update');
        Route::post('/metode/dokumen_proses_update', 'dokumen_proses_update');
        Route::get('/metode/edit/{id}', 'edit');
        Route::get('/metode/dokumen_proses_edit/{id}', 'dokumen_proses_edit');
        Route::get('/metode/doc/{id}', 'doc');
        Route::post('/metode/store_doc', 'store_doc');
        Route::get('/metode/delete/{id}', 'delete');
        Route::get('/metode/delete_proses_store/{id}', 'delete_proses_store');
        Route::get('/metode/delete_doc/{id}', 'delete_doc');
    });
    Route::controller(GambarKerjaController::class)->middleware('cek_login:gambar_kerja.index')->group(function () {
        Route::get('/gambar_kerja', 'index')->name('gambar_kerja.index');
        Route::get('/gambar_kerja/sync', 'sync');
        Route::post('/gambar_kerja/store', 'store');
        Route::post('/gambar_kerja/dokumen_proses_store', 'dokumen_proses_store');
        Route::post('/gambar_kerja/uraian_gambar_kerja_store', 'uraian_gambar_kerja_store');
        Route::post('/gambar_kerja/update', 'update');
        Route::post('/gambar_kerja/dokumen_proses_update', 'dokumen_proses_update');
        Route::post('/gambar_kerja/uraian_gambar_kerja_update', 'uraian_gambar_kerja_update');
        Route::get('/gambar_kerja/edit/{id}', 'edit');
        Route::get('/gambar_kerja/dokumen_proses_edit/{id}', 'dokumen_proses_edit');
        Route::get('/gambar_kerja/uraian_gambar_kerja_edit/{id}', 'uraian_gambar_kerja_edit');
        Route::get('/gambar_kerja/doc/{id}', 'doc');
        Route::post('/gambar_kerja/store_doc', 'store_doc');
        Route::get('/gambar_kerja/delete/{id}', 'delete');
        Route::get('/gambar_kerja/delete_proses_store/{id}', 'delete_proses_store');
        Route::get('/gambar_kerja/delete_doc/{id}', 'delete_doc');
    });
    Route::controller(NotulenController::class)->middleware('cek_login:notulen.index')->group(function () {
        Route::get('/notulen', 'index')->name('notulen.index');
        Route::get('/notulen/sync', 'sync');
        Route::post('/notulen/store', 'store');
        Route::post('/notulen/dokumen_proses_store', 'dokumen_proses_store');
        Route::post('/notulen/update', 'update');
        Route::post('/notulen/dokumen_proses_update', 'dokumen_proses_update');
        Route::get('/notulen/edit/{id}', 'edit');
        Route::get('/notulen/dokumen_proses_edit/{id}', 'dokumen_proses_edit');
        Route::get('/notulen/doc/{id}', 'doc');
        Route::post('/notulen/store_doc', 'store_doc');
        Route::get('/notulen/delete/{id}', 'delete');
        Route::get('/notulen/delete_proses_store/{id}', 'delete_proses_store');
        Route::get('/notulen/delete_doc/{id}', 'delete_doc');
    });
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'index')->name('profile.index');
        Route::get('/profile/sync', 'sync');
        Route::post('/profile/alamat', 'alamat');
        Route::post('/profile/kontak', 'kontak');
        Route::post('/profile/updateProfile', 'updateProfile');
        Route::post('/profile/update_data_diri', 'update_data_diri');
        Route::post('/profile/tambah_keluarga', 'tambah_keluarga');
        Route::post('/profile/update_alamat', 'update_alamat');
        Route::post('/profile/tambah_pendidikan', 'tambah_pendidikan');
        Route::post('/profile/tambah_pekerjaan', 'tambah_pekerjaan');
        Route::post('/profile/tambah_pelatihan', 'tambah_pelatihan');
        Route::get('/profile/hapus_pendidikan/{id}', 'hapus_pendidikan');
        Route::get('/profile/hapus_keluarga/{id}', 'hapus_keluarga');
        Route::get('/profile/hapus_pekerjaan/{id}', 'hapus_pekerjaan');
        Route::get('/profile/hapus_pelatihan/{id}', 'hapus_pelatihan');
        Route::get('/profile/table_keluarga/{id}', 'table_keluarga');
        Route::get('/profile/table_pendidikan/{id}', 'table_pendidikan');
        Route::get('/profile/table_riwayat_pekerjaan/{id}', 'table_riwayat_pekerjaan');
        Route::get('/profile/table_pelatihan/{id}', 'table_pelatihan');
    });
    Route::controller(ProgressController::class)->middleware('cek_login:progres.index')->group(function () {
        Route::get('/progres', 'index')->name('progres.index');
        Route::get('/progres/sync', 'sync');
        Route::post('/progres/store', 'store');
        Route::post('/progres/progress_detail_store', 'progress_detail_store');
        Route::post('/progres/update', 'update');
        Route::post('/progres/progres_detail_update', 'progres_detail_update');
        Route::get('/progres/edit/{id}', 'edit');
        Route::get('/progres/progres_detail_edit/{id}', 'progres_detail_edit');
        Route::get('/progres/doc/{id}', 'doc');
        Route::post('/progres/store_doc', 'store_doc');
        Route::get('/progres/delete/{id}', 'delete');
        Route::get('/progres/delete_proses_store/{id}', 'delete_proses_store');
        Route::get('/progres/delete_doc/{id}', 'delete_doc');
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

