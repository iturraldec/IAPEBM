<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Barryvdh\DomPDF\Facade;
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
    if(! request()->ajax()) {
      return view('employee-adm.index');
    }
    else {
      return datatables()->of(Employee::where('grupo_id', $this->grupo_id)->with('person')->get())->toJson();
    }
  }

  //
  public function getById(Employee $employee)
  {
    return Person::with('employee', 'civil_status', 'phones.type', 'addresses', 'images')->find($employee->person_id);
  }

  // vista para crear empleado
  public function create()
  {
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

    return view('employee-adm.edit', compact('phone_types', 'municipios', 
                  'parroquias', 'edoCivil', 'tipoSangre', 'cargos', 'status', 'tipos', 'ubicaciones'));
  }

  // agregar empleado
  public function store(Request $request)
  {
    $request->validate([
      'cedula'                => 'required|min:7|max:15|unique:people',
      'rif'                   => 'required|max:20|unique:employees',
      'name'                  => 'required|max:200',
      'sex'                   => 'required|max:1',
      'birthday'              => 'required|date',
      'place_of_birth'        => 'required|max:255',
      'civil_status_id'       => 'required',
      'email'                 => 'required|email|unique:people',
      'codigo'                => 'required|max:20',
      'fecha_ingreso'         => 'required|date',
      'employee_cargo_id'     => 'required',
      'employee_condicion_id' => 'required',
      'employee_tipo_id'      => 'required',
      'employee_location_id'  => 'required',
      'codigo_patria'         => 'required|max:20',
      'religion'              => 'required|max:100',
      'deporte'               => 'required|max:100',
      'licencia'              => 'required|max:100',
      'phone_type_id'         => 'required',
      'phone_number'          => 'required',
    ]);

    // agrego los datos personales
    $person = Person::create($request->only([
      'cedula', 'name', 'sex', 'birthday', 'place_of_birth', 'civil_status_id', 'email', 'notes'
    ]));

    // agrego los datos administrativos
    $employeeData = $request->only('codigo', 'fecha_ingreso', 'employee_cargo_id', 'employee_condicion_id',
                      'employee_tipo_id', 'employee_location_id', 'rif', 'codigo_patria',
                      'religion', 'deporte', 'licencia');
    $employeeData['person_id'] = $person->id;
    $employeeData['grupo_id'] = $this->grupo_id;
    $employee = Employee::create($employeeData);

    // agrego los telefonos del empleado
    $this->_addPhones($person, $request->input('phone_type_id'), $request->input('phone_number'));

    // agrego las direcciones del empleado
    $this->_addAddresses($person, 
                        $request->input('address'),
                        $request->input('parroquia_id'),
                        $request->input('zona_postal'));

    //
    return $person;
  }

  // edicion de emplado
  public function edit(Employee $employees_adm)
  {
    $data = $this->getById($employees_adm);
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

    return view('employee-adm.edit', compact('phone_types', 'municipios', 
                  'parroquias', 'edoCivil', 'tipoSangre', 'cargos', 'status', 'tipos', 'ubicaciones', 'data'));
  }

  // agregar los telefonos del empleado
  private function _addPhones($person, $phonesTypeIds, $phonesNumbers)
  {
    $phones = [];
    foreach($phonesTypeIds as $indice => $phoneTypeId) {
      $phones[] = new Phone([
                      'phone_type_id' => $phoneTypeId,
                      'number'        => $phonesNumbers[$indice]
                    ]);
    };
    $person->phones()->delete();
    $person->phones()->saveMany($phones);
  }

  // agregar las direcciones del empleado
  private function _addAddresses($person, $addresses, $parroquia_id, $zona_postal)
  {
    $addresses = [];
    foreach($addresses as $indice => $address) {
      $addresses[] = new Address([
        'address'       => $address,
        'parroquia_id'  => $parroquia_id[$indice],
        'zona_postal'   => $zona_postal[$indice]
      ]);
    };

    $person->addresses()->delete();
    $person->addresses()->saveMany($addresses);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Employee $employees_adm)
  {
    /*
    $this->validate($request, [
      'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    ]);
    */
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

    // eliminar las imagenes que el usuario selecciono
    foreach($request->images as $image) {
      if($image['deleted']) {
        $employeeImage = PersonImage::find($image['id']);
        $employeeImage->delete();
        unlink($image['file']);
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

  //
  public function show(Employee $employees_adm)
  {
    $data = $this->getById($employees_adm);

    $pdf = Facade\Pdf::loadView('employee-adm.view', compact('data'));
    
    return $pdf->stream("ea-".$data->cedula);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(int $employees_id)
  {
    $person = Person::find($employees_id);
    if(!is_null($person)) {
      $person->delete();
    }
    
    return Response::HTTP_NO_CONTENT;
  }
}