<?php

namespace App\Clases;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Person;

//
abstract class PersonaAbstract
{
  // retorna en empleado por su cedula
  static public function GetByCedula(string $cedula) : ?Person 
  {
    return Person::where('cedula', $cedula)->first();
  }
}