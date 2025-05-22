<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    // protected $role;
    protected $fillable = [
        'username',
        'password',
        'role',
        'nama',
        'nis',
        'nip',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function siswa()
    {
        return $this->hasOne(Siswa::class);
    }

    public function guru()
    {
        return $this->hasOne(Guru::class);
    }
    
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

/*************  ✨ Windsurf Command ⭐  *************/
    /**

/*******  f84341c2-0496-4e9a-8604-4eb87044e111  *******/    public function isGuru()
    {
        return $this->role === 'guru';
    }

    public function isSiswa()
    {
        return $this->role === 'siswa';
    }
}
