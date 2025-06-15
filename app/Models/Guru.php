<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'guru';
    
    protected $fillable = [
        'user_id',
        'nip',
        'nama',
        'no_telp',
        'mata_pelajaran',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}