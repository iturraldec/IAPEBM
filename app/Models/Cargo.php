<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cargo extends Model
{
    use SoftDeletes;

    //
    protected $table = 'employee_cargos';

    //
    protected $fillable = ['name'];
}
