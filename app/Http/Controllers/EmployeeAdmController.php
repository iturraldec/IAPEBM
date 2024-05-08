<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade;
use App\Models\Person;

//
class EmployeeAdmController extends Controller
{
  private $grupo_id;

  public function __construct()
  { 
    $this->grupo_id = 1;
  }

  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    if(request()->ajax()) {
      return datatables()->of(Employee::where('grupo_id', $this->grupo_id)->with('person')->get())->toJson();
    }
    else {
      return view('employee-adm.index');
    }
  }

    //
    public function edit(Employee $employees_adm)
    {
      return response(Person::with('employee', 'civil_status', 'phones')->find($employees_adm->person_id), 200);
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