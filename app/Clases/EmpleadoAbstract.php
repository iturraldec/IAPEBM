<?php

abstract class EmpleadoAbstract
{
  //
  // parametros:
  //  string $cedula
  //  $imagen
  // retorna
  //  ubicacion y nombre de la imagen guardada : string
  protected function storeImage(string $cedula, $imagen) : string
  {
    // echo asset("images/".basename($file));
    $file = $imagen->store(config('app_config.employees_path').$cedula);

    return $file;
  }
}