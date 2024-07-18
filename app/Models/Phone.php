<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Enums\PhoneType;

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
    /* public function getPhoneTypeAttribute()
    {
        return PhoneType::from($this->phone_type_id)->label();
    } */
   protected function PhoneType() : Attribute
   {
    return new Attribute(
        get: fn () => PhoneType::from($this->phone_type_id)->label(),
    );
   }
}