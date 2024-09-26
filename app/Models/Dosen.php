<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;
    protected $primaryKey = 'kode_dosen';
    protected $fillable = [
        'nama',
        'no_hp',
        'email',
    ];
}
