<?php

namespace App\Http\Controllers;

use App\Helpers\DateHelper;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Clases\EmpleadoAbstract;
use Illuminate\Support\Facades\Auth;
use App\Clases\EmpleadoAdm;
use App\Models\ConstanciaTrabajoMotivo;

//
class ConstanciaTrabajoController extends Controller
{
  //
  private $_empleado;

  //
  public function __construct(EmpleadoAdm $empleado)
  {
    $this->_empleado = $empleado;
  }

  //
  public function index()
  {
    $motivos = ConstanciaTrabajoMotivo::orderBy('motivo')->get();
    
      return view('consultas.web.ct.index', compact('motivos'));
  }

  //
  function execute(ConstanciaTrabajoMotivo $motivo)
  {
    $empleado = EmpleadoAbstract::getEmpleadoLogueado();
    $hoy = DateHelper::fechaCadena(now());
    $pdf = Pdf::loadView('consultas.web.ct.ct-pdf', compact('empleado', 'motivo', 'hoy'));
    
    return $pdf->stream('constancia-trabajo.pdf');
  }
}