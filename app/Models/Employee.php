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
        'employee_cargo_id'
    ];

    //
    public function person() : BelongsTo
    {
        return $this->belongsTo(Person::class);
    }
}