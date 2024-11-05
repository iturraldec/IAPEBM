<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Enums\PhoneTypeEnum;

//
class Phone extends Model
{
    //
    protected $fillable = ['person_id', 'phone_type_id', 'number'];

    //
    protected $appends = ['phone_type'];

    //
    public function person() : BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    //
    protected function phoneType() : Attribute
    {
        return new Attribute(
            get: fn () => PhoneTypeEnum::from($this->phone_type_id)->label(),
        );
    }
}