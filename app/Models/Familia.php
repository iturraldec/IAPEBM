<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Familia extends Model
{
  //
  protected $table = 'familiares';

  //
  protected $fillable = ['employee_id', 'person_id', 'parentesco_id'];

  // empleado
  public function empleado() : BelongsTo
  {
    return $this->belongsTo(Employee::class);
  }

  // persona
  public function person() : BelongsTo
  {
    return $this->belongsTo(Person::class);
  }
}