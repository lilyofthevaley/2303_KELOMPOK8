<table>
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>NIS</th>
            <th>Nama Siswa</th>
            <th>Kelas</th>
            <th>Status</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($absensi as $a)
        <tr>
            <td>{{ \Carbon\Carbon::parse($a->tanggal)->format('d-m-Y') }}</td>
            <td>{{ $a->siswa->nis }}</td>
            <td>{{ $a->siswa->nama }}</td>
            <td>{{ $a->siswa->kelas }} {{ $a->siswa->jurusan ?? '' }}</td>
            <td>{{ ucfirst($a->status) }}</td>
            <td>{{ $a->keterangan }}</td>
        </tr>
        @endforeach
    </tbody>
</table>