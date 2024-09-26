<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class PerguruanTinggi extends Authenticatable
{
    use HasFactory;
    protected $primaryKey = 'kode_pt';

    protected $fillable = [
        'kode_pt',
        'nama_pt',
        'username',
        'password'
    ];
}
