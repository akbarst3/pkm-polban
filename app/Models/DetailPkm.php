<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DetailPkm extends Model
{
    use HasFactory;
    protected $fillable = [
        'kode_pt',
        'judul',
        'dana_kemdikbud',
        'dana_pt',
        'dana_lain',
        'instansi_lain',
        'val_dospem',
        'val_pt',
        'proposal',
        'lapkem',
        'lapkhir',
        'id_skema',
    ];

    public function mahasiswas(): HasOne
    {
        return $this->HasOne(Mahasiswa::class, 'id_pkm', 'id_pkm');
    }

    public function lbkg(): HasMany
    {
        return $this->hasMany(LogbookKeuangan::class, 'id_pkm', 'id_pkm');
    }

    public function lbkeu(): HasMany
    {
        return $this->hasMany(LogbookKegiatan::class, 'id_pkm', 'id_pkm');
    }

    public function pengusuls(): HasManyThrough
    {
        return $this->hasManyThrough(Pengusul::class, Mahasiswa::class, 'id_pkm', 'nim', 'id_pkm', 'nim');
    }

    public function pengesahan(): HasOne
    {
        return $this->hasOne(Pengesahan::class, 'id_pkm', 'id_pkm');
    }

    public function sosmed(): HasMany
    {
        return $this->hasMany(SosialMedia::class, 'id_pkm', 'id_pkm');
    }

    public function skema(): BelongsTo
    {
        return $this->belongsTo(SkemaPkm::class, 'id_skema', 'id_skema');
    }
    public function perguruanTinggi(): BelongsTo
    {
        return $this->BelongsTo(SkemaPkm::class, 'kode_pt', 'kode_pt');
    }
}
