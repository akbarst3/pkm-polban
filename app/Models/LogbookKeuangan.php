<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LogbookKeuangan extends Model
{
    use HasFactory;
    protected $fillable = [
        'tanggal',
        'ket_item',
        'harga',
        'bukti',
        'id_pkm',
        'jumlah',
    ];
    
    public function detailPkm(): BelongsTo
    {
        return $this->belongsTo(DetailPkm::class, 'id_pkm', 'id_pkm');
    }
}
