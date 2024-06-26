<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Phone extends Model
{
    //
    protected $fillable = ['person_id', 'phone_type_id', 'number'];

    //
    public function type() : HasOne
    {
        return $this->hasOne(PhoneType::class, 'id', 'phone_type_id');
    }

    //
    public function person() : BelongsTo
    {
        return $this->belongsTo(Person::class);
    }
}