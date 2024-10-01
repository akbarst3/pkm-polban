<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class PerguruanTinggi extends Authenticatable
{
    use HasFactory;
    protected $primaryKey = 'kode_pt';

    protected $fillable = [
        'kode_pt',
        'nama_pt',
        'username',
        'password'
    ];

    public function prodi(): HasMany
    {
        return $this->hasMany(ProgramStudi::class, 'kode_pt');
    }

    public function operator(): HasMany
    {
        return $this->hasMany(OperatorPt::class, 'kode_pt', 'kode_pt');
    }
    public function surat(): HasMany
    {
        return $this->hasMany(SuratPt::class, 'kode_pt', 'kode_pt');
    }
    
    public function detailPkm(): HasMany
    {
        return $this->hasMany(DetailPkm::class, 'kode_pt', 'kode_pt');
    }
    
}
