<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    //
    function getMunicipios()
    {
        return $this->where('type', 'MUNICIPIO')->orderBy('name')->get();
    }

    //
    function getParroquias()
    {
        return $this->where('type', 'PARROQUIA')->orderBy('name')->get();
    }
}
