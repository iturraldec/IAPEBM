<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vacacione extends Model
{
     //
     protected $fillable = ['employee_id', 'desde', 'hasta', 'periodo'];

     //
     public function empleado(): BelongsTo
     {
         return $this->belongsTo(Employee::class);
     }
}
