<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeAdmStoreRequest;
use App\Http\Requests\EmployeeAdmUpdateRequest;
use Symfony\Component\HttpFoundation\Response;
use Barryvdh\DomPDF\Facade;
use App\Clases\Image;
use App\Clases\RequestResponse;

use App\Models\Address;
use App\Models\Email;
use App\Models\Phone;
use App\Models\Cargo;
use App\Models\Condicion;
use App\Models\EmpleadoReposo;
use App\Models\Tipo;
use App\Models\Unidad;
use App\Models\Person;
use App\Models\Employee;
use App\Models\Fisionomia;
use App\Models\EmpleadoFisionomia;
use App\Models\Familia;
use App\Models\Vacacione;

//
class EmployeeAdmController extends Controller
{

  //
  private $_imagen;

  //
  private $_type_id = 1;

  //
  private $_requestResponse;

  //
  public function __construct(Image $imagen, RequestResponse $requestResponse)
  {
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
    return request()->ajax() ? datatables()->of(Employee::where('type_id', $this->_type_id)->with('person'))->toJson()
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
      $data_person['imagef'] = "images/{$data_person['cedula']}/$imageName";
    }

    // cambio de avatar lado izquierdo?
    if($request->hasFile('imageli')) {
      $imageName = $this->_imagen->store($request->file('imageli'), $employeeFolder);
      $data_person['imageli'] = "images/{$data_person['cedula']}/$imageName";
    }

    // cambio de avatar lado derecho?
    if($request->hasFile('imageld')) {
      $imageName = $this->_imagen->store($request->file('imageld'), $employeeFolder);
      $data_person['imageld'] = "images/{$data_person['cedula']}/$imageName";
    }

    // agrego la persona
    $person = Person::create($data_person);

    // agrego los correos del empleado
    $this->_addEmails($person, $request->emails);

    // agrego los telefonos del empleado
    $this->_addPhones($person, $request->phones_type_id, $request->phones);

    // agrego las direcciones del empleado
    $this->_addAddresses($person, $request->parroquias_id, $request->addresses, $request->zona_postal);

    // agrego el empleado
    $inputEmployee = $request->only('codigo_nomina', 'fecha_ingreso', 'cargo_id', 'condicion_id',
                                    'tipo_id', 'unidad_id', 'rif', 'codigo_patria', 'serial_patria',
                                    'religion', 'deporte', 'licencia', 'cta_bancaria_nro', 'passport_nro');
    $inputEmployee['person_id'] = $person->id;
    $inputEmployee['type_id'] = $this->_type_id;
    $employee = Employee::create($inputEmployee);

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

    // agrego los datos familiares
    $this->_addFamiliares($employee, $request);

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

    $employees_adm->update($inputEmployee);

    // actualizo los familiares
    $employees_adm->familiares()->delete();
    $this->_addFamiliares($employees_adm, $request);

    // actualizo reposos
    $employees_adm->reposos()->delete();
    if($request->has('reposos_desde')) {
      $reposos = [];
      foreach($request->reposos_desde as $indice => $desde) {
        $reposos[] = new EmpleadoReposo([
                        'employee_id' => $employees_adm->id,
                        'reposo_id'   => $request->reposos_id[$indice],
                        'desde'       => $desde,
                        'hasta'       => $request->reposos_hasta[$indice],
                        'observacion' => $request->reposos_observacion[$indice],
                    ]);
      };
      $employees_adm->reposos()->saveMany($reposos);
    };

    // actualizo sus vacaciones
    $employees_adm->vacaciones()->delete();
    if($request->has('vacaciones_desde')) {
      $vacaciones = [];
      foreach($request->vacaciones_desde as $indice => $desde) {
        $vacaciones[] = new Vacacione([
                            'employee_id' => $employees_adm->id,
                            'desde'       => $desde,
                            'hasta'       => $request->vacaciones_hasta[$indice],
                            'periodo'     => $request->vacaciones_periodo[$indice],
                        ]);
      };
      $employees_adm->vacaciones()->saveMany($vacaciones);
    };

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

  // agregar familiares del empleado
  private function _addFamiliares($employee, $request)
  {
    if($request->parentesco_id) {
      $parentesco_id  = $request->parentesco_id; 
      $pnombre        = $request->pnombre;
      $snombre        = $request->snombre;
      $papellido      = $request->papellido;
      $sapellido      = $request->sapellido;
    
      foreach($parentesco_id as $indice => $item) {
        Familia::create([
          'employee_id'       => $employee->id,
          'parentesco_id'     => $item,
          'first_name'        => $pnombre[$indice], 
          'second_name'       => $snombre[$indice], 
          'first_last_name'   => $papellido[$indice], 
          'second_last_name'  => $sapellido[$indice]
        ]);
      }
    }
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