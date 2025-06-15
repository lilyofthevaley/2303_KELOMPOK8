<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
        return view('admin.siswa.index', compact('siswa'));
    }

    public function create()
    {
        return view('admin.siswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|string|unique:siswa',
            'nama' => 'required|string|max:255',
            'kelas' => 'required|in:10,11,12',
            'jurusan' => 'required|in:IPA,IPS',
            'no_telp' => 'required|string|max:15',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
        ]);

        DB::transaction(function() use ($request) {
            // Buat user baru
            $user = User::create([
                'username' => $request->nis,
                'password' => Hash::make($request->nis), // Password default sama dengan NIS
                'role' => 'siswa',
                'nama' => $request->nama,
                'nis' => $request->nis,
            ]);

            // Buat data siswa
            Siswa::create([
                'user_id' => $user->id,
                'nis' => $request->nis,
                'nama' => $request->nama,
                'kelas' => $request->kelas,
                'jurusan' => $request->jurusan,
                'no_telp' => $request->no_telp,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat' => $request->alamat,
            ]);
        });

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil ditambahkan');
    }

    public function show(Siswa $siswa)
    {
        return view('admin.siswa.show', compact('siswa'));
    }

    public function edit(Siswa $siswa)
    {
        return view('admin.siswa.edit', compact('siswa'));
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

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil diperbarui');
    }

    public function destroy(Siswa $siswa)
    {
        DB::transaction(function() use ($siswa) {
            // Hapus user terkait
            User::find($siswa->user_id)->delete();
            // Data siswa akan otomatis terhapus karena constraint onDelete cascade
        });

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil dihapus');
    }
}