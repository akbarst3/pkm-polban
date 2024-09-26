<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratPt extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_pt',
        'id_tipe',
        'file_surat',
    ];
}
