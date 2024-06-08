<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Barryvdh\DomPDF\Facade;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManagerStatic as Image;

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
class EmployeePoliceController extends Controller
{
  private $grupo_id;

  public function __construct()
  { 
    $this->grupo_id = 2;
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

      return view('employee-police.index', compact('phone_types', 'municipios', 
                  'parroquias', 'edoCivil', 'tipoSangre', 'cargos', 'status', 'tipos', 'ubicaciones'));
    }
  }

  //
  public function getById(Employee $employee)
  {
    return Person::with('employee.police', 'civil_status', 'phones.type', 'addresses', 'images')->find($employee->person_id);
  }

  //
  public function edit(Employee $employees_polouse)
  {
    return response($this->getById($employees_polouse), 200);
  }

  //
  public function show(Employee $employees_adm)
  {
    $data = $this->getById($employees_adm);

    $pdf = Facade\Pdf::loadView('employee-adm.view', compact('data'));
    
    return $pdf->stream("ea-".$data->cedula);
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
      'cedula'  => 'required|max:15|unique:people',
      'employee.codigo' => [
        'required',
        'max:20'
      ],
      'employee.fecha_ingreso'  => 'required',
      'employee.codigo_patria'  => [
        'required',
        'max:100'
      ],
      'employee.religion'         => 'required|max:100',
      'employee.deporte'          => 'required|max:100',
      'employee.licencia'         => 'required|max:100',
      'employee.police.escuela'          => 'required|max:100',
      'employee.police.fecha_graduacion' => 'required',
      'employee.police.curso'            => 'required|max:10',
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

    // agregar telefonos
    $this->_addPhones($person, $request->phones);

    // agregar direcciones
    $this->_addAddresses($person, $request->addresses);

    // agrego empleado
    $employee = Employee::create([
      'person_id'               => $person->id,
      'grupo_id'                => $this->grupo_id,
      'codigo'                  => $request->employee['codigo'],
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

    // agrego datos policiales
    DB::table('police')->insert([
      'employee_id'       => $employee->id,
      'escuela'           => $request->employee['police']['escuela'],
      'fecha_graduacion'  => $request->employee['police']['fecha_graduacion'],
      'curso'             => $request->employee['police']['curso'],
    ]);

    //
    return response($person, 201);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Employee $employees_polouse)
  {
    $request->validate([
      'cedula'  => [
        'required',
        'max:15',
        Rule::unique('people')->ignore($employees_polouse->person_id)
      ],
      'employee.codigo' => [
        'required',
        'max:20'
        ///////////////////////////////////////////////////////////
        // FALTA VALIDAR DE QUE NO EXISTA EL CODIGO!!!
        ///////////////////////////////////////////////////////////
      ],
      'employee.fecha_ingreso'  => 'required',
      'employee.codigo_patria'  => [
        'required',
        'max:100'
      ],
      'employee.religion'         => 'required|max:100',
      'employee.deporte'          => 'required|max:100',
      'employee.licencia'         => 'required|max:100',
      'employee.police.escuela'          => 'required|max:100',
      'employee.police.fecha_graduacion' => 'required',
      'employee.police.curso'            => 'required|max:10',
    ]);

    // modifico la persona
    $person = Person::find($employees_polouse->person_id);
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

    // modifico sus direcciones
    $this->_addAddresses($person, $request->addresses);

    // eliminar las imagenes que el usuario selecciono
    foreach($request->images as $image) {
      if($image['deleted']) {
        $employeeImage = PersonImage::find($image['id']);
        $employeeImage->delete();
        unlink($image['file']);
      }
    };

    // modifico los datos del empleado
    $employees_polouse->codigo = $request->employee['codigo'];
    $employees_polouse->fecha_ingreso = $request->employee['fecha_ingreso'];
    $employees_polouse->employee_cargo_id = $request->employee['employee_cargo_id'];
    $employees_polouse->employee_condicion_id = $request->employee['employee_condicion_id'];
    $employees_polouse->employee_tipo_id = $request->employee['employee_tipo_id'];
    $employees_polouse->employee_location_id = $request->employee['employee_location_id'];
    $employees_polouse->rif = $request->employee['rif'];
    $employees_polouse->codigo_patria = $request->employee['codigo_patria'];
    $employees_polouse->religion =  $request->employee['religion'];
    $employees_polouse->deporte = $request->employee['deporte'];
    $employees_polouse->licencia =  $request->employee['licencia'];
    $employees_polouse->save();

    // modifico los datos policiales
    DB::table('police')
      ->where('employee_id', $employees_polouse->id)
      ->update([
          'escuela'           => $request->employee['police']['escuela'],
          'fecha_graduacion'  => $request->employee['police']['fecha_graduacion'],
          'curso'             => $request->employee['police']['curso']
        ]);     
    
        //
    return response($person, Response::HTTP_OK);
  }

  //
  public function addImages(Request $request, string $cedula)
  {
    if ($request->hasFile('images')) {
      $person = Person::firstWhere('cedula', $cedula);
      $files = [];
      foreach($request->file('images') as $image) {
        $file = "images/$cedula/" . uniqid() . ".png";
        Image::make($image->getRealPath())->resize(200,200)->save($file, 0, 'png');
        $files[] = [
            'person_id' => $person->id,
            'file'      => $file
        ];
      }
      
      return response(PersonImage::insert($files));
    }

   return Response::HTTP_NO_CONTENT;
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(int $employees_polouse)
  {
    $person = Person::find($employees_polouse);
    if(!is_null($person)) {
      $person->delete();
    }
    
    return Response::HTTP_NO_CONTENT;
  }
}