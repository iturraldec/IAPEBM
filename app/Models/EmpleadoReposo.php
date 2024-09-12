<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmpleadoReposo extends Model
{
  //
  protected $fillable = [
              'employee_id', 
              'reposo_id', 
              'desde', 
              'hasta', 
              'noti_fecha', 
              'noti_dr_ci', 
              'noti_dr_nombre',
              'noti_dr_mpps',
              'noti_dr_cms',
              'conva_fecha',
              'conva_dr_ci',
              'conva_dr_nombre',
              'conva_dr_mpps',
              'conva_dr_cms',
              'file'
            ];
    
  // reposo
  public function reposo() : BelongsTo
  {
    return $this->belongsTo(Reposo::class);
  }
}