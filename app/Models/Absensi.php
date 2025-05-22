<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensi';
    
    protected $fillable = [
        'siswa_id',
        'tanggal',
        'waktu',
        'status',
        'keterangan',
        'is_confirmed',
        'confirmed_by',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function confirmedBy()
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }
}