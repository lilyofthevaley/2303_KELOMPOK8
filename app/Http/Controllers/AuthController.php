<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Cek login untuk admin
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            } else if ($user->isGuru()) {
                return redirect()->route('guru.dashboard');
            } else if ($user->isSiswa()) {
                return redirect()->route('siswa.dashboard');
            }
        }

        // Cek login untuk guru berdasarkan NIP
        $guru = Guru::where('nip', $request->username)->first();
        if ($guru) {
            $user = User::where('id', $guru->user_id)->first();
            if ($user && Hash::check($request->password, $user->password)) {
                Auth::login($user);
                $request->session()->regenerate();
                return redirect()->route('guru.dashboard');
            }
        }

        // Cek login untuk siswa berdasarkan NIS
        $siswa = Siswa::where('nis', $request->username)->first();
        if ($siswa) {
            $user = User::where('id', $siswa->user_id)->first();
            if ($user && Hash::check($request->password, $user->password)) {
                Auth::login($user);
                $request->session()->regenerate();
                return redirect()->route('siswa.dashboard');
            }
        }

        return back()->withErrors([
            'username' => 'Username/NIP/NIS atau password salah.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}