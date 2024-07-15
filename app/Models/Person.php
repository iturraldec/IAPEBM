<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Person extends Model
{
    //
    protected $table = 'people';

    //
    protected $fillable = [
        'cedula', 'first_name', 'second_name', 'first_last_name', 'second_last_name', 'sex', 'birthday', 
        'place_of_birth', 'civil_status_id', 'blood_type', 'notes', 'imagef', 'imageli', 'imageld'
    ];

    // retorna los datos de un empleado
    public static function getById(int $id)
    {
        return Person::with('employee', 'emails', 'phones.type', 'addresses')->find($id);
    }

    //
    public function employee() : HasOne
    {
        return $this->hasOne(Employee::class, 'person_id');
    }

    //
    public function emails() : HasMany
    {
        return $this->hasMany(Email::class);
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