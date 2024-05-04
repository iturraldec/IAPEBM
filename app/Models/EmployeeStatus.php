<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeStatus extends Model
{
  use SoftDeletes;

  //
  protected $table = 'employee_condiciones';

  //
  protected $fillable = ['name'];
}