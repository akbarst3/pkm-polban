<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerguruanTinggi extends Model
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
