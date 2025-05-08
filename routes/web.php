<?php

use App\Http\Controllers\BerandaController;
use App\Http\Controllers\KonsultasiController;
use App\Http\Controllers\TesController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EditProfileController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\KecerdasanMajemukController;
use App\Http\Controllers\PertanyaanKecerdasanController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\SubKriteriaController;
use App\Http\Controllers\KasusLamaController;
use App\Http\Controllers\KasusBaruController;
use App\Http\Controllers\ReviseController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\HasilController;
use App\Http\Controllers\ProfileKampusController;

use Illuminate\Support\Facades\Route;



// ROUTE PENGGUNA
// Route::get('/', [BerandaController::class, 'index']);
Route::get('/', [BerandaController::class, 'index'])->name('pengguna.beranda');

Route::prefix('pengguna')->group(function () {
    Route::get('/konsultasi', [KonsultasiController::class, 'index'])->name('pengguna.konsultasi.index');
    Route::post('/konsultasi', [KonsultasiController::class, 'store'])->name('konsultasi.store');
    Route::get('/tes', [TesController::class, 'index'])->name('pengguna.tes.index');
    Route::post('/tes', [TesController::class, 'store'])->name('tes.store');
    Route::post('/simpan-jawaban', [TesController::class, 'simpanJawaban'])->name('simpanJawaban');
    // Route::get('/hasil', function () { return view('pengguna.konsultasi.hasil');
    // })->name('pengguna.konsultasi.hasil');
    Route::get('/hasil', [HasilController::class, 'index'])->name('pengguna.konsultasi.hasil');
});

// Route Login dan Logout
Route::get('/login', [LoginController::class, 'index'])->name('login.index')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate')->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])->name('login.logout')->middleware(['auth', 'no-back']);
Route::group(['prefix' => 'profile'], function(){
    Route::get('/{id}/edit', [EditProfileController::class, 'edit'])->name('profile.edit')->middleware(['auth', 'no-back']);
    Route::put('/{id}', [EditProfileController::class, 'update'])->name('profile.update')->middleware(['auth', 'no-back']);
    Route::get('/logout-notice', [EditProfileController::class, 'logoutNotice'])->name('profile.logout-notice')->middleware(['auth', 'no-back']);
});


// Route Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

// ROUTE SUPER ADMIN 
// kelola user
Route::prefix('user')->group(function() {
    Route::get('/', [UserController::class, 'index'])->name('admin.user.index');
    Route::post('/list', [UserController::class, 'list'])->name('admin.user.list');
    Route::get('/create', [UserController::class, 'create'])->name('admin.user.create');
    Route::post('/', [UserController::class, 'store'])->name('admin.user.store');
    Route::get('/{id}', [UserController::class, 'show'])->name('admin.user.show');
    Route::get('/{id}/edit', [UserController::class, 'edit'])->name('admin.user.edit');
    Route::put('/{id}', [UserController::class, 'update'])->name('admin.user.update');
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('admin.user.destroy');
});

// kelola jurusan
Route::prefix('jurusan')->group(function() {
    Route::get('/', [JurusanController::class, 'index'])->name('admin.jurusan.index');
    Route::post('/list', [JurusanController::class, 'list'])->name('admin.jurusan.list');
    Route::get('/create', [JurusanController::class, 'create'])->name('admin.jurusan.create');
    Route::post('/', [JurusanController::class, 'store'])->name('admin.jurusan.store');
    Route::get('/{id}', [JurusanController::class, 'show'])->name('admin.jurusan.show');
    Route::get('/{id}/edit', [JurusanController::class, 'edit'])->name('admin.jurusan.edit');
    Route::put('/{id}', [JurusanController::class, 'update'])->name('admin.jurusan.update');
    Route::delete('/{id}', [JurusanController::class, 'destroy'])->name('admin.jurusan.destroy');
});

