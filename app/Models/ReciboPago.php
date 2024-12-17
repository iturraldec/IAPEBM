<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

//
class ReciboPago extends Model
{
  //
  protected $table = 'recibos_pagos';

  //
  protected $fillable = ['mes', 'desde', 'hasta'];
}