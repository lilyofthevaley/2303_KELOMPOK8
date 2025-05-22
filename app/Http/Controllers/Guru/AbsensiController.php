<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AbsensiExport;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $query = Absensi::with('siswa');
        
        if ($request->has('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }
        
        if ($request->has('status')) {
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

    public function exportExcel(Request $request)
    {
        $tanggalMulai = $request->input('tanggal_mulai') ?? Carbon::now()->startOfMonth()->toDateString();
        $tanggalAkhir = $request->input('tanggal_akhir') ?? Carbon::now()->endOfMonth()->toDateString();
        
        return Excel::download(new AbsensiExport($tanggalMulai, $tanggalAkhir), 'absensi.xlsx');
    }
}