@extends('layouts.app')

@section('title', 'Profil Guru')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Profil Guru</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Informasi Guru</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <th width="150">NIP</th>
                        <td>: {{ $guru->nip }}</td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td>: {{ $guru->nama }}</td>
                    </tr>
                    <tr>
                        <th>Mata Pelajaran</th>
                        <td>: {{ $guru->mata_pelajaran }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <th width="150">No. Telepon</th>
                        <td>: {{ $guru->no_telp }}</td>
                    </tr>
                    <tr>
                        <th>Tempat Lahir</th>
                        <td>: {{ $guru->tempat_lahir }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Lahir</th>
                        <td>: {{ date('d-m-Y', strtotime($guru->tanggal_lahir)) }}</td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>: {{ $guru->alamat }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection