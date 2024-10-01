<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuratPt extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_pt',
        'id_tipe',
        'file_surat',
    ];
    public function tipe() : BelongsTo {
        return $this->belongsTo(TipeSurat::class, 'id_tipe', 'id_tipe');
    }
}
