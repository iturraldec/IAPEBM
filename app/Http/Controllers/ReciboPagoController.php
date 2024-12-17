<?php

namespace App\Http\Controllers;

use App\Helpers\DateHelper;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Clases\EmpleadoAbstract;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\RecibosPagosImport;

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
    Excel::import(new RecibosPagosImport, $request->file('archivo'));
  }

  //
  function execute(string $mes)
  {
    $empleado = EmpleadoAbstract::getEmpleadoLogueado();
    $hoy = DateHelper::fechaCadena(now());
    $data = array(
      array('concepto' => 'AAAAAAAAA', 'ingreso' => 12.5, 'egreso' => 0.00),
      array('concepto' => 'BBBBBBBBB', 'ingreso' => 12.5, 'egreso' => 0.00),
      array('concepto' => 'CCCCCCCCC', 'ingreso' => 12.5, 'egreso' => 0.00),
      array('concepto' => 'DDDDDDDDD', 'ingreso' => 12.5, 'egreso' => 0.00),
      array('concepto' => 'EEEEEEEEE', 'ingreso' => 0.00, 'egreso' => 12.5),
      array('concepto' => 'FFFFFFFFF', 'ingreso' => 0.00, 'egreso' => 12.5),
      array('concepto' => 'GGGGGGGGG', 'ingreso' => 0.00, 'egreso' => 12.5),
    );
    $pdf = Pdf::loadView('consultas.web.rp.rp-pdf', compact('empleado', 'mes', 'hoy', 'data'));
    
    return $pdf->stream('recibo-pago.pdf');
  }
}