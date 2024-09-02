<?php

namespace App\Enums;

enum ParentescoEnum : int
{
  case Padre = 1;
  case Madre = 2;
  case Hijo = 3;
  case Hija = 4;
  case Hermano = 5;
  case Hermana = 6;
  case Esposa = 7;
  case Esposo = 8;

  public function label(): string
  {
    return match($this) {
      static::Padre => 'Padre',
      static::Madre => 'Madre',
      static::Hijo => 'Hijo',
      static::Hija => 'Hija',
      static::Hermano => 'Hermano',
      static::Hermana => 'Hermana',
      static::Esposo => 'Esposo',
      static::Esposa => 'Esposa',
    };
  }
}