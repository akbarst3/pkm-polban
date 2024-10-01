<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProgramStudi extends Model
{
    use HasFactory;
    protected $primaryKey = 'kode_prodi';

    public function pt(): BelongsTo
    {
        return $this->belongsTo(PerguruanTinggi::class, 'kode_pt', 'kode_pt');
    }

    public function mahasiswa(): HasMany
    {
        return $this->hasMany(Mahasiswa::class, 'kode_prodi', 'kode_prodi');
    }

    public function dosen(): HasMany
    {
        return $this->hasMany(Dosen::class, 'kode_prodi', 'kode_prodi');
    }
}