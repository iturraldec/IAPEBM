<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    //
    public function person()
    {
        return $this->hasOne(People::class,'id','person_id') ;
    }
}