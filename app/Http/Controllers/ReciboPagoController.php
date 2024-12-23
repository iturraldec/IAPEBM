<?php

namespace App\Http\Controllers;

use App\Helpers\DateHelper;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Clases\EmpleadoAbstract;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\RecibosPagosChkImport;
use App\Imports\RecibosPagosImport;
use App\Models\ReciboPago;
use App\Models\EmpleadoRecibo;

//
class ReciboPagoController extends Controller
{
  //
  public function index()
  {
    return view('recibos.cargar');
  }

  //
  public function cargar(Request $request)
  {
    $importacion = new RecibosPagosChkImport;

    Excel::import($importacion, $request->file('archivo'));

    $resultado = $importacion->getResultado();

    if(empty($resultado)) {
      $importacion = new RecibosPagosImport($request->mes, $request->desde, $request->hasta);
      Excel::import($importacion, $request->file('archivo'));
    }

    return view('recibos.resultado', compact('resultado'));
  }

  //
  public function descargar()
  {
    $meses = ReciboPago::orderBy('mes', 'desc')->get();

    return view('consultas.web.rp.index', compact('meses'));
  }

  //
  public function pdf(ReciboPago $reciboPago)
  {
    $empleado = EmpleadoAbstract::getEmpleadoLogueado();
    $hoy = DateHelper::fechaCadena(now());
    $data = EmpleadoRecibo::where('employee_id', $empleado->id)
                            ->where('recibo_id', $reciboPago->id)
                           ->get();

    $totales = array('asignacion' => 0.00, 'deduccion' => 0.00);

    foreach ($data as $d) {
      $totales['asignacion'] += $d->asignacion;
      $totales['deduccion'] += $d->deduccion;
    }

    $pdf = Pdf::loadView('consultas.web.rp.rp-pdf', compact('empleado', 'reciboPago', 'hoy', 'data', 'totales'));

    return $pdf->stream('recibo-pago.pdf');
  }
}