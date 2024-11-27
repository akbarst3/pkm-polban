<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Mahasiswa extends Model
{
    use HasFactory;
    protected $primaryKey = 'nim';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nim',
        'nama',
        'kode_prodi',
        'angkatan',
        'id_pkm',
    ];

    protected $casts = [
        'nim' => 'string',
        'kode_prodi' => 'string'
    ];


    public function detailPkm(): BelongsTo
    {
        return $this->belongsTo(DetailPkm::class, 'id_pkm', 'id');
    }
    public function pengusul(): HasOne
    {
        return $this->hasOne(Pengusul::class, 'nim', 'nim');
    }

    public function prodi(): BelongsTo
    {
        return $this->belongsTo(
            ProgramStudi::class,
            'kode_prodi',
            'kode_prodi'
        );
    }
}
