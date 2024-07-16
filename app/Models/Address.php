<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
  //
  protected $table = 'addresses';

  //
  protected $fillable = ['person_id', 'parroquia_id', 'address', 'zona_postal'];

  //
  function person() : BelongsTo
  {
    return $this->belongsTo(Person::class);
  }
}