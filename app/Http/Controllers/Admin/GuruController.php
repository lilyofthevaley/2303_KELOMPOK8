<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class GuruController extends Controller
{
    public function index(Request $request)
    {
        $query = Guru::query();
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nip', 'LIKE', "%{$search}%")
                  ->orWhere('nama', 'LIKE', "%{$search}%")
                  ->orWhere('mata_pelajaran', 'LIKE', "%{$search}%");
            });
        }
        
        $guru = $query->paginate(10);
        return view('admin.guru.index', compact('guru'));
    }

    public function create()
    {
        return view('admin.guru.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|string|unique:guru',
            'nama' => 'required|string|max:255',
            'no_telp' => 'required|string|max:15',
            'mata_pelajaran' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
        ]);

        DB::transaction(function() use ($request) {
            // Buat user baru
            $user = User::create([
                'username' => $request->nip,
                'password' => Hash::make($request->nip), // Password default sama dengan NIP
                'role' => 'guru',
                'nama' => $request->nama,
                'nip' => $request->nip,
            ]);

            // // Assign role 'guru' (Spatie permission)
            // $user->assignRole('guru');

            // Buat data guru
            Guru::create([
                'user_id' => $user->id,
                'nip' => $request->nip,
                'nama' => $request->nama,
                'no_telp' => $request->no_telp,
                'mata_pelajaran' => $request->mata_pelajaran,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat' => $request->alamat,
            ]);
        });

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil ditambahkan');
    }

    public function show(Guru $guru)
    {
        return view('admin.guru.show', compact('guru'));
    }

    public function edit(Guru $guru)
    {
        return view('admin.guru.edit', compact('guru'));
    }

    public function update(Request $request, Guru $guru)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_telp' => 'required|string|max:15',
            'mata_pelajaran' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
        ]);

        DB::transaction(function() use ($request, $guru) {
            // Update data guru
            $guru->update([
                'nama' => $request->nama,
                'no_telp' => $request->no_telp,
                'mata_pelajaran' => $request->mata_pelajaran,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat' => $request->alamat,
            ]);

            // Update nama di user
            $user = User::find($guru->user_id);
            $user->update([
                'nama' => $request->nama,
            ]);
        });

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil diperbarui');
    }

    public function destroy(Guru $guru)
    {
        DB::transaction(function() use ($guru) {
            // Hapus user terkait
            User::find($guru->user_id)->delete();
            // Data guru akan otomatis terhapus karena constraint onDelete cascade
        });

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil dihapus');
    }
}