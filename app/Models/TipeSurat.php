<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipeSurat extends Model
{
    use HasFactory;
    public function surat() : HasMany {
        return $this->hasMany(SuratPt::class, 'id_tipe', 'id_tipe');
    }
}
