<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddressState extends Model
{
    protected $table = 'address_states';

    protected $primaryKey = 'state_id';

    protected $fillable = ['name', 'initials', 'ibge_code'];

    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Relacionamento com as cidades (estado tem muitas cidades)
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cities()
    {
        return $this->hasMany(AddressCity::class, 'state_id', 'state_id');
    }
}
