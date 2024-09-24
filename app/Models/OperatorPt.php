<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
<<<<<<< HEAD
use Illuminate\Database\Eloquent\Relations\BelongsTo;
=======
>>>>>>> 73a62b1 (add: login operator)
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
<<<<<<< HEAD

    public function pt(): BelongsTo
    {
        return $this->belongsTo(PerguruanTinggi::class, 'kode_pt', 'kode_pt');
    }
=======
>>>>>>> 73a62b1 (add: login operator)
}
