<?php

namespace App\Http\Controllers;

use App\Helpers\DateHelper;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Clases\EmpleadoAbstract;
use Illuminate\Support\Facades\Auth;

use App\Models\ConstanciaTrabajoMotivo;

//
class ConstanciaTrabajoController extends Controller
{

  //
  public function index()
  {
    $motivos = ConstanciaTrabajoMotivo::orderBy('motivo')->get();
    
      return view('consultas.web.ct.index', compact('motivos'));
  }

  //
  function execute(ConstanciaTrabajoMotivo $motivo)
  {
    $user = Auth::user();
    $empleado = EmpleadoAbstract::GetByCedula($user->code);
    $hoy = DateHelper::fechaCadena(now());
    $pdf = Pdf::loadView('consultas.web.ct.ct-pdf', compact('empleado', 'motivo', 'hoy'));
    
    return $pdf->stream('constancia-trabajo.pdf');
  }
}