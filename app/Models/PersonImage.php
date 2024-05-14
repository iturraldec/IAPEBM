<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PersonImage extends Model
{   
  //
  protected $table = 'person_images';

  //
  public function person() : HasOne
  {
    return $this->hasOne(Person::class);
  }
}