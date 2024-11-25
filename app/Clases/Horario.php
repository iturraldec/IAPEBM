<?php

namespace App\Clases;

use App\Models\Asistencia;
use App\Models\Permiso;
use App\Models\EmpleadoReposo;
use App\Models\Vacacione;


//
class Horario
{
  // verificar si se ha generado el horario en un dia determinado
  public function is_generated(string $date) : bool
  {
    $resp = Asistencia::whereDate('created_at', $date)->first();

    return ! is_null($resp);
  }

  // genera el horario para la fecha actual (hoy)
  public function generate() : void
  {
    $empleados = EmpleadoAbstract::GetInPlanta();
    $hoy = date('Y-m-d');
    foreach($empleados as $item) {
      $data = ['employee_id' => $item->id, 
               'unidad_id'   => $item->unidad_id
              ];
        
      // verifico si tiene permisos para el dia de hoy

      $permiso = Permiso::where('employee_id', $item->id)
                          ->whereDate('hasta', '>=', $hoy)
                          ->first();
      if($permiso) {
        $data['observacion'] = 'DE PERMISO DEL '.$permiso->desde.' AL '.$permiso->hasta;
      }
      else {
        // verifico si tiene reposos para el dia de hoy

        $reposo = EmpleadoReposo::where('employee_id', $item->id)
                                  ->whereDate('hasta', '>=', $hoy)
                                  ->first();
        if($reposo) {
          $data['observacion'] = 'DE REPOSO DEL '.$reposo->desde.' AL '.$reposo->hasta;
        }
        else {
          // verifico si tiene vacaciones para el dia de hoy

          $vacacion = Vacacione::where('employee_id', $item->id)
                                ->whereDate('hasta', '>=', $hoy)
                                ->first();

          if($vacacion) {
            $data['observacion'] = 'DE VACACIONES DEL '.$vacacion->desde.' AL '.$vacacion->hasta;
          }
        }
      }

      Asistencia::create($data);
    };
  }

  // actualiza la entrada/salida de un trabajador
  public function generateIO($registro, $hoy) : string
  {
    // entrada
    if(is_null($registro->entrada)) {
      $registro->update(['entrada' => $hoy]);

      return "Entrada: $hoy";
    }
    else {
      // salida
      $registro->update(['salida' => $hoy]);

      return "Salida: $hoy";
    }
  }
}