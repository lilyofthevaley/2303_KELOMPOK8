@extends('layouts.app')

@section('title', 'Profil Siswa')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Profil Siswa</h1>
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
@endsection