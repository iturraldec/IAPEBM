<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmpleadoEstudio extends Model
{
  //
  protected $fillable = [
              'employee_id', 
              'estudio_type_id', 
              'fecha', 
              'descripcion', 
              'file'
            ];

  // tipos de estudios
  public function estudioType() : BelongsTo
  {
    return $this->belongsTo(EstudioType::class, 'estudio_type_id');
  }
}