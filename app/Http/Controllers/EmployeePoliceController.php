<?php

namespace App\Http\Controllers;

use Intervention\Image\ImageManagerStatic as Image;
use Symfony\Component\HttpFoundation\Response;
use Barryvdh\DomPDF\Facade;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

use App\Models\Address;
use App\Models\Employee;
use App\Models\Person;
use App\Models\Email;
use App\Models\Phone;
use App\Models\Cargo;
use App\Models\Condicion;
use App\Models\Tipo;
use App\Models\Ccps;
use App\Models\Police;

//
class EmployeePoliceController extends Controller
{
  private $grupo_id;

  public function __construct()
  { 
    $this->grupo_id = 3;
  }

  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    if(! request()->ajax()) {
      return view('employee-police.index');
    }
    else {
      $employees = Employee::where('grupo_id', $this->grupo_id)
                              ->join('people', 'employees.person_id', '=', 'people.id')
                              ->orderBy('people.first_last_name')
                              ->orderBy('people.second_last_name')
                              ->with('person')
                              ->get();

      return datatables()->of($employees)->toJson();
    }
  }

  // vista para crear empleado
  public function create()
  {
    $_estados = new UbicacionController();
    $ccps = Ccps::OrderBy('name')->get();
    $cargos = Cargo::OrderBy('name')->get();
    $condiciones = Condicion::OrderBy('name')->get();
    $tipos = Tipo::OrderBy('name')->get();
    $estados = $_estados->getEstados();

    return view('employee-police.create', compact('cargos', 'condiciones', 'tipos', 'ccps', 'estados'));
  }

  // agregar empleado
  public function store(Request $request)
  {
    // validacion de los datos
    $request->validate([
      'cedula'                => 'required|min:7|max:15|unique:people',
      'rif'                   => 'required|max:20|unique:employees',
      'first_name'            => 'required|max:50',
      'second_name'           => 'max:50',
      'first_last_name'       => 'required|max:50',
      'second_last_name'      => 'max:50',
      'sex'                   => 'required|max:1',
      'birthday'              => 'required|date',
      'place_of_birth'        => 'required|max:255',
      'civil_status_id'       => 'required',
      'blood_type'            => 'required|max:5',
      'codigo_nomina'         => 'required|max:20',
      'fecha_ingreso'         => 'required|date',
      'cargo_id'              => 'required',
      'condicion_id'          => 'required',
      'tipo_id'               => 'required',
      'ccp_id'                => 'required',
      'codigo_patria'         => 'required|max:20',
      'serial_patria'         => 'required|max:20',
      'religion'              => 'required|max:100',
      'deporte'               => 'required|max:100',
      'licencia'              => 'required|max:100',
      'nro_cta_bancaria'      => 'required|max:30',
      'emails'                => 'required',
      'phones'                => 'required',
      'parroquias_id'         => 'required',
      'addresses'             => 'required',
      'escuela'               => 'required|max:100',
      'fecha_graduacion'      => 'required|date',
      'curso'                 => 'required|max:10',
      'curso_duracion'        => 'required|max:50',
      'cup'                   => 'required|max:10',
    ]);

    // agrego los datos personales
    $data_person = $request->only([
      'cedula', 'first_name', 'second_name', 'first_last_name', 'second_last_name', 
      'sex', 'birthday', 'place_of_birth', 'civil_status_id', 'blood_type', 'notes']);

    // creo la carpeta del empleado
    $employeeFolderPath = storage_path("app/public/employees/") . $data_person['cedula'] . '/';
    mkdir($employeeFolderPath);

    // cambio de avatar frontal?
    if(! $request->has('imagef')) {
      $data_person['imagef'] = 'assets/images/avatar.png';
    }
    else {
      $imageName = uniqid() . '.png';
      $data_person['imagef'] = "images/{$data_person['cedula']}/$imageName";
      Image::make($request->file('imagef')->getRealPath())
                ->resize(200,200)
                ->save($employeeFolderPath . $imageName, 0, 'png');
    }

    // cambio de avatar lado izquierdo?
    if(! $request->has('imageli')) {
      $data_person['imageli'] = 'assets/images/avatar.png';
    }
    else {
      $imageName = uniqid() . '.png';
      $data_person['imageli'] = "images/{$data_person['cedula']}/$imageName";
      Image::make($request->file('imageli')->getRealPath())
                ->resize(200,200)
                ->save($employeeFolderPath . $imageName, 0, 'png');
    }

    // cambio de avatar lado derecho?
    if(! $request->has('imageld')) {
      $data_person['imageld'] = 'assets/images/avatar.png';
    }
    else {
      $imageName = uniqid() . '.png';
      $data_person['imageld'] = "images/{$data_person['cedula']}/$imageName";
      Image::make($request->file('imageld')->getRealPath())
              ->resize(200,200)
              ->save($employeeFolderPath . $imageName, 0, 'png');
    }

    // agrego la persona
    $person = Person::create($data_person);

    // agrego los correos del empleado
    $this->_addEmails($person, $request->input('emails'));

    // agrego los telefonos del empleado
    $this->_addPhones($person, $request->input('phones_type_id'), $request->input('phones'));

    // agrego las direcciones del empleado
    $this->_addAddresses($person, $request->input('parroquias_id'), $request->input('addresses'), $request->input('zona_postal'));

    // agrego los datos administrativos
    $employeeData = $request->only('codigo_nomina', 'fecha_ingreso', 'cargo_id', 'condicion_id',
                                  'tipo_id', 'ccp_id', 'rif', 'codigo_patria', 'serial_patria',
                                  'religion', 'deporte', 'licencia', 'nro_cta_bancaria');
    $employeeData['person_id'] = $person->id;
    $employeeData['grupo_id'] = $this->grupo_id;
    $employee = Employee::create($employeeData);

    // agrego los datos policiales
    $employeeData = $request->only('escuela', 'fecha_graduacion', 'curso', 'curso_duracion', 'cup');
    $employeeData['employee_id'] = $employee->id;
    Police::create($employeeData);

    //
    return response($person, Response::HTTP_CREATED);
  }

  // edicion de emplado
  public function edit(Employee $employees_polouse)
  {
    $location     = new Location();
    $phone_types  = PhoneType::get();
    $municipios   = $location->getMunicipios();
    $parroquias   = $location->getParroquias();
    $edoCivil     = CivilStatus::get();
    $tipoSangre   = BloodType::get();
    $cargos       = Cargo::OrderBy('name')->get();
    $status       = EmployeeStatus::OrderBy('name')->get();
    $tipos        = EmployeeTipos::OrderBy('name')->get();
    $ubicaciones  = EmployeeLocations::OrderBy('name')->get();
    $data['person']                       = Person::getById($employees_polouse->person_id);
    $data['employee']                     = $employees_polouse;
    $police                               = Police::where('employee_id', $employees_polouse->id)->first();
    $data['employee']['escuela']          = $police->escuela;
    $data['employee']['fecha_graduacion'] = $police->fecha_graduacion;
    $data['employee']['curso']            = $police->curso;
    
    return view('employee-police.edit', compact('phone_types', 'municipios', 
                  'parroquias', 'edoCivil', 'tipoSangre', 'cargos', 'status', 'tipos', 'ubicaciones', 'data'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Employee $employees_polouse)
  {
    // validacion de los datos
    $request->validate([
      'cedula' => [
        'required',
        'min:7',
        'max:15',
        Rule::unique('people')->ignore($employees_polouse->person_id)
      ],
      'rif' => [
        'required',
        'max:20',
        Rule::unique('employees')->ignore($employees_polouse->id)
      ],
      'name'                  => 'required|max:200',
      'sex'                   => 'required|max:1',
      'birthday'              => 'required|date',
      'place_of_birth'        => 'required|max:255',
      'civil_status_id'       => 'required',
      'blood_type_id'         => 'required',
      'email' => [
        'required',
        'email',
        Rule::unique('people')->ignore($employees_polouse->person_id)
      ],
      'codigo_nomina'         => 'required|max:20',
      'fecha_ingreso'         => 'required|date',
      'employee_cargo_id'     => 'required',
      'employee_condicion_id' => 'required',
      'employee_tipo_id'      => 'required',
      'employee_location_id'  => 'required',
      'codigo_patria'         => 'required|max:20',
      'serial_patria'         => 'required|max:20',
      'religion'              => 'required|max:100',
      'deporte'               => 'required|max:100',
      'licencia'              => 'required|max:100',
      'phone_type_id'         => 'required',
      'phone_number'          => 'required',
      'parroquia_id'          => 'required',
      'address'               => 'required|max:255',
      'escuela'               => 'required|max:100',
      'fecha_graduacion'      => 'required|date',
      'curso'                 => 'required|max:10',
    ]);

    // actualizo la persona
    $person                   = Person::find($employees_polouse->person_id);
    $person->cedula           = $request->cedula;
    $person->name             = $request->name;
    $person->sex              = $request->sex;
    $person->birthday         = $request->birthday;
    $person->place_of_birth   = $request->place_of_birth;
    $person->civil_status_id  = $request->civil_status_id;
    $person->blood_type_id    = $request->blood_type_id;
    $person->email            = $request->email;
    $person->notes            = $request->notes;

    // cambio de avatar?
    if($request->has('imagen')) {
      $employeeFolderPath = storage_path('app/public/employees/') . $person->cedula . '/';
      $imageName = uniqid() . '.png';
      if(! str_contains($person->image, 'avatar.png')) {
        $file = str_replace('image/', $employeeFolderPath, $person->image);
        if(file_exists($file)) unlink($file);
      } 
      Image::make($request->file('imagen')->getRealPath())
              ->resize(200,200)
              ->save($employeeFolderPath . $imageName, 0, 'png');

      $person->image = "images/{$person->cedula}/" . $imageName;
    }

    $person->save();

    // actualizo sus telefonos
    $this->_addPhones($person, $request->phone_type_id, $request->phone_number);

    // actualizo sus direcciones
    $this->_addAddresses($person, 
                        $request->input('address'),
                        $request->input('parroquia_id'),
                        $request->input('zona_postal'));

    // eliminar las imagenes que el usuario elimino
    if($request->has('imagesDeleted')) {
      foreach($request->imagesDeleted as $id) {
        $employeeImage = PersonImage::find($id);
        $employeeImage->delete();
        unlink(storage_path('app/public/employee') . str_replace('image', '', $employeeImage->file));
      }
    }
    // modifico los datos del administrativos
    $employees_polouse->codigo_nomina         = $request->input('codigo_nomina');
    $employees_polouse->fecha_ingreso         = $request->input('fecha_ingreso');
    $employees_polouse->employee_cargo_id     = $request->input('employee_cargo_id');
    $employees_polouse->employee_condicion_id = $request->input('employee_condicion_id');
    $employees_polouse->employee_tipo_id      = $request->input('employee_tipo_id');
    $employees_polouse->employee_location_id  = $request->input('employee_location_id');
    $employees_polouse->rif                   = $request->input('rif');
    $employees_polouse->codigo_patria         = $request->input('codigo_patria');
    $employees_polouse->serial_patria         = $request->input('serial_patria');
    $employees_polouse->religion              = $request->input('religion');
    $employees_polouse->deporte               = $request->input('deporte');
    $employees_polouse->licencia              = $request->input('licencia');
    $employees_polouse->nro_cta_bancaria      = $request->input('nro_cta_bancaria');
    $employees_polouse->save();

    // modifico los datos policiales
    $police = Police::where('employee_id', $employees_polouse->id)->first();
    $police->escuela               = $request->input('escuela');
    $police->fecha_graduacion      = $request->input('fecha_graduacion');
    $police->curso                 = $request->input('curso');
    $police->save();
    
    //
    return response(Response::HTTP_OK);
  }

  // agregar los correos del empleado
  private function _addEmails($person, $emails)
  {
    $_emails = [];
    foreach($emails as $email) {
      $_emails[] = new Email(['email' => $email]);
    };

    $person->emails()->delete();
    $person->emails()->saveMany($_emails);
  }

  // agregar los telefonos del empleado
  private function _addPhones($person, $phonesTypeId, $phonesNumbers)
  {
    $phones = [];
    foreach($phonesTypeId as $indice => $phoneTypeId) {
      $phones[] = new Phone([
                      'phone_type_id' => $phoneTypeId,
                      'number'        => $phonesNumbers[$indice]
                    ]);
    };

    $person->phones()->delete();
    $person->phones()->saveMany($phones);
  }

  // agregar las direcciones del empleado
  private function _addAddresses($person, $parroquias_id, $addresses, $zona_postal)
  {
    $_addresses = [];
    foreach($addresses as $indice => $address) {
      $_addresses[] = new Address([
                        'parroquia_id'  => $parroquias_id[$indice],
                        'address'       => $address,
                        'zona_postal'   => $zona_postal[$indice]
                      ]);
    };
    $person->addresses()->delete();
    $person->addresses()->saveMany($_addresses);
  }

  //
  public function show(Employee $employees_adm)
  {
    $data = Person::getById($employees_adm->person_id);

    $pdf = Facade\Pdf::loadView('employee-adm.view', compact('data'));
    
    return $pdf->stream("ea-".$data->cedula);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Employee $employees_polouse)
  {
    $person = Person::find($employees_polouse->person_id);
    if(!is_null($person)) {
      $person->delete();
    }
    
    return Response::HTTP_NO_CONTENT;
  }
}