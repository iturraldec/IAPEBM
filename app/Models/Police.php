<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

//
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
  public function rangos() : HasMany
  {
    return $this->hasMany(PoliceRango::class, 'police_id');
  }

  //
  public function ultimoRango() : HasOne
  {
    return $this->hasOne(PoliceRango::class, 'police_id')->latest();
  }
}