<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Barryvdh\DomPDF\Facade;
use App\Models\Employee;
use App\Models\Person;
use App\Models\PhoneType;
use App\Models\Location;
use App\Models\Phone;

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
      $location = new Location();
      $phone_types = PhoneType::get();
      $municipios = $location->getMunicipios();
      $parroquias = $location->getParroquias();

      return view('employee-adm.index', compact('phone_types', 'municipios', 'parroquias'));
    }
  }

  //
  public function getById(Employee $employee)
  {
    return Person::with('employee', 'civil_status', 'phones.type', 'addresses')->find($employee->person_id);
  }

  //
  public function edit(Employee $employees_adm)
  {
    return response($this->getById($employees_adm), 200);
  }

  //
  public function show(Employee $employees_adm)
  {
    $data = $this->getById($employees_adm);

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
  public function update(Request $request, Employee $employees_adm)
  {

    // modifico la persona
    $person = Person::find($employees_adm->person_id);
   /* $person->name = "Nuevo nombre cambiado4";
    $person->save();
 */
    // modifico sus telefonos
    $phones = [];
    foreach($request->phones as $phone) {
      $phones[] = new Phone([
                    'phone_type_id' => $phone['phone_type_id'],
                    'number' => $phone['number']
                  ]);
    };

    $person->phones()->delete();
    $person->phones()->saveMany($phones);
 
    return response(['message' => 'Ok'], Response::HTTP_OK);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Employee $employees_adm)
  {
    $employees_adm->delete();
    
    return Response::HTTP_NO_CONTENT;
  }
}