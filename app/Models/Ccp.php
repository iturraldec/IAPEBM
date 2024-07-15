<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ccp extends Model
{
    protected $table = 'ccps_e';

    protected $fillable = ['ccp_id', 'code', 'name', 'latitude', 'length'];
}
