<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Phone;

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
    public function people()
    {
        return $this->hasOne(People::class,'id', 'person_id') ;
    }
}