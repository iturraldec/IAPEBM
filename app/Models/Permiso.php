<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    protected $fillable = ['employee_id', 'desde', 'hasta', 'motivo'];
}
