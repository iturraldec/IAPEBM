<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reposo extends Model
{
    //
    protected $fillable = ['employee_id', 'desde', 'hasta', 'motivo', 'file'];

    //
    public function user(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}