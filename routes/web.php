<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\GuruController as AdminGuruController;
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
    Route::get('/admin/guru', [AdminGuruController::class, 'index'])->name('admin.guru');
    Route::get('/admin/siswa/create', [AdminSiswaController::class, 'create'])->name('admin.siswa.create');
    Route::post('/admin/siswa/store',[AdminSiswaController::class,'store'])->name('admin.siswa.store');
    Route::get('/admin/guru/create', [AdminGuruController::class, 'create'])->name('admin.guru.create');
    Route::post('/admin/guru/store',[AdminGuruController::class,'store'])->name('admin.guru.store');
    Route::get('/admin/siswa/show/{siswa}', [AdminSiswaController::class, 'show'])->name('admin.siswa.show');
    Route::get('/admin/siswa/edit/{siswa}', [AdminSiswaController::class, 'edit'])->name('admin.siswa.edit');
    Route::put('/admin/siswa/update/{siswa}', [AdminSiswaController::class, 'update'])->name('admin.siswa.update');
    Route::delete('/admin/siswa/destroy/{siswa}', [AdminSiswaController::class, 'destroy'])->name('admin.siswa.destroy');
    Route::get('/admin/guru/show/{guru}', [AdminGuruController::class, 'show'])->name('admin.guru.show');
    Route::get('/admin/guru/edit/{guru}', [AdminGuruController::class, 'edit'])->name('admin.guru.edit');
    Route::put('/admin/guru/update/{guru}', [AdminGuruController::class, 'update'])->name('admin.guru.update');
    Route::delete('/admin/guru/destroy/{guru}', [AdminGuruController::class, 'destroy'])->name('admin.guru.destroy');
    
    
  
});

// Guru Routes
Route::prefix('guru')->middleware(['auth', 'role:guru'])->name('guru.')->group(function () {
    Route::get('/guru/dashboard', [GuruDashboardController::class, 'index'])->name('guru.dashboard');
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