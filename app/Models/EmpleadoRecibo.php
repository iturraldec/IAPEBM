<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

//
class EmpleadoRecibo extends Model
{
  //
  protected $table = 'empleado_recibos_pagos';

  //
  protected $fillable = ['employee_id', 'recibo_id', 'asignacion', 'deduccion'];
}