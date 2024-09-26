<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkemaLuaran extends Model
{
    // Disable auto-incrementing since there is no single primary key
    public $incrementing = false;

    // If the table does not follow Laravel's plural naming convention, define the table name explicitly
    protected $table = 'skema_luarans';

    // Define the primary key as an array
    protected $primaryKey = ['id_skema', 'id_luaran'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Disable mass assignment protection for this model.
     */
    protected $guarded = [];

    /**
     * Eloquent does not support composite keys by default, so we override
     * the default behavior here for querying models.
     */
    protected function setKeysForSaveQuery($query)
    {
        $query->where('id_skema', $this->getAttribute('id_skema'))
              ->where('id_luaran', $this->getAttribute('id_luaran'));

        return $query;
    }

    /**
     * Relationships
     */

    // A skema_luaran belongs to a skema_pkm
    public function skemaPkm()
    {
        return $this->belongsTo(SkemaPkm::class, 'id_skema');
    }

    // A skema_luaran belongs to a luaran_pkm
    public function luaranPkm()
    {
        return $this->belongsTo(LuaranPkm::class, 'id_luaran');
    }
}
