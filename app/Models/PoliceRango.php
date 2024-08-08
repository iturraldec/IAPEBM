<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

//
class PoliceRango extends Model
{
  //
  protected $table = 'police_rangos';

  //
  protected $fillable = ['police_id', 'rango_id', 'documento_fecha', 'documento_file'];

  //
  public function police() : BelongsTo {
    return $this->belongsTo(Police::class);
  }

  //
  public function rango() : BelongsTo 
  {
    return $this->belongsTo(Rango::class);
  }
}
