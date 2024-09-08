<?php

namespace App\Models;

use App\Enums\CcpsEjesEnum;
use Illuminate\Database\Eloquent\Model;

//
class Unidad extends Model
{
    //
    protected $table = 'unidades';

    //
    protected $fillable = ['eje_id', 'padre_id', 'code', 'name', 'latitude', 'length'];

    //
    public static function unidades()
    {
        $unidades = Unidad::where('padre_id', null)->orderBy('name')->get()->map(function ($unidad) {
            $ejeEnum = CcpsEjesEnum::tryFrom($unidad->eje_id);
            $unidad->eje = $ejeEnum ? CcpsEjesEnum::from($unidad->eje_id)->label() : 'NO DEFINIDO';

            return $unidad;
        });
        return $unidades;
    }

    //
    public static function especificas(int $padreId)
    {
        return Unidad::where('padre_id', $padreId)->orderBy('name')->get();
    }
}