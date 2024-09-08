<?php

namespace App\Enums;

enum CcpsEjesEnum : int
{
  case Metropolitano  = 1;
  case Mocoties       = 2;
  case Panamericano   = 3;
  case Paramo         = 4;

  public function label(): string
  {
    return match($this) {
      static::Metropolitano => 'Metropolitano',
      static::Mocoties      => 'Mocoties',
      static::Panamericano  => 'Panamericano',
      static::Paramo        => 'Paramo'
    };
  }
}