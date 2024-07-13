<?php

namespace App\Enums;

enum EmployeeStatus: int
{
  case Inactivo = 0;
  case Activo = 1;

  public function label(): string
  {
      return match($this) {
          static::Inactivo => 'Inactivo',
          static::Activo=> 'Activo'
      };
  }
}