<?php

namespace App\Exports;

use App\Models\Absensi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AbsensiExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $tanggalMulai;
    protected $tanggalAkhir;

    public function __construct($tanggalMulai, $tanggalAkhir)
    {
        $this->tanggalMulai = $tanggalMulai;
        $this->tanggalAkhir = $tanggalAkhir;
    }

    public function collection()
    {
        return Absensi::whereBetween('tanggal', [$this->tanggalMulai, $this->tanggalAkhir])
                    ->with('siswa')
                    ->orderBy('tanggal', 'asc')
                    ->get();
    }

    public function headings(): array
    {
        return [
            'NIS',
            'Nama Siswa',
            'Kelas',
            'Jurusan',
            'Tanggal',
            'Waktu',
            'Status',
            'Keterangan',
            'Status Konfirmasi',
        ];
    }

    public function map($absensi): array
    {
        return [
            $absensi->siswa->nis,
            $absensi->siswa->nama,
            $absensi->siswa->kelas,
            $absensi->siswa->jurusan,
            $absensi->tanggal,
            $absensi->waktu,
            $absensi->status,
            $absensi->keterangan,
            $absensi->is_confirmed ? 'Sudah Dikonfirmasi' : 'Belum Dikonfirmasi',
        ];
    }
}