<?php

namespace App\Clases;

//
class EmpleadoPolicial extends EmpleadoAbstract
{
  //
  private $_type_id;

  //
  public function __construct()
  {
    $this->_type_id = 3;
  }
}