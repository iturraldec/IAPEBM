<?php

namespace App\Http\Controllers;

use App\Clases\EmpleadoPolicial;
use App\Http\Requests\EmployeePoliceStoreRequest;
use App\Http\Requests\EmployeePoliceUpdateRequest;
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
use App\Models\Police;
use App\Models\Rango;
use App\Models\PoliceRango;

//
class EmployeePoliceController extends Controller
{

  //
  private $_imagen;

  //
  private $_empleado;

  //
  private $_requestResponse;

  //
  public function __construct(EmpleadoPolicial $empleado, Image $imagen, RequestResponse $requestResponse)
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
                             : view('employee-police.index');
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
    $rangos       = Rango::orderBy('name')->get();
    $fisionomia   = Fisionomia::orderBy('descripcion')->get();

    return view('employee-police.create', compact('cargos', 'condiciones', 'tipos', 'unidades', 'estados', 'rangos', 'fisionomia'));
  }

  // agregar empleado
  public function store(EmployeePoliceStoreRequest $request)
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

    // agrego los datos administrativos
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

    // agrego los datos policiales
    $inputPolice = $request->only('escuela', 'fecha_graduacion', 'curso', 'curso_duracion', 'cup');
    $inputPolice['employee_id'] = $employee->id;
    $police = Police::create($inputPolice);

    // agrego el rango
    $this->_addRangos($police, $request->rango_id, $request->rango_fecha);

    //
    $this->_requestResponse->success = true;
    $this->_requestResponse->message = 'Uniformado creado!';
    $this->_requestResponse->data    = $police;

    return response()->json($this->_requestResponse, Response::HTTP_CREATED);
  }

  // edicion de emplado
  public function edit(Employee $employees_polouse)
  {
    $_estados         = new UbicacionController();
    $unidades         = Unidad::unidades();
    $cargos           = Cargo::OrderBy('name')->get();
    $condiciones      = Condicion::OrderBy('name')->get();
    $tipos            = Tipo::OrderBy('name')->get();
    $estados          = $_estados->getEstados();
    $rangos           = Rango::orderBy('name')->get();
    $data['person']   = Person::getById($employees_polouse->person_id);
    $data['employee'] = $employees_polouse;
    $data['police']   = Police::where('employee_id', $employees_polouse->id)->first();
    
    return view('employee-police.edit', compact('estados', 'unidades', 'cargos', 'condiciones', 'tipos', 'rangos', 'data'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(EmployeePoliceUpdateRequest $request, Employee $employees_polouse)
  {
    // actualizo la persona
    $dataPerson = Person::select('id', 'imagef', 'imageli', 'imageld')->find($employees_polouse->person_id);
    $inputPerson = $request->only(['cedula', 'first_name', 'second_name', 'first_last_name', 'second_last_name',
                                  'sex', 'birthday', 'place_of_birth', 'civil_status_id', 'blood_type', 'notes']);

    $employeeFolderPath = $this->_makeEmployeeFolder($inputPerson['cedula']);

    if ($request->hasfile('imagef')) {
      if(! str_contains($dataPerson->imagef, 'avatar.png')) {
        $image = $employeeFolderPath . basename($dataPerson->imagef);
        if(file_exists($image)) unlink($image);
      }
      $inputPerson['imagef'] = "images/{$inputPerson['cedula']}/" . $this->_imagen->store($request->file('imagef'), $employeeFolderPath);
    }

    if ($request->hasfile('imageli')) {
      if(! str_contains($dataPerson->imageli, 'avatar.png')) {
        $image = $employeeFolderPath . basename($dataPerson->imageli);
        if(file_exists($image)) unlink($image);
      }
      $inputPerson['imageli'] = "images/{$inputPerson['cedula']}/" . $this->_imagen->store($request->file('imageli'), $employeeFolderPath);
    }

    if ($request->hasfile('imageld')) {
      if(! str_contains($dataPerson->imageld, 'avatar.png')) {
        $image = $employeeFolderPath . basename($dataPerson->imageld);
        if(file_exists($image)) unlink($image);
      }
      $inputPerson['imageld'] = "images/{$inputPerson['cedula']}/" . $this->_imagen->store($request->file('imageld'), $employeeFolderPath);
    }

    $dataPerson->update($inputPerson);

    // actualizo sus correos
    $this->_addEmails($dataPerson, $request->emails);

    // actualizo sus telefonos
    $this->_addPhones($dataPerson, $request->phones_type_id, $request->phones);

    // actualizo sus direcciones
    $this->_addAddresses($dataPerson, $request->parroquias_id, $request->addresses, $request->zona_postal);

    // actualizo los datos del administrativos
    $inputEmployee = $request->only('codigo_nomina', 'fecha_ingreso', 'cargo_id', 'condicion_id', 'tipo_id',
                                    'unidad_id', 'rif', 'codigo_patria', 'serial_patria', 'religion', 'deporte',
                                    'licencia', 'cta_bancaria_nro', 'passport_nro');

    $employees_polouse->update($inputEmployee);

    // actualizo los familiares
    $employees_polouse->familiares()->delete();
    $this->_addFamiliares($employees_polouse, $request);

    // actualizo estudio
    $this->_empleado->updEstudios($employees_polouse, json_decode($request->estudiosDT));

    // actualizo sus permisos
    if($request->has('permisos_desde')) {
      $this->_empleado->updPermisos($employees_polouse, $request->only(['permisos_desde', 'permisos_hasta', 'permisos_motivo']));
    }

    // actualizo reposos
    $this->_empleado->updReposos($employees_polouse, json_decode($request->repososDT));

    // actualizo sus vacaciones
    $employees_polouse->vacaciones()->delete();
    if($request->has('vacaciones_desde')) {
      $vacaciones = [];
      foreach($request->vacaciones_desde as $indice => $desde) {
        $vacaciones[] = new Vacacione([
                        'employee_id' => $employees_polouse->id,
                        'desde'       => $desde,
                        'hasta'       => $request->vacaciones_hasta[$indice],
                        'periodo'     => $request->vacaciones_periodo[$indice],
                    ]);
      };
      $employees_polouse->vacaciones()->saveMany($vacaciones);
    };

    // actualizo los datos fisionomicos
    $fisionomia_id = $request->fisionomia_id;
    $fisionomia = $request->fisionomia;
    $employees_polouse->fisionomia()->delete();
    $_fisionomia = [];
    foreach($fisionomia_id as $indice => $item) {
      $_fisionomia[] = new EmpleadoFisionomia([
                        'employee_id'   => $employees_polouse->id, 
                        'fisionomia_id' => $item, 
                        'info'          => $fisionomia[$indice]
                      ]);
    };
    $employees_polouse->fisionomia()->saveMany($_fisionomia);

    // actualizo los datos policiales
    $inputPolice = $request->only('escuela', 'fecha_graduacion', 'curso', 'curso_duracion', 'cup');
    $police = Police::where('employee_id', $employees_polouse->id)->first();
    $police->update($inputPolice);

    // actualizo el rango
    $this->_addRangos($police, $request->rangos_id, $request->rangos_fecha);

    //
    $this->_requestResponse->success = true;
    $this->_requestResponse->message = 'Uniformado actualizado!';

    return response()->json($this->_requestResponse, Response::HTTP_OK);
  }

  // agregar los rangos
  private function _addRangos(Police $police, $rango_id, $rango_fecha)
  {
    $rangos = [];
    foreach($rango_id as $indice => $rango) {
      $rangos[] = new PoliceRango([
                        'police_id'       => $police->id,
                        'rango_id'        => $rango,
                        'documento_fecha' => $rango_fecha[$indice],
                      ]);
    };
    $police->rangos()->delete();
    $police->rangos()->saveMany($rangos);
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
    
    //
    $this->_requestResponse->success = true;
    $this->_requestResponse->message = 'Uniformado eliminado!';

    return response()->json($this->_requestResponse, Response::HTTP_OK);
  }
}