<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmpleadoReposo extends Model
{
  protected $fillable = ['employee_id', 'reposo_id', 'desde', 'hasta', 'observacion'];

  // reposo
  public function reposo() : BelongsTo
  {
    return $this->belongsTo(Reposo::class);
  }
}