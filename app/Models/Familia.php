<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Enums\ParentescoEnum;

//
class Familia extends Model
{
  //
  protected $table = 'familiares';

  //
  protected $fillable = ['employee_id', 'parentesco_id', 'first_name', 'second_name', 'first_last_name', 'second_last_name'];

  // empleado
  public function empleado() : BelongsTo
  {
    return $this->belongsTo(Employee::class);
  }

  //
  protected function Parentesco() : Attribute
  {
      return new Attribute(
          get: fn () => ParentescoEnum::from($this->parentesco_id)->label(),
      );
  }
}