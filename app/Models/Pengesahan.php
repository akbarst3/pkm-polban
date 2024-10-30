<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengesahan extends Model
{
    use HasFactory;
    protected $fillable = [
        'waktu_pelaksanaan',
        'kota_pengesahan',
        'nama',
        'jabatan',
        'NIP',
        'id_pkm',
    ];

    public function detailPkm(): BelongsTo
    {
        return $this->belongsTo(DetailPkm::class, 'id_pkm', 'id_pkm');
    }
}
