<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

//
class Asistencia extends Model
{
    protected $fillable = ['employee_id', 'entrada', 'salida'];

    //
    public function employee() : BelongsToMany
    {
        return $this->belongsToMany(Employee::class);
    }
}
