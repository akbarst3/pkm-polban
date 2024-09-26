<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogbookKegiatan extends Model
{
    use HasFactory;
    protected $fillable = [
        'tanggal',
        'uraian',
        'capaian',
        'waktu_pelaksanaan',
        'bukti',
        'id_pkm',
    ];
}
