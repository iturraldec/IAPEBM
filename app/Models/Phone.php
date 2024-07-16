<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Phone extends Model
{
    //
    protected $fillable = ['person_id', 'phone_type_id', 'number'];

    //
    public function person() : BelongsTo
    {
        return $this->belongsTo(Person::class);
    }
}