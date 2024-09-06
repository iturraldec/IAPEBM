<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

//
class Cargo extends Model
{
    protected $fillable = ['name', 'activo'];
}