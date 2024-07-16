<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Police extends Model
{
  //
  protected $fillable = [
    'employee_id',
    'escuela',
    'fecha_graduacion',
    'curso',
    'curso_duracion',
    'cup',
  ];

  //
  public function employee() : BelongsTo
  {
      return $this->belongsTo(Police::class);
  }
}