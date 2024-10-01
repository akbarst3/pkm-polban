<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;

class DosenPendamping extends Authenticatable
{
    use HasFactory;
    protected $guard = 'dospem';
    protected $primaryKey = null;
    // In the DetailPkm model
    public $incrementing = false;

    protected $fillable = [
        'kode_dosen',
        'username',
        'password',
    ];

    public function dosen(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'kode_dosen', 'kode_dosen');
    }
}
