@extends('layouts.app')

@section('title', 'Absensi Hari Ini')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Absensi Hari Ini</h1>
    <a href="{{ route('siswa.absensi.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Absensi</h6>
    </div>
    <div class="card-body">
        <div class="alert alert-info">
            <p class="mb-0"><i class="fas fa-info-circle"></i> Silakan isi form absensi untuk hari ini, {{ date('d-m-Y') }}.</p>
        </div>
        
        <form action="{{ route('siswa.absensi.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="status" class="form-label">Status Kehadiran</label>
                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                    <option value="" disabled selected>Pilih Status Kehadiran</option>
                    <option value="hadir" {{ old('status') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                    <option value="izin" {{ old('status') == 'izin' ? 'selected' : '' }}>Izin</option>
                    <option value="sakit" {{ old('status') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan (Opsional)</label>
                <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" rows="3">{{ old('keterangan') }}</textarea>
                @error('keterangan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">Isi keterangan jika diperlukan, seperti alasan izin atau sakit.</small>
            </div>
            
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Absensi
                </button>
                <a href="{{ route('siswa.absensi.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection