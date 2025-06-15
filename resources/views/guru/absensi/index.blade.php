@extends('layouts.app')

@section('title', 'Konfirmasi Absensi')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Konfirmasi Absensi</h1>
    <a href="{{ route('guru.absensi.export.csv') }}" class="btn btn-success">
    Export CSV
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Filter Absensi</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('guru.absensi.index') }}" method="GET">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ request('tanggal') ? date('Y-m-d', strtotime(request('tanggal'))) : '' }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Semua Status</option>
                        <option value="hadir" {{ request('status') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                        <option value="izin" {{ request('status') == 'izin' ? 'selected' : '' }}>Izin</option>
                        <option value="sakit" {{ request('status') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                        <option value="alfa" {{ request('status') == 'alfa' ? 'selected' : '' }}>Alfa</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="confirmed" class="form-label">Status Konfirmasi</label>
                    <select class="form-select" id="confirmed" name="confirmed">
                        <option value="">Semua</option>
                        <option value="yes" {{ request('confirmed') == 'yes' ? 'selected' : '' }}>Sudah Dikonfirmasi</option>
                        <option value="no" {{ request('confirmed') == 'no' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Absensi</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>NIS</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($absensi as $a)
                    <tr>
                        <td>{{ date('d-m-Y', strtotime($a->tanggal)) }}</td>
                        <td>{{ $a->waktu }}</td>
                        <td>{{ $a->siswa->nis }}</td>
                        <td>{{ $a->siswa->nama }}</td>
                        <td>{{ $a->siswa->kelas }} {{ $a->siswa->jurusan }}</td>
                        <td>
                            @if($a->status == 'hadir')
                                <span class="badge bg-success">Hadir</span>
                            @elseif($a->status == 'izin')
                                <span class="badge bg-warning">Izin</span>
                            @elseif($a->status == 'sakit')
                                <span class="badge bg-info">Sakit</span>
                            @else
                                <span class="badge bg-danger">Alfa</span>
                            @endif
                        </td>
                        <td>{{ $a->keterangan ?? '-' }}</td>
                        <td>
                            @if(!$a->is_confirmed)
                                <form action="{{ route('guru.absensi.confirm', $a) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="fas fa-check"></i> Konfirmasi
                                    </button>
                                </form>
                            @else
                                <span class="badge bg-success">Sudah Dikonfirmasi</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data absensi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $absensi->links() }}
        </div>
    </div>
</div>

<!-- <div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Export Data Absensi</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('guru.absensi.export') }}" method="GET">
            <div class="row">
                <div class="col-md-5 mb-3">
                    <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                    <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="{{ request('tanggal_mulai', date('Y-m-01')) }}" required>
                </div>
                <div class="col-md-5 mb-3">
                    <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                    <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" value="{{ request('tanggal_akhir', date('Y-m-t')) }}" required>
                </div>
                <div class="col-md-2 mb-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-success w-100">
                        <i class="fas fa-file-excel"></i> Export
                    </button>
                </div>
            </div>
        </form>
    </div>
</div> -->
@endsection