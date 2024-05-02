<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      if(request()->ajax()) {
        return datatables()->of(Employee::where('grupo_id', 1)->with('people')->get())->toJson();
      }
      else {
        return view('employee-adm.index');
      }
    }

    //
    public function getById(Employee $employee)
    {
      $empleado = $employee->people->phones;

      return response()->json($empleado);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}