<?php

namespace App\Enums;

enum PhoneTypeEnum : int
{
  case Celular = 1;
  case Fijo = 2;

  public function label(): string
  {
      return match($this) {
          static::Celular => 'Celular',
          static::Fijo => 'Domicilio'
      };
  }
}