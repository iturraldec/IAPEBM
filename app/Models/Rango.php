<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rango extends Model
{
    use SoftDeletes;

    //
    protected $table = 'rangos';

    //
    protected $fillable = ['name'];
}