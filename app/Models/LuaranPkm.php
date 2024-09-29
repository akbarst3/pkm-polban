<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class LuaranPkm extends Model
{
    use HasFactory;
    public function skemaluaran() : BelongsToMany {
        return $this->belongsToMany(SkemaPkm::class, 'skema_luaran', 'id_luaran', 'id_skema');
    }
}
