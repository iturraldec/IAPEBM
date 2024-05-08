<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BloodType extends Model
{ 
  //
  protected $fillable = ['name'];

  public function person() : HasOne
  {
    return $this->hasOne(Person::class);
  }
}