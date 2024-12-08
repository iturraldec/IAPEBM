<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PoliceRango;
use Illuminate\Database\Eloquent\Relations\HasMany;

//
class Rango extends Model
{
    //
    protected $fillable = ['name'];

    //
    public function policeRangos() : HasMany
    {
        return $this->hasMany(PoliceRango::class, 'rango_id');
    }
}