<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Pengusul extends Authenticatable
{
    use HasFactory;
    protected $fillable = [
        'nim',
        'username',
        'password',
        'alamat',
        'kode_pos',
        'no_hp',
        'telp_rumah',
        'email',
        'no_ktp',
        'jenis_kelamin',
        'tanggal_lahir',
        'tempat_lahir',
    ];
    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim'); 
    }
}
