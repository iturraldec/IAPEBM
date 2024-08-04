<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Person;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Casts\Attribute;

//
class Employee extends Model
{
    //
    protected $fillable = [
        'person_id',
        'type_id',
        'codigo_nomina',
        'fecha_ingreso',
        'cargo_id',
        'condicion_id',
        'tipo_id',
        'unidad_id',
        'rif',
        'codigo_patria',
        'serial_patria',
        'religion',
        'deporte',
        'licencia',
        'cta_bancaria_nro',
        'passport_nro'
    ];

    // datos personales
    public function person() : BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    // datos policiales
    public function police() : HasOne
    {
        return $this->hasOne(Police::class);
    }

    // unidad especifica
    protected function unidadEspecifica() : Attribute
    {
        return new Attribute(
            get: fn () => Unidad::find($this->unidad_id),
        );
    }
}