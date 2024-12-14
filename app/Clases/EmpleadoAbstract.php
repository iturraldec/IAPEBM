<?php

namespace App\Clases;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Employee;
use App\Models\EmpleadoReposo;
use App\Models\User;

//
abstract class EmpleadoAbstract
{
  //
  protected $_type_id;

  //
  public $cedula;

  //
  public $first_name;
  
  //
  public $second_name;
  
  //
  public $first_last_name;
  
  //
  public $second_last_name;

  //
  public function __construct()
  {
    $this->_type_id = null;
  }

  //
  public function getType()
  {
    return $this->_type_id;
  }

  /*
    parametros:
      string $cedula
      $imagen
    retorna
      string ubicacion y nombre de la imagen guardada
  */
  public function storeImage(string $cedula, $imagen) : string
  {
    return $imagen->store(config('app_config.employees_path').$cedula);
  }

  // retorna el nombre completo del empleado
  public function fullName() : string
  {
    return $this->first_name . ' ' . $this->second_name . ' ' . $this->first_last_name . ' ' . $this->second_last_name;
  }

  // crear un usuario web, para el empleado
  public function createUser() : void 
  {
    $user = User::create([
        'code'      => $this->cedula,
        'name'      => $this->fullName(),
        'password'  => Hash::make(config('app_config.users_init_password')),
    ]);

    $user->assignRole('Usuario Web');
  }

  // actualizacion de los correos del empleado
  public function updEmails(Employee $empleado, array $data) : bool
  {
    foreach($data as $item) {
      switch($item->status) {
        // crear
        case 'C': 
          DB::table('emails')->insert(['person_id' => $empleado->person_id, 'email' => $item->email]);
          break;
        // eliminar
        case 'D' && $item->id > 0:
          DB::table('emails')->where('id', $item->id)->delete();
          break;
      }
    }
    return true;
  }

  // actualizacion de los telefonos del empleado
  public function updPhones(Employee $empleado, array $data) : bool
  {
    foreach($data as $item) {
      switch($item->status) {
        // crear
        case 'C': 
          DB::table('phones')->insert([
                                'person_id'     => $empleado->person_id, 
                                'phone_type_id' => $item->phone_type_id,
                                'number'        => $item->number
                              ]);
          break;
        // eliminar
        case 'D' && $item->id > 0:
          DB::table('phones')->where('id', $item->id)->delete();
          break;
      }
    }
    return true;
  }

  // actualizacion de las direcciones del empleado
  public function updAddresses(Employee $empleado, array $data) : bool
  {
    foreach($data as $item) {
      switch($item->status) {
        // crear
        case 'C': 
          DB::table('addresses')->insert([
                                'person_id'     => $empleado->person_id, 
                                'parroquia_id'  => $item->parroquia_id,
                                'address'       => $item->address,
                                'zona_postal'   => $item->zona_postal,
                              ]);
          break;
        // eliminar
        case 'D' && $item->id > 0:
          DB::table('addresses')->where('id', $item->id)->delete();
          break;
      }
    }
    return true;
  }

  // actualizacion de los familiares del empleado
  public function updFamily(Employee $empleado, array $data) : bool
  {
    foreach($data as $item) {
      switch($item->status) {
        // crear
        case 'C': 
          DB::table('familiares')->insert([
                                'employee_id'       => $empleado->id, 
                                'parentesco_id'     => $item->parentesco_id,
                                'first_name'        => $item->first_name,
                                'second_name'       => $item->second_name,
                                'first_last_name'   => $item->first_last_name,
                                'second_last_name'  => $item->second_last_name,
                              ]);
          break;
        // eliminar
        case 'D' && $item->id > 0:
          DB::table('familiares')->where('id', $item->id)->delete();
          break;
      }
    }
    return true;
  }

  // actualizacion de los datos academicos del empleado
  public function updEstudios(Employee $empleado, array $data) : bool
  {
    foreach($data as $estudio) {
      switch($estudio->status) {
        case 'C': 
          DB::table('empleado_estudios')->insert([
            'employee_id'     => $empleado->id,
            'estudio_type_id' => $estudio->tipo_id,
            'fecha'           => $estudio->fecha,
            'descripcion'     => $estudio->descripcion,
          ]);
          break;
        case 'D' && $estudio->id > 0:
           DB::table('empleado_estudios')->where('id', $estudio->id)->delete();
          break;
        }
      }

    return true;
  }

