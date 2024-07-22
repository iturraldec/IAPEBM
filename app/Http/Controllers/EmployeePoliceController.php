<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeePoliceStoreRequest;
use App\Http\Requests\EmployeePoliceUpdateRequest;
use Symfony\Component\HttpFoundation\Response;
use Barryvdh\DomPDF\Facade;
use App\Clases\Image;

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

  //
  private $_imagen;

  //
  private $_employee_type_id = 3;

  //
  public function __construct(Image $imagen)
  {
    $this->_imagen = $imagen;
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
      $employees = Employee::where('grupo_id', $this->_employee_type_id)
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
    $_estados     = new UbicacionController();
    $ccps         = Ccps::OrderBy('name')->get();
    $cargos       = Cargo::OrderBy('name')->where('activo', TRUE)->get();
    $condiciones  = Condicion::OrderBy('name')->get();
    $tipos        = Tipo::OrderBy('name')->get();
    $estados      = $_estados->getEstados();

    return view('employee-police.create', compact('cargos', 'condiciones', 'tipos', 'ccps', 'estados'));
  }

  // agregar empleado
  public function store(EmployeePoliceStoreRequest $request)
  {
    // agrego los datos personales
    $data_person = $request->only([
      'cedula', 'first_name', 'second_name', 'first_last_name', 'second_last_name', 
      'sex', 'birthday', 'place_of_birth', 'civil_status_id', 'blood_type', 'notes', 'passport_nro']);
    $data_person['imagef'] = 'assets/images/avatar.png';
    $data_person['imageli'] = 'assets/images/avatar.png';
    $data_person['imageld'] = 'assets/images/avatar.png';

    // creo la carpeta del empleado
    $employeeFolderPath = storage_path("app/public/employees/") . $data_person['cedula'];
    mkdir($employeeFolderPath);

    // cambio de avatar frontal?
    if($request->has('imagef')) {
      $imageName = uniqid() . '.png';
      $data_person['imagef'] = "images/{$data_person['cedula']}/$imageName";
      Image::make($request->file('imagef')->getRealPath())
                ->resize(200,200)
                ->save($employeeFolderPath . $imageName, 0, 'png');
    }

    // cambio de avatar lado izquierdo?
    if($request->has('imageli')) {
      $imageName = uniqid() . '.png';
      $data_person['imageli'] = "images/{$data_person['cedula']}/$imageName";
      Image::make($request->file('imageli')->getRealPath())
                ->resize(200,200)
                ->save($employeeFolderPath . $imageName, 0, 'png');
    }

    // cambio de avatar lado derecho?
    if($request->has('imageld')) {
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
                                  'religion', 'deporte', 'licencia', 'cta_bancaria_nro', 'passport_nro');
    $employeeData['person_id'] = $person->id;
    $employeeData['grupo_id'] = $this->_employee_type_id;
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
    $_estados         = new UbicacionController();
    $ccps             = Ccps::OrderBy('name')->get();
    $cargos           = Cargo::OrderBy('name')->get();
    $condiciones      = Condicion::OrderBy('name')->get();
    $tipos            = Tipo::OrderBy('name')->get();
    $estados          = $_estados->getEstados();
    $data['person']   = Person::getById($employees_polouse->person_id);
    $data['employee'] = $employees_polouse;
    $data['police']  = Police::where('employee_id', $employees_polouse->id)->first();
    
    return view('employee-police.edit', compact('estados', 'ccps', 'cargos', 'condiciones', 'tipos', 'data'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(EmployeePoliceUpdateRequest $request, Employee $employees_polouse)
  {
    // actualizo la persona
    $dataPerson = Person::select('imagef', 'imageli', 'imageld')->find($employees_polouse->person_id);
    $inputPerson = $request->only(['cedula', 'first_name', 'second_name', 'first_last_name', 'second_last_name',
                                  'sex', 'birthday', 'place_of_birth', 'civil_status_id', 'blood_type',
                                  'passport_nro', 'notes']);

    $employeeFolderPath = storage_path("app/public/employees/{$inputPerson['cedula']}/");

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

    Person::where('id', $employees_polouse->person_id)->update($inputPerson);

return response($employees_polouse);
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