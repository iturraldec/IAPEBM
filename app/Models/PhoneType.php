<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PhoneType extends Model
{    
  //
  protected $fillable = ['name'];

  //
  public function phone() : BelongsTo
  {
    return $this->belongsTo(Phone::class);
  }
}