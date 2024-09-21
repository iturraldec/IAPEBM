<?php

namespace App\Clases;

use Illuminate\Support\Facades\DB;
use App\Models\Employee;
use App\Models\EmpleadoReposo;

//
abstract class EmpleadoAbstract
{
  //
  // parametros:
  //  string $cedula
  //  $imagen
  // retorna
  //  ubicacion y nombre de la imagen guardada : string
  public function storeImage(string $cedula, $imagen) : string
  {
    return $imagen->store(config('app_config.employees_path').$cedula);
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
                      'reposo_id'       => $reposo->reposo_id,
                      'desde'           => $reposo->desde,
                      'hasta'           => $reposo->hasta,
                      'noti_fecha'      => $reposo->noti_fecha,
                      'noti_dr_ci'      => $reposo->noti_dr_ci,
                      'noti_dr_nombre'  => $reposo->noti_dr_nombre,
                      'noti_dr_mpps'    => $reposo->noti_dr_mpps,
                      'noti_dr_cms'     => $reposo->noti_dr_cms,
                      'conva_fecha'     => $reposo->conva_fecha,
                      'conva_dr_ci'     => $reposo->conva_dr_ci,
                      'conva_dr_nombre' => $reposo->conva_dr_nombre,
                      'conva_dr_mpps'   => $reposo->conva_dr_mpps,
                      'conva_dr_cms'    => $reposo->conva_dr_cms,
        ]);
      }
      else if($reposo->status == 'U') {
        DB::table('empleado_reposos')
          ->where('id', $reposo->id)
          ->update([
              'reposo_id'       => $reposo->reposo_id,
              'desde'           => $reposo->desde,
              'hasta'           => $reposo->hasta,
              'noti_fecha'      => $reposo->noti_fecha,
              'noti_dr_ci'      => $reposo->noti_dr_ci,
              'noti_dr_nombre'  => $reposo->noti_dr_nombre,
              'noti_dr_mpps'    => $reposo->noti_dr_mpps,
              'noti_dr_cms'     => $reposo->noti_dr_cms,
              'conva_fecha'     => $reposo->conva_fecha,
              'conva_dr_ci'     => $reposo->conva_dr_ci,
              'conva_dr_nombre' => $reposo->conva_dr_nombre,
              'conva_dr_mpps'   => $reposo->conva_dr_mpps,
              'conva_dr_cms'    => $reposo->conva_dr_cms,
          ]
        );
      }
      else if($reposo->status == 'D' && $reposo->id != '0') {
        EmpleadoReposo::find($reposo->id)->delete();
      }
    }

    return true;
  }
}