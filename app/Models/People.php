<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    //
    protected $table = 'people';

    //
    public function phones()
    {
        return $this->hasMany(Phone::class, 'person_id', 'id');
    }
}
