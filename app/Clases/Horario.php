<?php

namespace App\Clases;

use App\Models\Asistencia;

//
class Horario
{
  // verificar si se ha generado el horario en un dia determinado
  public function is_generated(string $date) : bool
  {
    $resp = Asistencia::whereDate('created_at', $date)->first();

    return ! is_null($resp);
  }

  // genera el horario para la fecha actual
  public function generate() : void
  {
    $empleados = EmpleadoAbstract::GetInPlanta();
    foreach($empleados as $item) {
      Asistencia::create(['employee_id' => $item->id, 'unidad_id'   => $item->unidad_id]);
    };
  }

  // genera la entrada/salida de un trabajador, retorna la fecha y hora
  public function generateIO(int $employee_id) : string
  {
    $hoy = date('Y-m-d H:i');
    if(! $this->is_generated($hoy)) {
      $this->generate();
    }

    $registro = Asistencia::orderBy('id', 'desc')
                            ->where('employee_id', $employee_id)
                            ->whereDate('entrada', $hoy)
                            ->first();

    // entrada
    if(is_null($registro) || ! is_null($registro->salida)) {
      $data['employee_id'] = $employee_id;
      $data['entrada'] = $hoy;
      Asistencia::Create($data);
    }
    else {
    // salida
      $registro->update(['salida' => $hoy]);
    }

    return $hoy;
  }
}