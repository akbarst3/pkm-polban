<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class DosenPendamping extends Authenticatable
{
    use HasFactory;
    protected $guard = 'dospem';

    protected $fillable = [
        'username',
        'password',
    ];
}
