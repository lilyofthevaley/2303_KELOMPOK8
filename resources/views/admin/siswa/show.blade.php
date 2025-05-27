@extends('layouts.app')

@section('title', 'Detail Siswa')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Siswa</h1>
    <div>
        <a href="{{ url('admin/siswa/edit', $siswa) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ url('admin/siswa') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Informasi Siswa</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
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
            </div>
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <th width="150">No. Telepon</th>
                        <td>: {{ $siswa->no_telp }}</td>
                    </tr>
                    <tr>
                        <th>Tempat Lahir</th>
                        <td>: {{ $siswa->tempat_lahir }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Lahir</th>
                        <td>: {{ date('d-m-Y', strtotime($siswa->tanggal_lahir)) }}</td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>: {{ $siswa->alamat }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">History Absensi</h6>
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
                    @forelse($siswa->absensi()->orderBy('tanggal', 'desc')->get() as $absensi)
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
    </div>
</div>
@endsection