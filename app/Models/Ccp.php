<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ccp extends Model
{
    use SoftDeletes;

    //
    protected $fillable = [
      'ccp_location_id',
      'code',
      'name',
      'latitude',
      'length'
    ];
}
