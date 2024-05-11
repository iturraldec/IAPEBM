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
        return $this->hasMany(Phone::class, 'person_id', 'id');
    }

    //
    public function addresses() : HasMany
    {
        return $this->hasMany(Address::class);
    }
}