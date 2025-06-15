<?php

namespace App\Exports;

use App\Models\Absensi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportAbsensi implements FromCollection, WithHeadings
{
    protected $guru;

    public function __construct($guru)
    {
        $this->guru = $guru;
    }

    public function collection()
    {
        return Absensi::where('guru', $this->guru)
            ->select('tanggal', 'waktu', 'nis', 'siswa', 'kelas', 'status', 'keterangan', 'aksi')
            ->get();
    }

    public function headings(): array
    {
        return ['Tanggal', 'Waktu', 'NIS', 'Siswa', 'Kelas', 'Status', 'Keterangan', 'Aksi'];
    }
}