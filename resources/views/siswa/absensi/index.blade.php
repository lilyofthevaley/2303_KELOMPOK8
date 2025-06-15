@extends('layouts.app')

@section('title', 'Riwayat Absensi')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Riwayat Absensi</h1>
    <a href="{{ route('siswa.absensi.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Absensi Hari Ini
    </a>
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
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th>Status Konfirmasi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($absensi as $a)
                    <tr>
                        <td>{{ date('d-m-Y', strtotime($a->tanggal)) }}</td>
                        <td>{{ $a->waktu }}</td>
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
                            <div style="display: flex; align-items: center; gap: 8px;">
                                @if($a->is_confirmed)
                                    <span class="badge bg-success">Dikonfirmasi</span>
                                    <a href="#" class="btn btn-sm btn-secondary disabled" style="pointer-events: none; opacity: 0.7;"><i class="fas fa-edit"></i> Edit</a>
                                @else
                                    <span class="badge bg-warning">Menunggu Konfirmasi</span>
                                    <a href="{{ route('siswa.absensi.edit', $a->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Edit</a>
                                @endif
                            </div>
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
        
        <div class="mt-4">
            {{ $absensi->links() }}
        </div>
    </div>
</div>
@endsection