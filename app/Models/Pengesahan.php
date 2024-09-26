<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengesahan extends Model
{
    use HasFactory;
    protected $fillable = [
        'waktu_pelaksanaan',
        'kota_pelaksanaan',
        'nama',
        'jabatan',
        'nip',
        'id_pkm',
    ];
}
