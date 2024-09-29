<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;

class OperatorPt extends Authenticatable
{
    use HasFactory;
    protected $guard = 'operator';
    protected $fillable = [
        'username',
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function pt(): BelongsTo
    {
        return $this->belongsTo(PerguruanTinggi::class, 'kode_pt', 'kode_pt');
    }
}
