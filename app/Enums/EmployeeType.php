<?php

namespace App\Enums;

enum EmployeeType: int
{
  case Administrativo = 1;
  case Obrero = 2;
  case Uniformado = 3;

  public function label(): string
  {
      return match($this) {
          static::Administrativo => 'Administrativo',
          static::Obrero => 'Obrero',
          static::Uniformado => 'Uniformado'
      };
  }
}