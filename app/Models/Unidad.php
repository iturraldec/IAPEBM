<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unidad extends Model
{
    //
    protected $table = 'unidades';

    //
    protected $fillable = ['padre_id', 'code', 'name', 'latitude', 'length'];

    //
    public static function unidades()
    {
        return Unidad::where('padre_id', null)->orderBy('name')->get();
    }

    //
    public function especificas() : HasMany
    {
        return $this->hasMany(Unidad::class, 'padre_id');
    }
}