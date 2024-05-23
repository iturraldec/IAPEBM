<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeTipos extends Model
{
  use SoftDeletes;

  //
  protected $table = 'employee_tipos';

  //
  protected $fillable = ['name'];
}