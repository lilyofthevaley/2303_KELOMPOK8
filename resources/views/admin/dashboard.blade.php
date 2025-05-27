@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Admin</h1>
        <p class="mb-4">Selamat datang di Sistem Absensi Sekolah</p>
    </div>
</div>

<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Siswa</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\Siswa::count() }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-graduate fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Guru</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\Guru::count() }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Absensi Hari Ini</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ \App\Models\Absensi::whereDate('tanggal', date('Y-m-d'))->count() }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Menunggu Konfirmasi</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ \App\Models\Absensi::where('is_confirmed', false)->count() }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clock fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-user-graduate"></i> Data Siswa
                </h6>
            </div>
            <div class="card-body">
                <p>Kelola data siswa termasuk NIS, nama, kelas, jurusan, dan informasi lainnya.</p>
                <a href="{{ url('admin/siswa') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-right"></i> Lihat Data Siswa
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-chalkboard-teacher"></i> Data Guru
                </h6>
            </div>
            <div class="card-body">
                <p>Kelola data guru termasuk NIP, nama, mata pelajaran, dan informasi lainnya.</p>
                <a href="{{ url('admin/guru') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-right"></i> Lihat Data Guru
                </a>
            </div>
        </div>
    </div>
</div>
@endsection