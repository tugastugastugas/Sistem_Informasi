<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\UserLevelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RestoreEditController;
use App\Http\Controllers\RestoreDeleteController;
use App\Http\Controllers\PengumumanSekolahController;
use App\Http\Controllers\PengumumanGuruController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\KelasController;

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
    return view('welcome');
});

Route::get('/dashboard', [Controller::class, 'dashboard'])->name('dashboard');
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/aksi_login', [LoginController::class, 'aksi_login'])->name('aksi_login');
Route::get('/register', [LoginController::class, 'register'])->name('register');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/tambah_akun', [LoginController::class, 'tambah_akun'])->name('tambah_akun');
Route::get('/captcha', [LoginController::class, 'captcha'])->name('captcha');


// ROUTE SETTING
Route::get('settings', [SettingController::class, 'edit'])
    ->middleware('check.permission:setting')
    ->name('settings.edit');
Route::post('settings', [SettingController::class, 'update'])
    ->name('settings.update');

// ROUTE LOG ACTIVITY
Route::get('log', [LogController::class, 'index'])
    ->middleware('check.permission:setting')
    ->name('log');

// ROUTE PERMISSION
Route::get('/user-levels', [UserLevelController::class, 'index'])
    ->middleware('check.permission:setting')
    ->name('user.levels');
Route::get('/menu-permissions/{userLevel}', [UserLevelController::class, 'showMenuPermissions'])
    ->name('menu.permissions');
Route::post('/save-permissions', [UserLevelController::class, 'savePermissions'])
    ->name('save.permissions');

// ROUTE RESTORE EDIT
Route::get('/restore_e', [RestoreEditController::class, 'restore_e'])
    ->middleware('check.permission:setting')
    ->name('restore_e');
Route::post('/user/restore/{id_user}', [RestoreEditController::class, 'restoreEdit'])->name('user.restoreEdit');
Route::delete('/user_history/{id_user_history}', [RestoreEditController::class, 're_destroy'])->name('re.destroy');

// ROUTE RESTORE DELETE
Route::get('/restore_d', [RestoreDeleteController::class, 'restore_d'])
    ->middleware('check.permission:setting')
    ->name('restore_d');
Route::post('/user/restore-delete/{id}', [RestoreDeleteController::class, 'user_restore'])->name('user.restore');
Route::delete('/user/{id}', [RestoreDeleteController::class, 'rd_destroy'])->name('rd.destroy');

// ROUTE USER
Route::get('/user', [UserController::class, 'user'])
    ->middleware('check.permission:setting')
    ->name('user');
Route::post('/t_user', [UserController::class, 't_user'])->name('t_user');
Route::post('/user/reset-password/{id}', [UserController::class, 'resetPassword'])->name('user.resetPassword');
Route::post('/user/update', [UserController::class, 'updateDetail'])->name('update.user');
Route::delete('/user-destroy/{id_user}', [UserController::class, 'user_destroy'])->name('user.destroy');
Route::get('/user/detail/{id}', [UserController::class, 'detail'])->name('detail');

// ROUTE PENGUMUMAN SEKOLAH
Route::get('/pengumuman_umum', [PengumumanSekolahController::class, 'pengumuman_sekolah'])->name('pengumuman_umum');
Route::post('buat_pengumuman', [PengumumanSekolahController::class, 'buat_pengumuman'])
    ->name('buat_pengumuman');
Route::put('/pengumuman_sekolah/update/{id}', [PengumumanSekolahController::class, 'update'])->name('pengumuman_sekolah.update'); // Pastikan ini ada
Route::delete('/pengumuman_sekolah/{id_pengumuman_sekolah}', [PengumumanSekolahController::class, 'pengumuman_sekolah_destroy'])->name('pengumuman_sekolah.destroy');


// ROUTE PENGUMUMAN GURU
Route::get('/pengumuman_terpilih', [PengumumanGuruController::class, 'pengumuman_guru'])->name('pengumuman_terpilih');
Route::post('buat_pengumuman_guru', [PengumumanGuruController::class, 'buat_pengumuman_guru'])
    ->name('buat_pengumuman_guru');
Route::put('/pengumuman_guru/update/{id}', [PengumumanGuruController::class, 'update'])->name('pengumuman_guru.update'); // Pastikan ini ada
Route::delete('/pengumuman_guru/{id_pengumuman_guru}', [PengumumanGuruController::class, 'pengumuman_guru_destroy'])->name('pengumuman_guru.destroy');


// ROUTE Jurusan
Route::get('/view_jurusan', [JurusanController::class, 'view_jurusan'])->name('view_jurusan');
Route::post('buat_jurusan', [JurusanController::class, 'buat_jurusan'])
    ->name('buat_jurusan');
Route::put('/jurusan/update/{id}', [JurusanController::class, 'update'])->name('jurusan.update'); // Pastikan ini ada
Route::delete('/jurusan/{id_jurusan}', [JurusanController::class, 'jurusan_destroy'])->name('jurusan.destroy');


// ROUTE Kelas
Route::get('/view_kelas', [KelasController::class, 'view_kelas'])->name('view_kelas');
Route::post('buat_kelas', [KelasController::class, 'buat_kelas'])
    ->name('buat_kelas');
Route::put('/kelas/update/{id}', [KelasController::class, 'update'])->name('kelas.update'); // Pastikan ini ada
Route::delete('/kelas/{id_kelas}', [KelasController::class, 'kelas_destroy'])->name('kelas.destroy');
Route::post('/murid/store', [KelasController::class, 'murid_store'])->name('murid.store');
Route::get('/kelas/{id}/murid', [KelasController::class, 'getMuridByKelas']);
Route::delete('/murid/{id}/hapus', [KelasController::class, 'hapusMurid'])->name('murid.hapus');


// ROUTE SHARE
Route::post('/send-email', [PengumumanSekolahController::class, 'sendEmail']);
Route::post('/send-email-guru', [PengumumanGuruController::class, 'sendEmail']);

Route::post('/send-whatsapp', [PengumumanSekolahController::class, 'sendWhatsapp']);
