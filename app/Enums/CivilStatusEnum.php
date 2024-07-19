<?php

namespace App\Enums;

enum CivilStatusEnum : int
{
  case Soltero = 1;
  case Casado = 2;
  case Divorsiado = 3;
  case Viudo = 4;
  case UnionEstable = 5;

  public function label(): string
  {
    return match($this) {
      static::Soltero => 'Soltero',
      static::Casado => 'Casado',
      static::Divorsiado => 'Divorsiado',
      static::Viudo => 'Viudo',
      static::UnionEstable => 'Union Estable de Hecho',
    };
  }
}