<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\GuruController;
// use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\SiswaController as AdminSiswaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Guru\AbsensiController as GuruAbsensiController;
use App\Http\Controllers\Guru\DashboardController as GuruDashboardController;
use App\Http\Controllers\Guru\ProfilController as GuruProfilController;
use App\Http\Controllers\Guru\SiswaController as GuruSiswaController;
use App\Http\Controllers\Siswa\AbsensiController as SiswaAbsensiController;
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;
use App\Http\Controllers\Siswa\ProfilController as SiswaProfilController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Authentication Routes
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/siswa', [AdminSiswaController::class, 'index'])->name('admin.siswa.index');
    Route::get('/admin/guru', [GuruController::class, 'index'])->name('admin.guru.index');
    Route::get('/admin/siswa/create', [AdminSiswaController::class, 'create'])->name('admin.siswa.create');
    Route::get('admin/guru/create', [GuruController::class, 'create'])->name('admin.guru.create');
    Route::post('/admin/siswa', [AdminSiswaController::class, 'store'])->name('admin.siswa.store');
    Route::post('/admin/guru', [GuruController::class, 'store'])->name('admin.guru.store');
    Route::get('/admin/siswa/{siswa}', [AdminSiswaController::class, 'show'])->name('admin.siswa.show');
    Route::get('/admin/guru/{guru}', [GuruController::class, 'show'])->name('admin.guru.show');
    Route::get('/admin/siswa/{siswa}/edit', [AdminSiswaController::class, 'edit'])->name('admin.siswa.edit');
    Route::get('/admin/guru/{guru}/edit', [GuruController::class, 'edit'])->name('admin.guru.edit');
    Route::put('/admin/siswa/{siswa}', [AdminSiswaController::class, 'update'])->name('admin.siswa.update');
    Route::put('/admin/guru/{guru}', [GuruController::class, 'update'])->name('admin.guru.update');
    Route::delete('/admin/siswa/{siswa}', [AdminSiswaController::class, 'destroy'])->name('admin.siswa.destroy');
    Route::delete('/admin/guru/{guru}', [GuruController::class, 'destroy'])->name('admin.guru.destroy');
    
    // Siswa Management
    // Route::resource('siswa', SiswaController::class);
    
    // Guru Management
    // Route::resource('guru', GuruController::class);
});

// Guru Routes
Route::prefix('guru')->middleware(['auth'])->group(function () {
    Route::get('/guru/dashboard', [GuruDashboardController::class, 'index'])->name('guru.dashboard');
    Route::get('/profil', [GuruProfilController::class, 'index'])->name('guru.profil');
    Route::get('/guru/siswa', [GuruSiswaController::class, 'index'])->name('guru.siswa.index');
    Route::get('/guru/siswa/{siswa}', [GuruSiswaController::class, 'show'])->name('guru.siswa.show');
    Route::get('/guru/siswa/{siswa}/edit', [GuruSiswaController::class, 'edit'])->name('guru.siswa.edit');
    Route::put('/guru/siswa/{siswa}', [GuruSiswaController::class, 'update'])->name('guru.siswa.update');

    // Siswa Management
    Route::resource('siswa', GuruSiswaController::class)->only(['index', 'show', 'edit', 'update']);
    
    // Absensi Management
    // Route::get('/guru/absensi/export', [GuruAbsensiController::class, 'exportAbsensi'])->name('guru.absensi.export');
    Route::get('/guru/absensi/export-csv', [App\Http\Controllers\Guru\AbsensiController::class, 'exportAbsensi'])->name('guru.absensi.export.csv');
    Route::get('/guru/absensi', [GuruAbsensiController::class, 'index'])->name('guru.absensi.index');
    Route::put('/guru/absensi/{absensi}/confirm', [GuruAbsensiController::class, 'confirm'])->name('guru.absensi.confirm');
    Route::get('/guru/absensi/import', [GuruAbsensiController::class, 'importExcel'])->name('guru.absensi.import');
    Route::post('/guru/absensi/import', [GuruAbsensiController::class, 'storeExcel'])->name('guru.absensi.store');

});

// Siswa Routes
Route::prefix('siswa')->middleware(['auth'])->name('siswa.')->group(function () {
    Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profil', [SiswaProfilController::class, 'index'])->name('profil');
    
    // Absensi
    Route::get('/absensi', [SiswaAbsensiController::class, 'index'])->name('absensi.index');
    Route::get('/absensi/create', [SiswaAbsensiController::class, 'create'])->name('absensi.create');
    Route::post('/absensi', [SiswaAbsensiController::class, 'store'])->name('absensi.store');
    Route::get('/absensi/{absensi}/edit', [SiswaAbsensiController::class, 'edit'])->name('absensi.edit');
    Route::put('/absensi/{absensi}', [SiswaAbsensiController::class, 'update'])->name('absensi.update');
});