  // actualizacion de los permisos del empleado
  public function updPermisos(Employee $empleado, array $data) : bool
  {
    foreach($data as $permiso) {
      switch($permiso->status) {
        case 'C': 
          DB::table('permisos')->insert([
            'employee_id' => $empleado->id,
            'desde'       => $permiso->desde,
            'hasta'       => $permiso->hasta,
            'motivo'      => $permiso->motivo,
          ]);
          break;
        case 'D' && $permiso->id > 0:
           DB::table('permisos')->where('id', $permiso->id)->delete();
          break;
        }
      }

    return true;
  }

  // actualizacion de los reposos del empleado
  public function updReposos(Employee $empleado, array $data) : bool
  {
    foreach($data as $reposo) {
      if($reposo->id == '0' && $reposo->status != 'D') {
        DB::table('empleado_reposos')->insert([
                      'employee_id'     => $empleado->id,
                      'reposo_id'       => empty($reposo->reposo_id) ? null : $reposo->reposo_id,
                      'desde'           => $reposo->desde,
                      'hasta'           => $reposo->hasta,
                      'noti_fecha'      => $reposo->noti_fecha,
                      'noti_dr_ci'      => $reposo->noti_dr_ci,
                      'noti_dr_nombre'  => $reposo->noti_dr_nombre,
                      'noti_dr_mpps'    => $reposo->noti_dr_mpps,
                      'noti_dr_cms'     => $reposo->noti_dr_cms,
                      'conva_fecha'     => empty($reposo->conva_fecha) ? null : $reposo->conva_fecha,
                      'conva_dr_ci'     => empty($reposo->conva_dr_ci) ? null : $reposo->conva_dr_ci,
                      'conva_dr_nombre' => empty($reposo->conva_dr_nombre) ? null : $reposo->conva_dr_nombre,
                      'conva_dr_mpps'   => empty($reposo->conva_dr_mpps) ? null : $reposo->conva_dr_mpps,
                      'conva_dr_cms'    => empty($reposo->conva_dr_cms) ? null : $reposo->conva_dr_cms,
        ]);
      }
      else if($reposo->status == 'U') {
        DB::table('empleado_reposos')
          ->where('id', $reposo->id)
          ->update([
              'reposo_id'       => empty($reposo->reposo_id) ? null : $reposo->reposo_id,
              'desde'           => $reposo->desde,
              'hasta'           => $reposo->hasta,
              'noti_fecha'      => $reposo->noti_fecha,
              'noti_dr_ci'      => $reposo->noti_dr_ci,
              'noti_dr_nombre'  => $reposo->noti_dr_nombre,
              'noti_dr_mpps'    => $reposo->noti_dr_mpps,
              'noti_dr_cms'     => $reposo->noti_dr_cms,
              'conva_fecha'     => empty($reposo->conva_fecha) ? null : $reposo->conva_fecha,
              'conva_dr_ci'     => empty($reposo->conva_dr_ci) ? null : $reposo->conva_dr_ci,
              'conva_dr_nombre' => empty($reposo->conva_dr_nombre) ? null : $reposo->conva_dr_nombre,
              'conva_dr_mpps'   => empty($reposo->conva_dr_mpps) ? null : $reposo->conva_dr_mpps,
              'conva_dr_cms'    => empty($reposo->conva_dr_cms) ? null : $reposo->conva_dr_cms,
          ]
        );
      }
      else if($reposo->status == 'D' && $reposo->id != '0') {
        EmpleadoReposo::find($reposo->id)->delete();
      }
    }

    return true;
  }

  // actualizacion de las vacaciones del empleado
  public function updVacaciones(Employee $empleado, array $data) : bool
  {
    foreach($data as $item) {
      switch($item->status) {
        case 'C': 
          DB::table('vacaciones')->insert([
            'employee_id' => $empleado->id,
            'desde'       => $item->desde,
            'hasta'       => $item->hasta,
            'periodo'     => $item->periodo,
          ]);
          break;
        case 'D' && $item->id > 0:
           DB::table('vacaciones')->where('id', $item->id)->delete();
          break;
      }
    }

    return true;
  }

  // retorna en empleado por su cedula
  static public function GetByCedula(string $cedula)
  {
    return Employee::with('person')->whereRelation('person', 'cedula', $cedula)->first();
  }

  // listado de empleados de planta
  static public function GetInPlanta()
  {
    return Employee::select('employees.id', 
                            'employees.unidad_id')
                      ->where('condicion_id', 1)
                      ->whereRelation('unidad', 'padre_id', 15)
                      ->get();
  }
}