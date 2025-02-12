<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipeSosmed extends Model
{
    use HasFactory;

    public function sosmed() : HasMany {
        return $this->HasMany(SosialMedia::class, 'id_sosmed', 'id');
    }
}
