<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SkemaPkm extends Model
{
    use HasFactory;
    public function skemaluaran(): BelongsToMany
    {
        return $this->belongsToMany(LuaranPkm::class, 'skema_luaran', 'id_skema', 'id_luaran');
    }
    public function detailPkm(): HasMany
    {
        return $this->hasMany(DetailPkm::class, 'id_skema', 'id_skema');
    }
}
