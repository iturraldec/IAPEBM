<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Person extends Model
{
    //
    protected $table = 'people';

    //
    protected $fillable = [
        'cedula', 'name', 'sex', 'birthday', 'place_of_birth', 
        'civil_status_id', 'blood_type_id', 'notes'
    ];

    // retorna los datos de un empleado
    public static function getById(int $id)
    {
        return Person::with('employee', 'phones.type', 'addresses')->find($id);
    }

    //
    public function employee() : HasOne
    {
        return $this->hasOne(Employee::class, 'person_id');
    }

    //
    public function phones() : HasMany
    {
        return $this->hasMany(Phone::class);
    }

    //
    public function addresses() : HasMany
    {
        return $this->hasMany(Address::class);
    }
}