// kelola prodi
Route::prefix('prodi')->group(function() {
    Route::get('/', [ProdiController::class, 'index'])->name('admin.prodi.index');
    Route::post('/list', [ProdiController::class, 'list'])->name('admin.prodi.list');
    Route::get('/create', [ProdiController::class, 'create'])->name('admin.prodi.create');
    Route::post('/', [ProdiController::class, 'store'])->name('admin.prodi.store');
    Route::get('/{id}', [ProdiController::class, 'show'])->name('admin.prodi.show');
    Route::get('/{id}/edit', [ProdiController::class, 'edit'])->name('admin.prodi.edit');
    Route::put('/{id}', [ProdiController::class, 'update'])->name('admin.prodi.update');
    Route::delete('/{id}', [ProdiController::class, 'destroy'])->name('admin.prodi.destroy');
});

// kelola kecerdasan majemuk
Route::prefix('kecerdasan_majemuk')->group(function() {
    Route::get('/', [KecerdasanMajemukController::class, 'index'])->name('admin.kecerdasan_majemuk.index');
    Route::post('/list', [KecerdasanMajemukController::class, 'list'])->name('admin.kecerdasan_majemuk.list');
    Route::get('/create', [KecerdasanMajemukController::class, 'create'])->name('admin.kecerdasan_majemuk.create');
    Route::post('/', [KecerdasanMajemukController::class, 'store'])->name('admin.kecerdasan_majemuk.store');
    Route::get('/{id}', [KecerdasanMajemukController::class, 'show'])->name('admin.kecerdasan_majemuk.show');
    Route::get('/{id}/edit', [KecerdasanMajemukController::class, 'edit'])->name('admin.kecerdasan_majemuk.edit');
    Route::put('/{id}', [KecerdasanMajemukController::class, 'update'])->name('admin.kecerdasan_majemuk.update');
    Route::delete('/{id}', [KecerdasanMajemukController::class, 'destroy'])->name('admin.kecerdasan_majemuk.destroy');
});

// kelola kecerdasan majemuk
Route::prefix('pertanyaan_kecerdasan')->group(function() {
    Route::get('/', [PertanyaanKecerdasanController::class, 'index'])->name('admin.pertanyaan_kecerdasan.index');
    Route::post('/list', [PertanyaanKecerdasanController::class, 'list'])->name('admin.pertanyaan_kecerdasan.list');
    Route::get('/create', [PertanyaanKecerdasanController::class, 'create'])->name('admin.pertanyaan_kecerdasan.create');
    Route::post('/', [PertanyaanKecerdasanController::class, 'store'])->name('admin.pertanyaan_kecerdasan.store');
    Route::get('/{id}', [PertanyaanKecerdasanController::class, 'show'])->name('admin.pertanyaan_kecerdasan.show');
    Route::get('/{id}/edit', [PertanyaanKecerdasanController::class, 'edit'])->name('admin.pertanyaan_kecerdasan.edit');
    Route::put('/{id}', [PertanyaanKecerdasanController::class, 'update'])->name('admin.pertanyaan_kecerdasan.update');
    Route::delete('/{id}', [PertanyaanKecerdasanController::class, 'destroy'])->name('admin.pertanyaan_kecerdasan.destroy');
});

// kelola kriteria
Route::prefix('kriteria')->group(function() {
    Route::get('/', [KriteriaController::class, 'index'])->name('admin.kriteria.index');
    Route::post('/list', [KriteriaController::class, 'list'])->name('admin.kriteria.list');
    Route::get('/create', [KriteriaController::class, 'create'])->name('admin.kriteria.create');
    Route::post('/', [KriteriaController::class, 'store'])->name('admin.kriteria.store');
    Route::get('/{id}', [KriteriaController::class, 'show'])->name('admin.kriteria.show');
    Route::get('/{id}/edit', [KriteriaController::class, 'edit'])->name('admin.kriteria.edit');
    Route::put('/{id}', [KriteriaController::class, 'update'])->name('admin.kriteria.update');
    Route::delete('/{id}', [KriteriaController::class, 'destroy'])->name('admin.kriteria.destroy');
});

