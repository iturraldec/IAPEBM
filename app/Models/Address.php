<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Address extends Model
{
  //
  protected $fillable = ['person_id', 'address', 'parroquia_id', 'zona_postal'];

  //
  function person() : BelongsToMany
  {
    return $this->belongsToMany(Person::class);
  }
}