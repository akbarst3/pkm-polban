<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Pengusul extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'pengusuls';
    protected $guard = 'pengusul';
    
    protected $primaryKey = 'username';
    public $incrementing = false; // Karena bukan auto-increment
    protected $keyType = 'string'; // Karena username bertipe string

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
        // kolom lainnya
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Override method getAuthIdentifierName jika perlu
    public function getAuthIdentifierName()
    {
        return 'username';
    }

    // Override method getAuthIdentifier jika perlu
    public function getAuthIdentifier()
    {
        return $this->username;
    }

    // Override method getAuthPassword untuk menyesuaikan nama kolom password
    public function getAuthPassword()
    {
        return $this->password_hashed;
    }
}
