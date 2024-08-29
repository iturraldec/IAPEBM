<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmpleadoFisionomia extends Model
{
  //
  protected $table = 'empleado_fisionomia';

  //
  protected $fillable = ['employee_id', 'fisionomia_id', 'info'];

  // empleado
  public function empleado() : BelongsTo
  {
    return $this->belongsTo(Employee::class);
  }

  // fisionomia
  public function fisionomia() : BelongsTo
  {
    return $this->belongsTo(Fisionomia::class);
  }
}