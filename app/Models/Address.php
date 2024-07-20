<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Address extends Model
{
  //
  protected $table = 'addresses';

  //
  protected $fillable = ['person_id', 'parroquia_id', 'address', 'zona_postal'];

  //
  public function person() : BelongsTo
  {
    return $this->belongsTo(Person::class);
  }

  //
  protected function fullAddress() : Attribute
  {
      return new Attribute(
          get: fn () => DB::table('addresses')
                              ->join('parroquias', 'addresses.parroquia_id', '=', 'parroquias.id_parroquia')
                              ->join('municipios', 'parroquias.id_municipio', '=', 'municipios.id_municipio')
                              ->join('estados', 'municipios.id_estado', '=', 'estados.id_estado')
                              ->select('addresses.*', 'parroquias.parroquia', 'municipios.municipio', 'estados.estado')
                              ->where('addresses.id', $this->id)
                              ->first(),
      );
  }
}