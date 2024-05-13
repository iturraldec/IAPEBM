<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CivilStatus extends Model
{   
  //
  protected $table = 'civil_status';

  public function person() : HasOne
  {
    return $this->hasOne(Person::class);
  }
}