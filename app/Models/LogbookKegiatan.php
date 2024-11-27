<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LogbookKegiatan extends Model
{
    use HasFactory;
    protected $fillable = [
        'tanggal',
        'uraian',
        'capaian',
        'waktu_pelaksanaan',
        'bukti',
        'validasi',
        'id_pkm',
    ];

    public function detailPkm(): BelongsTo
    {
        return $this->belongsTo(DetailPkm::class, 'id_pkm', 'id_pkm');
    }
}
