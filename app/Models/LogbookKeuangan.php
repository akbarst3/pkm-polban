<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogbookKeuangan extends Model
{
    use HasFactory;
    protected $fillable = [
        'tanggal',
        'ket_item',
        'harga',
        'bukti',
        'id_pkm',
    ];
}
