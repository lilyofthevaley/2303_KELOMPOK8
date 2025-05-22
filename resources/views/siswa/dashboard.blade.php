@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Siswa</h1>
        <p class="mb-4">Selamat datang, {{ auth()->user()->nama }}</p>
    </div>
</div>

<div class="row">
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Absensi</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $siswa->absensi()->count() }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Absensi Dikonfirmasi</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $siswa->absensi()->where('is_confirmed', true)->count() }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Menunggu Konfirmasi</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $siswa->absensi()->where('is_confirmed', false)->count() }}
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
                    <i class="fas fa-user"></i> Profil Saya
                </h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="150">NIS</th>
                        <td>: {{ $siswa->nis }}</td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td>: {{ $siswa->nama }}</td>
                    </tr>
                    <tr>
                        <th>Kelas</th>
                        <td>: {{ $siswa->kelas }}</td>
                    </tr>
                    <tr>
                        <th>Jurusan</th>
                        <td>: {{ $siswa->jurusan }}</td>
                    </tr>
                </table>
                <a href="{{ route('siswa.profil') }}" class="btn btn-primary mt-3">
                    <i class="fas fa-user"></i> Lihat Profil Lengkap
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-clipboard-check"></i> Absensi Hari Ini
                </h6>
            </div>
            <div class="card-body">
                @php
                    $today = date('Y-m-d');
                    $absensiToday = $siswa->absensi()->whereDate('tanggal', $today)->first();
                @endphp

                @if($absensiToday)
                    <div class="alert alert-success">
                        <p class="mb-0"><i class="fas fa-check-circle"></i> Anda sudah melakukan absensi hari ini.</p>
                        <p class="mb-0">Status: 
                            @if($absensiToday->status == 'hadir')
                                <span class="badge bg-success">Hadir</span>
                            @elseif($absensiToday->status == 'izin')
                                <span class="badge bg-warning">Izin</span>
                            @elseif($absensiToday->status == 'sakit')
                                <span class="badge bg-info">Sakit</span>
                            @else
                                <span class="badge bg-danger">Alfa</span>
                            @endif
                        </p>
                        <p class="mb-0">Waktu: {{ $absensiToday->waktu }}</p>
                        @if($absensiToday->is_confirmed)
                            <p class="mb-0 mt-2"><span class="badge bg-success">Sudah Dikonfirmasi</span></p>
                        @else
                            <p class="mb-0 mt-2"><span class="badge bg-warning">Menunggu Konfirmasi</span></p>
                        @endif
                    </div>
                @else
                    <div class="alert alert-warning">
                        <p class="mb-0"><i class="fas fa-exclamation-circle"></i> Anda belum melakukan absensi hari ini.</p>
                    </div>
                    <a href="{{ route('siswa.absensi.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Absensi Sekarang
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Absensi Terakhir</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th>Status Konfirmasi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswa->absensi()->orderBy('tanggal', 'desc')->take(5)->get() as $absensi)
                    <tr>
                        <td>{{ date('d-m-Y', strtotime($absensi->tanggal)) }}</td>
                        <td>{{ $absensi->waktu }}</td>
                        <td>
                            @if($absensi->status == 'hadir')
                                <span class="badge bg-success">Hadir</span>
                            @elseif($absensi->status == 'izin')
                                <span class="badge bg-warning">Izin</span>
                            @elseif($absensi->status == 'sakit')
                                <span class="badge bg-info">Sakit</span>
                            @else
                                <span class="badge bg-danger">Alfa</span>
                            @endif
                        </td>
                        <td>{{ $absensi->keterangan ?? '-' }}</td>
                        <td>
                            @if($absensi->is_confirmed)
                                <span class="badge bg-success">Dikonfirmasi</span>
                            @else
                                <span class="badge bg-warning">Menunggu Konfirmasi</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada data absensi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            <a href="{{ route('siswa.absensi.index') }}" class="btn btn-primary">
                <i class="fas fa-list"></i> Lihat Semua Absensi
            </a>
        </div>
    </div>
</div>
@endsection