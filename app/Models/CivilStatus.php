<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CivilStatus extends Model
{   
  //
  protected $table = 'civil_status';
  
  //
  protected $fillable = ['name'];

  public function person()
  {
    return $this->hasOne(Person::class);
  }
}