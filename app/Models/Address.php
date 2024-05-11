<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Address extends Model
{
  function person() : BelongsToMany
  {
    return $this->belongsToMany(Person::class, 'person_id');
  }
}