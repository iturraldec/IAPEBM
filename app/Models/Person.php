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
        'cedula', 'name', 'sex', 'birthday', 'place_of_birth', 'email', 'civil_status_id', 'blood_type_id', 'notes'
    ];

    // retorna los datos de un empleado
    public static function getById(int $id)
    {
        return Person::with('employee', 'civil_status', 'phones.type', 'addresses', 'images')->find($id);
    }

    //
    public function employee() : HasOne
    {
        return $this->hasOne(Employee::class, 'person_id');
    }

    //
    public function civil_status() : BelongsTo
    {
        return $this->belongsTo(CivilStatus::class);
    }   

    //
    public function blood_type() : BelongsTo
    {
        return $this->belongsTo(BloodType::class);
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

    //
    public function images() : HasMany
    {
        return $this->hasMany(PersonImage::class);
    }
}