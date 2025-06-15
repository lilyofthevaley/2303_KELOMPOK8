<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        // Set timezone Indonesia
        $today = Carbon::now('Asia/Jakarta')->toDateString();
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
        
        // Set timezone Indonesia untuk waktu yang akurat
        $now = Carbon::now('Asia/Jakarta');
        $today = $now->toDateString();
        $currentTime = $now->toTimeString();
        
        // Cek apakah sudah absen hari ini
        $existingAbsensi = Absensi::where('siswa_id', $siswa->id)
                                ->whereDate('tanggal', $today)
                                ->first();
        
        if ($existingAbsensi) {
            return redirect()->route('siswa.absensi.index')
                           ->with('error', 'Anda sudah melakukan absensi hari ini.');
        }
        
        // Simpan absensi
        try {
            $absensi = Absensi::create([
                'siswa_id' => $siswa->id,
                'tanggal' => $today,
                'waktu' => $currentTime,
                'status' => $request->status,
                'keterangan' => $request->keterangan,
                'is_confirmed' => false,
            ]);
            
            // Debug: cek apakah data tersimpan
            if ($absensi) {
                return redirect()->route('siswa.absensi.index')
                               ->with('success', 'Absensi berhasil disimpan pada ' . $now->format('d/m/Y H:i:s'));
            } else {
                return redirect()->back()
                               ->with('error', 'Gagal menyimpan absensi.')
                               ->withInput();
            }
        } catch (\Exception $e) {
            // Debug: tampilkan error
            return redirect()->back()
                           ->with('error', 'Error: ' . $e->getMessage())
                           ->withInput();
        }
    }

    public function edit($id)
    {
        $siswa = Auth::user()->siswa;
        $absensi = Absensi::where('siswa_id', $siswa->id)->where('id', $id)->firstOrFail();
        if ($absensi->is_confirmed) {
            return redirect()->route('siswa.absensi.index')->with('error', 'Absensi yang sudah dikonfirmasi tidak dapat diedit.');
        }
        return view('siswa.absensi.edit', compact('absensi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:hadir,izin,sakit,alfa',
            'keterangan' => 'nullable|string',
        ]);
        $siswa = Auth::user()->siswa;
        $absensi = Absensi::where('siswa_id', $siswa->id)->where('id', $id)->firstOrFail();
        if ($absensi->is_confirmed) {
            return redirect()->route('siswa.absensi.index')->with('error', 'Absensi yang sudah dikonfirmasi tidak dapat diedit.');
        }
        $absensi->update([
            'status' => $request->status,
            'keterangan' => $request->keterangan,
        ]);
        return redirect()->route('siswa.absensi.index')->with('success', 'Absensi berhasil diperbarui.');
    }
}