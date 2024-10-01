<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Dosen extends Model
{
    use HasFactory;
    protected $primaryKey = 'kode_dosen';
    protected $fillable = [
        'nama',
        'no_hp',
        'email',
    ];

    public function prodi(): BelongsTo
    {
        return $this->belongsTo(ProgramStudi::class, 'kode_prodi', 'kode_prodi');
    }
    public function dospem(): HasOne
    {
        return $this->hasOne(DosenPendamping::class, 'kode_dosen', 'kode_dosen');
    }
}
