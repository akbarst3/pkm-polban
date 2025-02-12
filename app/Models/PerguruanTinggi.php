<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class PerguruanTinggi extends Authenticatable
{
    use HasFactory;
    protected $guard = 'pimpinan';
    protected $table = 'perguruan_tinggis';
    protected $primaryKey = 'kode_pt';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'kode_pt',
        'nama_pt',
        'username',
        'password'
    ];

    protected $casts = [
        'kode_pt' => 'string',
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
