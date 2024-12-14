<?php

namespace App\Http\Controllers;

use App\Clases\EmpleadoPolicial;
use App\Http\Requests\EmployeePoliceStoreRequest;
use App\Http\Requests\EmployeePoliceUpdateRequest;
use Symfony\Component\HttpFoundation\Response;
use Barryvdh\DomPDF\Facade;
use App\Clases\Image;
use App\Clases\RequestResponse;
use Illuminate\Support\Facades\DB;

use App\Models\Cargo;
use App\Models\Condicion;
use App\Models\Tipo;
use App\Models\Unidad;
use App\Models\Person;
use App\Models\Employee;
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
    if ($crear && ! file_exists($path)) mkdir($path);

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
    $estados      = $_estados->getEstados();
    $rangos       = Rango::orderBy('name')->get();

    return view('employee-police.create', compact('cargos', 'unidades', 'estados', 'rangos'));
  }

  // agregar empleado
  public function store(EmployeePoliceStoreRequest $request)
  {
    // agrego los datos personales
    $data_person = $request->only([
                                    'cedula', 'first_name', 'second_name', 'first_last_name', 'second_last_name', 
                                    'sex', 'birthday', 'place_of_birth', 'civil_status_id', 'blood_type', 'notes'
                                  ]);
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
    $inputEmployee = $request->only([
                                      'codigo_nomina', 'fecha_ingreso', 'cargo_id', 'unidad_id', 'rif', 'codigo_patria', 'serial_patria',
                                      'religion', 'deporte', 'licencia', 'cta_bancaria_nro', 'passport_nro',
                                      'fisio_barba', 'fisio_bigote', 'fisio_boca', 'fisio_cabello','fisio_cara', 'fisio_frente', 'fisio_tez', 
                                      'fisio_contextura', 'fisio_dentadura', 'fisio_estatura', 'fisio_labios', 'fisio_lentes', 
                                      'fisio_nariz', 'fisio_ojos', 'fisio_peso', 'fisio_calzado', 'fisio_camisa', 'fisio_gorra',
                                      'fisio_pantalon', 'fisio_otros'
                                    ]);
    $inputEmployee['person_id']     = $person->id;
    $inputEmployee['type_id']       = $this->_empleado->getType();
    $inputEmployee['condicion_id']  = 1; //ACTIVO
    $inputEmployee['tipo_id']       = 1; //FUNCIONARIO POLICIAL
    $employee = Employee::create($inputEmployee);

    // crear el usuario del empleado
    $this->_empleado->cedula = $data_person['cedula'];
    $this->_empleado->first_name = $data_person['first_name'];
    $this->_empleado->second_name = $data_person['second_name'];
    $this->_empleado->first_last_name = $data_person['first_last_name'];
    $this->_empleado->second_last_name = $data_person['second_last_name'];
    $this->_empleado->createUser();

    // agrego los correos del empleado
    $this->_empleado->updEmails($employee, json_decode($request->emails));

    // agrego los telefonos del empleado
    $this->_empleado->updPhones($employee, json_decode($request->phones));

    // agrego las direcciones del empleado
    $this->_empleado->updAddresses($employee, json_decode($request->addresses));

    // agrego la familia del empleado
    $this->_empleado->updFamily($employee, json_decode($request->family));

    // agrego los datos academicos
    $this->_empleado->updEstudios($employee, json_decode($request->estudios));

    // agrego los datos policiales
    $inputPolice = $request->only([
                                    'escuela', 'fecha_graduacion', 'curso', 'curso_duracion', 'cup'
                                  ]);
    $inputPolice['employee_id'] = $employee->id;
    $police = Police::create($inputPolice);

    // agrego el rango
    PoliceRango::create([
                    'police_id'       => $police->id,
                    'rango_id'        => $request->rango_id,
                    'documento_fecha' => $request->rango_fecha,
                  ]);

    //
    $this->_requestResponse->success = true;
    $this->_requestResponse->message = 'Uniformado creado!';
    $this->_requestResponse->data    = $police;

    return response()->json($this->_requestResponse, Response::HTTP_CREATED);
  }

  // edicion de empleado
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
    $data['police']   = Police::where('employee_id', $employees_polouse->id)->with('rangos.rango')->first();
    
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

    // creo su carpeta
    $employeeFolderPath = $this->_makeEmployeeFolder($inputPerson['cedula']);

    // guardo sus imagenes
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

    // actualizo los datos personales
    $dataPerson->update($inputPerson);

    // actualizo los correos del empleado
    $this->_empleado->updEmails($employees_polouse, json_decode($request->emails));

    // actualizo los telefonos del empleado
    $this->_empleado->updPhones($employees_polouse, json_decode($request->phones));

    // actualizo las direcciones del empleado
    $this->_empleado->updAddresses($employees_polouse, json_decode($request->addresses));

    // actualizo los datos del administrativos
    $inputEmployee = $request->only([
                                      'codigo_nomina', 'fecha_ingreso', 'cargo_id', 'condicion_id', 'tipo_id',
                                      'unidad_id', 'rif', 'codigo_patria', 'serial_patria', 'religion', 'deporte',
                                      'licencia', 'cta_bancaria_nro', 'passport_nro', 'fisio_barba', 'fisio_bigote', 'fisio_boca', 
                                      'fisio_cabello','fisio_cara', 'fisio_frente', 'fisio_tez', 
                                      'fisio_contextura', 'fisio_dentadura', 'fisio_estatura', 'fisio_labios', 'fisio_lentes', 
                                      'fisio_nariz', 'fisio_ojos', 'fisio_peso', 'fisio_calzado', 'fisio_camisa', 'fisio_gorra',
                                      'fisio_pantalon', 'fisio_otros'
                                    ]);

    $employees_polouse->update($inputEmployee);

    // actualizo los familiares
    $this->_empleado->updFamily($employees_polouse, json_decode($request->family));
    
    // actualizo los datos academicos
    $this->_empleado->updEstudios($employees_polouse, json_decode($request->estudios));

    // actualizo sus permisos
    $this->_empleado->updPermisos($employees_polouse, json_decode($request->permisos));

    // actualizo reposos
    $this->_empleado->updReposos($employees_polouse, json_decode($request->reposos));

    // actualizo sus vacaciones
    $this->_empleado->updVacaciones($employees_polouse, json_decode($request->vacaciones));
    
    // actualizo los datos policiales
    $inputPolice = $request->only('escuela', 'fecha_graduacion', 'curso', 'curso_duracion', 'cup');
    $police = Police::where('employee_id', $employees_polouse->id)->first();
    $police->update($inputPolice);

    // actualizo el rango
    foreach(json_decode($request->rangos) as $item) {
      switch($item->status) {
        case 'C': 
          DB::table('police_rangos')->insert([
            'police_id'       => $police->id,
            'rango_id'        => $item->rango_id,
            'documento_fecha' => $item->fecha,
            'created_at'      => date('Y-m-d H:i:s'),
          ]);
          break;
        case 'D' && $item->id > 0:
           DB::table('police_rangos')->where('id', $item->id)->delete();
          break;
      }
    }

    // finalizo actualizacion de uniformados
    $this->_requestResponse->success = true;
    $this->_requestResponse->message = 'Uniformado actualizado!';

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