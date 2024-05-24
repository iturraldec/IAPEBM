<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Barryvdh\DomPDF\Facade;
use Illuminate\Support\Facades\Storage;
use \DateTime;
use Illuminate\Validation\Rule;

use App\Models\Address;
use App\Models\BloodType;
use App\Models\CivilStatus;
use App\Models\Employee;
use App\Models\Person;
use App\Models\PhoneType;
use App\Models\Location;
use App\Models\PersonImage;
use App\Models\Phone;
use App\Models\Cargo;
use App\Models\EmployeeStatus;
use App\Models\EmployeeTipos;
use App\Models\EmployeeLocations;

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
      $phone_types  = PhoneType::get();
      $municipios   = $location->getMunicipios();
      $parroquias   = $location->getParroquias();
      $edoCivil     = CivilStatus::get();
      $tipoSangre   = BloodType::get();
      $cargos       = Cargo::OrderBy('name')->get();
      $status       = EmployeeStatus::OrderBy('name')->get();
      $tipos        = EmployeeTipos::OrderBy('name')->get();
      $ubicaciones  = EmployeeLocations::OrderBy('name')->get();

      return view('employee-adm.index', compact('phone_types', 'municipios', 
                  'parroquias', 'edoCivil', 'tipoSangre', 'cargos', 'status', 'tipos', 'ubicaciones'));
    }
  }

  //
  public function getById(Employee $employee)
  {
    return Person::with('employee', 'civil_status', 'phones.type', 'addresses', 'images')->find($employee->person_id);
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

  //
  private function _addPhones($person, $_phones)
  {
    $phone = [];
    foreach($_phones as $phone) {
      $phones[] = new Phone([
                    'phone_type_id' => $phone['phone_type_id'],
                    'number'        => $phone['number']
                  ]);
    };

    $person->phones()->delete();
    $person->phones()->saveMany($phones);
  }

  //
  private function _addAddresses($person, $_addresses)
  {
    $addresses = [];
    foreach($_addresses as $address) {
      $addresses[] = new Address([
                    'address'       => $address['address'],
                    'parroquia_id'  => $address['parroquia_id'],
                    'zona_postal'   => $address['zona_postal']
                  ]);
    };

    $person->addresses()->delete();
    $person->addresses()->saveMany($addresses);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $request->validate([
      'employee.codigo' => [
        'required',
        'max:20'
      ],
      'employee.fecha_ingreso'  => 'required',
      'employee.codigo_patria'  => [
        'required',
        'max:100'
      ],
      'employee.religion'       => 'required|max:100',
      'employee.deporte'        => 'required|max:100',
      'employee.licencia'       => 'required|max:100',
    ]);

    // agrego la persona
    $person = Person::create([
      'cedula'          => $request->cedula, 
      'name'            => $request->name, 
      'sex'             => $request->sex, 
      'birthday'        => $request->birthday, 
      'place_of_birth'  => $request->place_of_birth, 
      'email'           => $request->email, 
      'civil_status_id'  => $request->civil_status_id, 
      'blood_type_id'   => $request->blood_type_id, 
      'notes'           => $request->notes
    ]);

    // agrego al empleado administrativo
    $employee = Employee::create([
      'person_id'               => $person->id,
      'grupo_id'                => 1,
      'codigo'                  => $request->employee['codigo'],
      //'fecha_ingreso'           => DateTime::createFromFormat('d/m/Y', $request->employee['fecha_ingreso'])->format('Y-m-d'),
      'fecha_ingreso'           => $request->employee['fecha_ingreso'],
      'employee_cargo_id'       => $request->employee['employee_cargo_id'],
      'employee_condicion_id'   => $request->employee['employee_condicion_id'],
      'employee_tipo_id'        => $request->employee['employee_tipo_id'],
      'employee_location_id'    => $request->employee['employee_location_id'],
      'rif'                     => $request->employee['rif'],
      'codigo_patria'           => $request->employee['codigo_patria'],
      'religion'                => $request->employee['religion'],
      'deporte'                 => $request->employee['deporte'],
      'licencia'                => $request->employee['licencia'],
    ]);

    // agregar telefonos
    $this->_addPhones($person, $request->phones);

    // agregar direcciones
    $this->_addAddresses($person, $request->addresses);

    //
    return response($person, 201);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Employee $employees_adm)
  {
    $request->validate([
      'employee.codigo' => [
        'required',
        'max:20'
      ],
      'employee.fecha_ingreso'  => 'required',
      'employee.codigo_patria'  => [
        'required',
        'max:100'
      ],
      'employee.religion'       => 'required|max:100',
      'employee.deporte'        => 'required|max:100',
      'employee.licencia'       => 'required|max:100',
    ]);

    // modifico la persona
    $person = Person::find($employees_adm->person_id);
    $person->cedula = $request->cedula;
    $person->name = $request->name;
    $person->sex = $request->sex;
    $person->birthday = $request->birthday;
    $person->place_of_birth = $request->place_of_birth;
    $person->civil_status_id = $request->civil_status_id;
    $person->blood_type_id = $request->blood_type_id;
    $person->email = $request->email;
    $person->notes = $request->notes;
    $person->save();

    // modifico sus telefonos
    $this->_addPhones($person, $request->phones);

    // modificar direcciones
    $this->_addAddresses($person, $request->addresses);

    // actualizar las imagenes
    foreach($request->images as $image){
      if($image['deleted']) {
        $employeeImage = PersonImage::find($image['id']);
        $employeeImage->delete();
        $fileImage = str_replace('/storage', 'public', $image['file']);
        Storage::delete($fileImage);
      }
    };

    // modifico los datos del empleado
    $employees_adm->codigo = $request->employee['codigo'];
    $employees_adm->fecha_ingreso = $request->employee['fecha_ingreso'];
    $employees_adm->employee_cargo_id = $request->employee['employee_cargo_id'];
    $employees_adm->employee_condicion_id = $request->employee['employee_condicion_id'];
    $employees_adm->employee_tipo_id = $request->employee['employee_tipo_id'];
    $employees_adm->employee_location_id = $request->employee['employee_location_id'];
    $employees_adm->rif = $request->employee['rif'];
    $employees_adm->codigo_patria = $request->employee['codigo_patria'];
    $employees_adm->religion =  $request->employee['religion'];
    $employees_adm->deporte = $request->employee['deporte'];
    $employees_adm->licencia =  $request->employee['licencia'];
    $employees_adm->save();
    
    //
    return response($person, Response::HTTP_OK);
  }

  //
  public function addImages(Request $request, string $cedula)
  {
    if ($request->hasFile('images')) {
      $person = Person::firstWhere('cedula', $cedula);
      $_files = [];
      foreach($request->file('images') as $image) {
        $_files[] = [
            'person_id' => $person->id, 
            'file'      => Storage::url($image->store("public/employees/$cedula"))
        ];
      }
      
      return response(PersonImage::insert($_files));
   }

   return Response::HTTP_NO_CONTENT;
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