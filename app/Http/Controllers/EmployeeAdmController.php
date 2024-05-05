<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade;

//
class EmployeeAdmController extends EmpleadoController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      if(request()->ajax()) {
        return $this->getToDataTable(1);
      }
      else {
        return view('employee-adm.index');
      }
    }

    //
    public function show(int $employees_adm)
    {
      $data = parent::getById($employees_adm);

      $pdf = Facade\Pdf::loadView('employee-adm.view', compact('data'));
      
      return $pdf->stream("empleado-".$data->cedula);
      //return view('employee-adm.view', compact('data'));
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