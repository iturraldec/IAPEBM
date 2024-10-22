<?php

namespace App\Clases;

use App\Models\EmpleadoEstudio;
use Illuminate\Support\Facades\DB;
use App\Models\Employee;
use App\Models\EmpleadoReposo;

//
abstract class EmpleadoAbstract
{
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

  //
  public function updEstudios(Employee $empleado, array $data) : bool
  {
    foreach($data as $estudio) {
      if($estudio->id == '0' && $estudio->status != 'D') {
        DB::table('empleado_estudios')->insert([
                      'employee_id'     => $empleado->id,
                      'estudio_type_id' => $estudio->estudio_tipo_id,
                      'fecha'           => $estudio->fecha,
                      'descripcion'     => $estudio->descripcion,
        ]);
      }
      else if($estudio->status == 'U') {
        DB::table('empleado_estudios')
          ->where('id', $estudio->id)
          ->update([
              'employee_id'     => $empleado->id,
              'estudio_type_id' => $estudio->estudio_tipo_id,
              'fecha'           => $estudio->fecha,
              'descripcion'     => $estudio->descripcion,
          ]
        );
      }
      else if($estudio->status == 'D' && $estudio->id != '0') {
        EmpleadoEstudio::find($estudio->id)->delete();
      }
    }

    return true;
  }

  //
  public function updPermisos(Employee $empleado, array $data) : bool
  {
    $empleado->permisos()->delete();
    $permisos = [];
    foreach($data['permisos_desde'] as $indice => $desde) {
      $permisos[] = [
        'employee_id' => $empleado->id,
        'desde'       => $desde,
        'hasta'       => $data['permisos_hasta'][$indice],
        'motivo'      => $data['permisos_motivo'][$indice],
      ];
    }
    return DB::table('permisos')->insert($permisos);
  }

  //
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

  //
  static public function GetByCedula(string $cedula)
  {
    return Employee::with('person')->whereRelation('person', 'cedula', $cedula)->first();
  }
}