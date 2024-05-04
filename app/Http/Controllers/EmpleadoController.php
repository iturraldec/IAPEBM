<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\People;

//
class EmpleadoController extends Controller
{
  //
  public function getToDataTable(int $grupo_id)
  {
    return datatables()->of(Employee::where('grupo_id', $grupo_id)->with('person')->get())->toJson();
  }

  //
  public function getById(int $person_id)
  {
    $empleado = People::Where('id', $person_id)->with('employee', 'civil_status', 'phones')->first();

    return $empleado;
  }
}