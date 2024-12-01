<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Person;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\EmpleadoEstudio;

//
class Employee extends Model
{
    //
    protected $fillable = [
        'person_id', 'type_id', 'codigo_nomina', 'fecha_ingreso', 'cargo_id', 'condicion_id', 'tipo_id', 'unidad_id', 'rif', 'codigo_patria',
        'serial_patria', 'religion', 'deporte', 'licencia', 'cta_bancaria_nro', 'passport_nro', 'fisio_barba', 'fisio_bigote', 'fisio_boca',
        'fisio_cabello','fisio_cara', 'fisio_frente', 'fisio_tez', 'fisio_contextura', 'fisio_dentadura', 'fisio_estatura', 'fisio_labios', 'fisio_lentes', 
        'fisio_nariz', 'fisio_ojos', 'fisio_peso', 'fisio_calzado', 'fisio_camisa', 'fisio_gorra', 'fisio_pantalon', 'fisio_otros'
    ];

    // datos personales
    public function person() : BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    // datos del cargo
    public function cargo() : BelongsTo
    {
        return $this->belongsTo(Cargo::class);
    }

    // datos policiales
    public function police() : HasOne
    {
        return $this->hasOne(Police::class);
    }

    // unidad especifica
    public function unidad() : HasOne
    {
        return $this->hasOne(Unidad::class, 'id', 'unidad_id');
    }

    // unidad especifica
    protected function unidadEspecifica() : Attribute
    {
        return new Attribute(
            get: fn () => Unidad::find($this->unidad_id),
        );
    }

    // reposos
    public function reposos() : HasMany 
    {
        return $this->hasMany(EmpleadoReposo::class);
    }

    // vacaciones
    public function vacaciones() : HasMany 
    {
        return $this->hasMany(Vacacione::class);
    }

    // datos fisionomicos
    public function fisionomia() : HasMany
    {
        return $this->hasMany(EmpleadoFisionomia::class);
    }

    //
    public function familiares() : HasMany
    {
        return $this->hasMany(Familia::class);
    }

    //
    public function familiaresFull() : array
    {
        return $this->familiares->map(function ($familiar) {
            return [
                'id'                => $familiar->id,
                'parentesco_id'     => $familiar->parentesco_id,
                'parentesco'        => $familiar->parentesco,
                'first_name'        => $familiar->first_name,
                'second_name'       => $familiar->second_name,
                'first_last_name'   => $familiar->first_last_name,
                'second_last_name'  => $familiar->second_last_name,
            ];
        })->toArray();
    }

    //
    public function estudios() : HasMany
    {
        return $this->hasMany(EmpleadoEstudio::class);
    }

    //
    public function estudiosFull()
    {
        return EmpleadoEstudio::where('employee_id', $this->id)->with('estudioType')->get();
    }

    //
    public function permisos() : HasMany
    {
        return $this->hasMany(Permiso::class);
    }

    // condicion del empleado
    public function condicion() : HasOne
    {
        return $this->hasOne(Condicion::class, 'id', 'condicion_id');
    }
}