// kelola sub kriteria
Route::prefix('sub_kriteria')->group(function() {
    Route::get('/', [SubKriteriaController::class, 'index'])->name('admin.sub_kriteria.index');
    Route::post('/list', [SubKriteriaController::class, 'list'])->name('admin.sub_kriteria.list');
    Route::get('/create', [SubKriteriaController::class, 'create'])->name('admin.sub_kriteria.create');
    Route::post('/', [SubKriteriaController::class, 'store'])->name('admin.sub_kriteria.store');
    Route::get('/{id}', [SubKriteriaController::class, 'show'])->name('admin.sub_kriteria.show');
    Route::get('/{id}/edit', [SubKriteriaController::class, 'edit'])->name('admin.sub_kriteria.edit');
    Route::put('/{id}', [SubKriteriaController::class, 'update'])->name('admin.sub_kriteria.update');
    Route::delete('/{id}', [SubKriteriaController::class, 'destroy'])->name('admin.sub_kriteria.destroy');
});

// kelola kasus lama
Route::prefix('kasus_lama')->group(function() {
    Route::get('/', [KasusLamaController::class, 'index'])->name('admin.kasus_lama.index');
    Route::post('/list', [KasusLamaController::class, 'list'])->name('admin.kasus_lama.list');
    Route::get('/create', [KasusLamaController::class, 'create'])->name('admin.kasus_lama.create');
    Route::post('/', [KasusLamaController::class, 'store'])->name('admin.kasus_lama.store');
    Route::get('/{id}', [KasusLamaController::class, 'show'])->name('admin.kasus_lama.show');
    Route::get('/{id}/edit', [KasusLamaController::class, 'edit'])->name('admin.kasus_lama.edit');
    Route::put('/{id}', [KasusLamaController::class, 'update'])->name('admin.kasus_lama.update');
    Route::delete('/{id}', [KasusLamaController::class, 'destroy'])->name('admin.kasus_lama.destroy');
});

// kelola kasus baru revise
Route::prefix('revise')->group(function() {
    Route::get('/', [ReviseController::class, 'index'])->name('admin.revise.index');
    Route::post('/list', [ReviseController::class, 'list'])->name('admin.revise.list');
    Route::get('/create', [ReviseController::class, 'create'])->name('admin.revise.create');
    Route::post('/', [ReviseController::class, 'store'])->name('admin.revise.store');
    Route::get('/{id}', [ReviseController::class, 'show'])->name('admin.revise.show');
    Route::get('/{id}/edit', [ReviseController::class, 'edit'])->name('admin.revise.edit');
    Route::post('/revise/{id}/approve', [ReviseController::class, 'approve'])->name('admin.revise.approve');
    Route::put('/{id}', [ReviseController::class, 'update'])->name('admin.revise.update');
    Route::delete('/{id}', [ReviseController::class, 'destroy'])->name('admin.revise.destroy');
});

// Kelola Halaman Dinamis
Route::prefix('pages')->group(function() {
    Route::get('/', [PagesController::class, 'index'])->name('admin.pages.index');
    Route::post('/list', [PagesController::class, 'list'])->name('admin.pages.list');
    Route::get('/create', [PagesController::class, 'create'])->name('admin.pages.create');
    Route::post('/', [PagesController::class, 'store'])->name('admin.pages.store');
    Route::get('/{page}', [PagesController::class, 'show'])->name('admin.pages.show');
    Route::get('/{page}/edit', [PagesController::class, 'edit'])->name('admin.pages.edit');
    Route::put('/{page}', [PagesController::class, 'update'])->name('admin.pages.update');
    Route::delete('/{page}', [PagesController::class, 'destroy'])->name('admin.pages.destroy');
});

// Kelola Profile Kampus
Route::prefix('profile_kampus')->group(function () {
    Route::get('/edit', [ProfileKampusController::class, 'edit'])->name('profile_kampus.edit');
    Route::post('/update', [ProfileKampusController::class, 'update'])->name('profile_kampus.update');
});




