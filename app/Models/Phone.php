<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    //
    protected $fillable = ['person_id', 'phone_type_id', 'number'];
}