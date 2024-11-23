<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Clases\RequestResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Clases\EmpleadoAbstract;
use App\Models\Asistencia;
use App\Helpers\DateHelper;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Clases\Horario;
use Svg\Tag\Rect;

//
class HorarioController extends Controller
{

  //
  private $_horario;

  //
  private $_requestResponse;

  //
  public function __construct(Horario $horario, RequestResponse $requestResponse)
  {
    date_default_timezone_set('America/Caracas');
    $this->_horario = $horario;
    $this->_requestResponse = $requestResponse;
  }

  //
  public function aperturar(Request $request)
  {
    if($request->ajax()) {
      if(! $this->_horario->is_generated(date('Y-m-d'))) {
        $this->_horario->generate();
      }

      $this->_requestResponse->success = true;
      $this->_requestResponse->message = 'Horario aperturado!';

      return response()->json($this->_requestResponse);
    }
    else {
      return view('horario.apertura');
    }
  }

  //
  public function registrar(Request $request)
  {
    $empleado = EmpleadoAbstract::GetByCedula($request->cedula);
    if(! $empleado) {
      $this->_requestResponse->success = false;
      $this->_requestResponse->message = 'Error: El número de cédula no existe!';

      return response()->json($this->_requestResponse, Response::HTTP_NOT_FOUND);
    }
    else {
      $empleado->unidad;
      $this->_requestResponse->success = true;
      $this->_requestResponse->message = $this->_horario->generateIO($empleado->id);
      $this->_requestResponse->data = $empleado;

      return response()->json($this->_requestResponse);
      }
  }

  //
  public function listado()
  {
    return view('horario.listado');
  }

  //
  public function listadoToPdf(string $desde, string $hasta)
  {
    $hoy = DateHelper::fechaCadena(now());
    
    $listado = DB::table('asistencias')
                  ->join('employees', 'asistencias.employee_id', '=', 'employees.id')
                  ->join('unidades', 'employees.unidad_id', '=', 'unidades.id')
                  ->join('people', 'employees.person_id', '=', 'people.id')
                  ->orderBy('asistencias.entrada')
                  ->select('asistencias.*', 
                            'people.first_name', 
                            'people.second_name',
                            'people.first_last_name',
                            'people.second_last_name',
                            'unidades.name as unidad')
                  ->get();
    $pdf = Pdf::loadView('horario.listado-pdf', compact('listado'));
    
    return $pdf->stream('horario.pdf');
  }
}
