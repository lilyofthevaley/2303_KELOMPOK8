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
    Route::get('/admin/siswa', [AdminSiswaController::class, 'index'])->name('admin.siswa');
    Route::get('/admin/guru', [GuruSiswaController::class, 'index'])->name('admin.guru');
    Route::get('/admin/siswa/create', [AdminSiswaController::class, 'create'])->name('admin.siswa.create');
    
    // Siswa Management
    Route::resource('siswa', SiswaController::class);
    
    // Guru Management
    Route::resource('guru', GuruController::class);
});

// Guru Routes
Route::prefix('guru')->middleware(['auth', 'role:guru'])->name('guru.')->group(function () {
    Route::get('/dashboard', [GuruDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profil', [GuruProfilController::class, 'index'])->name('profil');
    
    // Siswa Management
    Route::resource('siswa', GuruSiswaController::class)->only(['index', 'show', 'edit', 'update']);
    
    // Absensi Management
    Route::get('/absensi', [GuruAbsensiController::class, 'index'])->name('absensi.index');
    Route::put('/absensi/{absensi}/confirm', [GuruAbsensiController::class, 'confirm'])->name('absensi.confirm');
    Route::get('/absensi/export', [GuruAbsensiController::class, 'exportExcel'])->name('absensi.export');
});

// Siswa Routes
Route::prefix('siswa')->middleware(['auth', 'role:siswa'])->name('siswa.')->group(function () {
    Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profil', [SiswaProfilController::class, 'index'])->name('profil');
    
    // Absensi
    Route::get('/absensi', [SiswaAbsensiController::class, 'index'])->name('absensi.index');
    Route::get('/absensi/create', [SiswaAbsensiController::class, 'create'])->name('absensi.create');
    Route::post('/absensi', [SiswaAbsensiController::class, 'store'])->name('absensi.store');
});