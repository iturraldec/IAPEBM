<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

//
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
    public static function especificas(int $padreId)
    {
        return Unidad::where('padre_id', $padreId)->orderBy('name')->get();
    }
}