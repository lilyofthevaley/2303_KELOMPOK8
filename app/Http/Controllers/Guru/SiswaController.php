<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = Siswa::query();
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nis', 'LIKE', "%{$search}%")
                  ->orWhere('nama', 'LIKE', "%{$search}%")
                  ->orWhere('jurusan', 'LIKE', "%{$search}%");
            });
        }
        
        $siswa = $query->paginate(10);
        return view('guru.siswa.index', compact('siswa'));
    }

    public function show(Siswa $siswa)
    {
        return view('guru.siswa.show', compact('siswa'));
    }

    public function edit(Siswa $siswa)
    {
        return view('guru.siswa.edit', compact('siswa'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kelas' => 'required|in:10,11,12',
            'jurusan' => 'required|in:IPA,IPS',
            'no_telp' => 'required|string|max:15',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
        ]);

        DB::transaction(function() use ($request, $siswa) {
            // Update data siswa
            $siswa->update([
                'nama' => $request->nama,
                'kelas' => $request->kelas,
                'jurusan' => $request->jurusan,
                'no_telp' => $request->no_telp,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat' => $request->alamat,
            ]);

            // Update nama di user
            $user = User::find($siswa->user_id);
            $user->update([
                'nama' => $request->nama,
            ]);
        });

        return redirect()->route('guru.siswa.index')->with('success', 'Data siswa berhasil diperbarui');
    }
}
