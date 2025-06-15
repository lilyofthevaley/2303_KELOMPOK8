<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use App\Exports\ExportAbsensi;
// use Maatwebsite\Excel\Facades\Excel;


class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        // dd($request->all());
        $query = Absensi::with('siswa');
        
        if ($request->has('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->has('confirmed')) {
            if ($request->confirmed == 'yes') {
                $query->where('is_confirmed', true);
            } else {
                $query->where('is_confirmed', false);
            }
        }
        
        $absensi = $query->orderBy('tanggal', 'desc')
                        ->orderBy('created_at', 'desc')
                        ->paginate(15);
        
        return view('guru.absensi.index', compact('absensi'));
    }

    public function confirm(Absensi $absensi)
    {
        $absensi->update([
            'is_confirmed' => true,
            'confirmed_by' => Auth::id(),
        ]);
        
        return redirect()->route('guru.absensi.index')
                        ->with('success', 'Absensi berhasil dikonfirmasi');
    }

    public function exportAbsensi(Request $request)
    {
    $tanggalMulai = $request->input('tanggal_mulai');
    $tanggalAkhir = $request->input('tanggal_akhir');

    $query = Absensi::with('siswa');
    if ($tanggalMulai && $tanggalAkhir) {
        $query->whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir]);
    }
    $absensi = $query->orderBy('tanggal', 'asc')->get();

    $filename = 'absensi.csv';
    $handle = fopen($filename, 'w+');
    fputcsv($handle, ['Tanggal', 'NIS', 'Nama Siswa', 'Kelas', 'Status', 'Keterangan']);

    foreach ($absensi as $a) {
        fputcsv($handle, [
            $a->tanggal,
            $a->siswa->nis,
            $a->siswa->nama,
            $a->siswa->kelas . ' ' . ($a->siswa->jurusan ?? ''),
            ucfirst($a->status),
            $a->keterangan
        ]);
    }

    fclose($handle);

    return response()->download($filename)->deleteFileAfterSend(true);
    }

    // public function exportAbsensi(Request $request)
    // {
    //     $guru = Auth::user()->guru;
    //     $tanggalMulai = $request->input('tanggal_mulai') ?? Carbon::now()->startOfMonth()->toDateString();
    //     $tanggalAkhir = $request->input('tanggal_akhir') ?? Carbon::now()->endOfMonth()->toDateString();
        
    //     return Excel::download(new ExportAbsensi($guru), 'absensi.xlsx');
    // }
}