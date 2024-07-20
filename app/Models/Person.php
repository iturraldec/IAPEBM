<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Person extends Model
{
    //
    protected $table = 'people';

    //
    protected $fillable = [
        'cedula', 'first_name', 'second_name', 'first_last_name', 'second_last_name', 'sex', 'birthday', 
        'place_of_birth', 'civil_status_id', 'blood_type', 'notes', 'imagef', 'imageli', 'imageld'
    ];

    /*
    /* POR REFACTORIZAR!!!
    */
    // retorna los datos de una persona
    public static function getById(int $id)
    {
        $data = Person::with('emails', 'phones', 'addresses')->find($id);
        $fullAddresses = [];
        foreach($data['addresses'] as $address) {
            $fullAddresses[] = $address->fullAddress;
        }
        $data['fullAddresses'] = $fullAddresses;

        return $data;
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