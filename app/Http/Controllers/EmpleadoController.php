<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\People;
use App\Models\Phone;

//
class EmpleadoController extends Controller
{
  //
  public function getToDataTable(int $grupo_id)
  {
    return datatables()->of(Employee::where('grupo_id', $grupo_id)->with('person')->get())->toJson();
  }

  //
  public function getById(Employee $employee)
  {
    return People::with('employee', 'civil_status', 'phones')->find($employee->person_id);
  }
}