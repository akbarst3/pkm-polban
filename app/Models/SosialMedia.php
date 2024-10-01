<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SosialMedia extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_sosmed',
        'id_pkm',
        'link_sosmed',
    ];

    public function tipe(): BelongsTo
    {
        return $this->belongsTo(TipeSosmed::class, 'id_sosmed', 'id_sosmed');
    }
}
