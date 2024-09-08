<?php

namespace App\Clases;

use Illuminate\Support\Facades\DB;
use App\Models\Employee;

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
    // echo asset("images/".basename($file));
    $file = $imagen->store(config('app_config.employees_path').$cedula);

    return $file;
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
}