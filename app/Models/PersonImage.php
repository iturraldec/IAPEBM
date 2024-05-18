<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PersonImage extends Model
{   
  //
  protected $table = 'person_images';

  //
  protected $fillable = ['person_id', 'file'];

  //
  public function person() : HasOne
  {
    return $this->hasOne(Person::class);
  }
}