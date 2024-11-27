<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Pengusul extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'pengusuls';
    protected $guard = 'pengusul';

    protected $primaryKey = 'nim';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $casts = [
        'nim' => 'string',
    ];

    protected $fillable = [
        'nim',
        'username',
        'password',
        'password_plain',
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

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function setNimAttribute($value)
    {
        $this->attributes['nim'] = (string)$value;
    }

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }
}
