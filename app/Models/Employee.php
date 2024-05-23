<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Person;

class Employee extends Model
{
    //
    protected $fillable = [
        'person_id',
        'grupo_id',
        'codigo',
        'fecha_ingreso',
        'employee_cargo_id',
        'employee_condicion_id',
        'employee_tipo_id',
        'employee_location_id',
        'rif',
        'codigo_patria',
        'religion',
        'deporte',
        'licencia_grado',
    ];

    //
    public function person() : BelongsTo
    {
        return $this->belongsTo(Person::class);
    }
}