<?php

namespace App\Http\Controllers;

use App\Clases\EmpleadoAdm;
use App\Http\Requests\EmployeeAdmStoreRequest;
use App\Http\Requests\EmployeeAdmUpdateRequest;
use Symfony\Component\HttpFoundation\Response;
use Barryvdh\DomPDF\Facade;
use App\Clases\Image;
use App\Clases\RequestResponse;

use App\Models\Cargo;
use App\Models\Condicion;
use App\Models\Tipo;
use App\Models\Unidad;
use App\Models\Person;
use App\Models\Employee;
use App\Models\Fisionomia;
use App\Models\EmpleadoFisionomia;

//
class EmployeeAdmController extends Controller
{

  //
  private $_imagen;

  //
  private $_empleado;

  //
  private $_requestResponse;

  //
  public function __construct(EmpleadoAdm $empleado,  Image $imagen, RequestResponse $requestResponse)
  {
    $this->_empleado = $empleado;
    $this->_imagen = $imagen;
    $this->_requestResponse = $requestResponse;
  }

  //
  private function _makeEmployeeFolder(string $cedula, bool $crear = FALSE) {
    $path = storage_path("app/public/employees/$cedula/");
    if ($crear) mkdir($path);

    return $path;
  }

  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return request()->ajax() ? datatables()->of(Employee::where('type_id', $this->_empleado->getType())->with('person')->with('cargo'))->toJson()
                             : view('employee-adm.index');
  }

  // vista para crear empleado
  public function create()
  {
    $_estados     = new UbicacionController();
    $unidades     = Unidad::unidades();
    $cargos       = Cargo::OrderBy('name')->where('activo', TRUE)->get();
    $condiciones  = Condicion::OrderBy('name')->get();
    $tipos        = Tipo::OrderBy('name')->get();
    $estados      = $_estados->getEstados();
    $fisionomia   = Fisionomia::orderBy('descripcion')->get();

    return view('employee-adm.create', compact('cargos', 'condiciones', 'tipos', 'unidades', 'estados', 'fisionomia'));
  }

  // agregar empleado
  public function store(EmployeeAdmStoreRequest $request)
  {
    // agrego los datos personales
    $data_person = $request->only([
      'cedula', 'first_name', 'second_name', 'first_last_name', 'second_last_name', 
      'sex', 'birthday', 'place_of_birth', 'civil_status_id', 'blood_type', 'notes']);
    $data_person['imagef'] = 'assets/images/avatar.png';
    $data_person['imageli'] = 'assets/images/avatar.png';
    $data_person['imageld'] = 'assets/images/avatar.png';

    // creo la carpeta del empleado  
    $employeeFolder = $this->_makeEmployeeFolder($data_person['cedula'], TRUE);

    // cambio de avatar frontal?
    if($request->hasFile('imagef')) {
      $imageName = $this->_imagen->store($request->file('imagef'), $employeeFolder);
      $data_person['imagef'] = "employees/{$data_person['cedula']}/$imageName";
    }

    // cambio de avatar lado izquierdo?
    if($request->hasFile('imageli')) {
      $imageName = $this->_imagen->store($request->file('imageli'), $employeeFolder);
      $data_person['imageli'] = "employees/{$data_person['cedula']}/$imageName";
    }

    // cambio de avatar lado derecho?
    if($request->hasFile('imageld')) {
      $imageName = $this->_imagen->store($request->file('imageld'), $employeeFolder);
      $data_person['imageld'] = "employees/{$data_person['cedula']}/$imageName";
    }

    // agrego la persona
    $person = Person::create($data_person);

    // agrego el empleado
    $inputEmployee = $request->only('codigo_nomina', 'fecha_ingreso', 'cargo_id', 'condicion_id',
                                    'tipo_id', 'unidad_id', 'rif', 'codigo_patria', 'serial_patria',
                                    'religion', 'deporte', 'licencia', 'cta_bancaria_nro', 'passport_nro');
    $inputEmployee['person_id'] = $person->id;
    $inputEmployee['type_id'] = $this->_empleado->getType();
    $employee = Employee::create($inputEmployee);

    // agrego los correos del empleado
    $this->_empleado->updEmails($employee, json_decode($request->emails));

    // agrego los telefonos del empleado
    $this->_empleado->updPhones($employee, json_decode($request->phones));

    // agrego las direcciones del empleado
    $this->_empleado->updAddresses($employee, json_decode($request->addresses));

    // agrego los datos fisionomicos
    if($request->has('fisionomia_id')) {
      $fisionomia_id = $request->fisionomia_id;
      $fisionomia = $request->fisionomia;
      
      foreach($fisionomia_id as $indice => $item) {
        EmpleadoFisionomia::create([
          'employee_id'   => $employee->id, 
          'fisionomia_id' => $item, 
          'info'          => $fisionomia[$indice]
        ]);
      };
    }

    // agrego la familia del empleado
    $this->_empleado->updFamily($employee, json_decode($request->family));

    // agrego los datos academicos
    $this->_empleado->updEstudios($employee, json_decode($request->estudios));

    //
    $this->_requestResponse->success = true;
    $this->_requestResponse->message = 'Empleado Administrativo creado!';
    $this->_requestResponse->data    = $employee;

    return response()->json($this->_requestResponse, Response::HTTP_CREATED);
  }

  // edicion de emplado
  public function edit(Employee $employees_adm)
  {
    $_estados         = new UbicacionController();
    $unidades         = Unidad::unidades();
    $cargos           = Cargo::OrderBy('name')->get();
    $condiciones      = Condicion::OrderBy('name')->get();
    $tipos            = Tipo::OrderBy('name')->get();
    $estados          = $_estados->getEstados();
    $data['person']   = Person::getById($employees_adm->person_id);
    $data['employee'] = $employees_adm;
    
    return view('employee-adm.edit', compact('estados', 'unidades', 'cargos', 'condiciones', 'tipos', 'data'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(EmployeeAdmUpdateRequest $request, Employee $employees_adm)
  {
    // actualizo la persona
    $dataPerson = Person::select('id', 'imagef', 'imageli', 'imageld')->find($employees_adm->person_id);
    $inputPerson = $request->only(['cedula', 'first_name', 'second_name', 'first_last_name', 'second_last_name',
                                  'sex', 'birthday', 'place_of_birth', 'civil_status_id', 'blood_type', 'notes']);

    $employeeFolderPath = $this->_makeEmployeeFolder($inputPerson['cedula']);

    if ($request->hasfile('imagef')) {
      if(! str_contains($dataPerson->imagef, 'avatar.png')) {
        $image = $employeeFolderPath . basename($dataPerson->imagef);
        if(file_exists($image)) unlink($image);
      }
      $inputPerson['imagef'] = "employees/{$inputPerson['cedula']}/" . $this->_imagen->store($request->file('imagef'), $employeeFolderPath);
    }

    if ($request->hasfile('imageli')) {
      if(! str_contains($dataPerson->imageli, 'avatar.png')) {
        $image = $employeeFolderPath . basename($dataPerson->imageli);
        if(file_exists($image)) unlink($image);
      }
      $inputPerson['imageli'] = "employees/{$inputPerson['cedula']}/" . $this->_imagen->store($request->file('imageli'), $employeeFolderPath);
    }

    if ($request->hasfile('imageld')) {
      if(! str_contains($dataPerson->imageld, 'avatar.png')) {
        $image = $employeeFolderPath . basename($dataPerson->imageld);
        if(file_exists($image)) unlink($image);
      }
      $inputPerson['imageld'] = "employees/{$inputPerson['cedula']}/" . $this->_imagen->store($request->file('imageld'), $employeeFolderPath);
    }

    $dataPerson->update($inputPerson);

    // actualizo los correos del empleado
    $this->_empleado->updEmails($employees_adm, json_decode($request->emails));

    // actualizo los telefonos del empleado
    $this->_empleado->updPhones($employees_adm, json_decode($request->phones));

    // actualizo las direcciones del empleado
    $this->_empleado->updAddresses($employees_adm, json_decode($request->addresses));

    // actualizo los datos del administrativos
    $inputEmployee = $request->only('codigo_nomina', 'fecha_ingreso', 'cargo_id', 'condicion_id', 'tipo_id',
                                    'unidad_id', 'rif', 'codigo_patria', 'serial_patria', 'religion', 'deporte',
                                    'licencia', 'cta_bancaria_nro', 'passport_nro');

    $employees_adm->update($inputEmployee);

    // actualizo los familiares    
    $this->_empleado->updFamily($employees_adm, json_decode($request->family));

    // actualizo los datos academicos
    $this->_empleado->updEstudios($employees_adm, json_decode($request->estudios));

    // actualizo sus permisos
    $this->_empleado->updPermisos($employees_adm, json_decode($request->permisos));

    // actualizo sus reposos
    $this->_empleado->updReposos($employees_adm, json_decode($request->repososDT));

    // actualizo las vacaciones
    $this->_empleado->updVacaciones($employees_adm, json_decode($request->vacaciones));

    // actualizo los datos fisionomicos
    $fisionomia_id = $request->fisionomia_id;
    $fisionomia = $request->fisionomia;
    $employees_adm->fisionomia()->delete();
    $_fisionomia = [];
    foreach($fisionomia_id as $indice => $item) {
      $_fisionomia[] = new EmpleadoFisionomia([
                        'employee_id'   => $employees_adm->id, 
                        'fisionomia_id' => $item, 
                        'info'          => $fisionomia[$indice]
                      ]);
    };
    $employees_adm->fisionomia()->saveMany($_fisionomia);

    //
    $this->_requestResponse->success = true;
    $this->_requestResponse->message = 'Empleado Administrativo actualizado!';

    return response()->json($this->_requestResponse, Response::HTTP_OK);
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
  public function destroy(Employee $employees_adm)
  {
    $person = Person::find($employees_adm->person_id);
    if(!is_null($person)) {
      $person->delete();
    }
    
    //
    $this->_requestResponse->success = true;
    $this->_requestResponse->message = 'Emplado Administrativo eliminado!';

    return response()->json($this->_requestResponse, Response::HTTP_OK);
  }
}