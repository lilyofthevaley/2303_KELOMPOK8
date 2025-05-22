<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function index()
    {
        $siswa = Auth::user()->siswa;
        $absensi = Absensi::where('siswa_id', $siswa->id)
                        ->orderBy('tanggal', 'desc')
                        ->paginate(10);
        
        return view('siswa.absensi.index', compact('absensi'));
    }

    public function create()
    {
        $today = Carbon::now()->toDateString();
        $siswa = Auth::user()->siswa;
        
        // Cek apakah sudah absen hari ini
        $existingAbsensi = Absensi::where('siswa_id', $siswa->id)
                                ->whereDate('tanggal', $today)
                                ->first();
        
        if ($existingAbsensi) {
            return redirect()->route('siswa.absensi.index')
                           ->with('error', 'Anda sudah melakukan absensi hari ini.');
        }
        
        return view('siswa.absensi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required|in:hadir,izin,sakit',
            'keterangan' => 'nullable|string',
        ]);

        $siswa = Auth::user()->siswa;
        $today = Carbon::now()->toDateString();
        $now = Carbon::now()->toTimeString();
        
        // Cek apakah sudah absen hari ini
        $existingAbsensi = Absensi::where('siswa_id', $siswa->id)
                                ->whereDate('tanggal', $today)
                                ->first();
        
        if ($existingAbsensi) {
            return redirect()->route('siswa.absensi.index')
                           ->with('error', 'Anda sudah melakukan absensi hari ini.');
        }
        
        // Simpan absensi
        Absensi::create([
            'siswa_id' => $siswa->id,
            'tanggal' => $today,
            'waktu' => $now,
            'status' => $request->status,
            'keterangan' => $request->keterangan,
            'is_confirmed' => false,
        ]);
        
        return redirect()->route('siswa.absensi.index')
                       ->with('success', 'Absensi berhasil disimpan.');
    }
}