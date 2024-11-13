<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Clases\RequestResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Clases\EmpleadoAbstract;
use App\Models\Asistencia;
use App\Helpers\DateHelper;
use Barryvdh\DomPDF\Facade\Pdf;

//
class HorarioController extends Controller
{

  //
  private $_requestResponse;

  //
  public function __construct(RequestResponse $requestResponse)
  {
    date_default_timezone_set('America/Caracas');
    $this->_requestResponse = $requestResponse;
  }
  //
  public function index()
  {
    return view('horario.registro');
  }

  //
  public function buscar(string $cedula)
  {
    $empleado = EmpleadoAbstract::GetByCedula($cedula);
    if(!$empleado) {
      $this->_requestResponse->message = 'Error: El número de cédula no existe!';
    }
    else {
      $empleado->unidad = $empleado->unidadEspecifica;
      $this->_requestResponse->success = true;
      $this->_requestResponse->message = 'ok';
      $this->_requestResponse->data = $empleado;
    }

    return response()->json($this->_requestResponse, Response::HTTP_OK);
  }

  //
  public function registrar(Request $request)
  {
    $empleado = EmpleadoAbstract::GetByCedula($request->cedula);
    if(!$empleado) {
      $this->_requestResponse->message = 'Error: El número de cédula no existe!';
    }
    else {
      $date = new \DateTimeImmutable();
      $fecha = $date->format('Y-m-d');
      $registro = Asistencia::orderBy('id', 'desc')
                              ->where('employee_id', $empleado->id)
                              ->whereDate('fecha', $fecha)
                              ->first();
      $data['employee_id'] = $empleado->id;
      $data['fecha'] = $date->format('Y-m-d H:i');
      $data['entrada'] = true;
      $mensaje = 'Se registro la entrada: ';
      if(! is_null($registro) && $registro->entrada) {
        $data['entrada'] = false;
        $mensaje = 'Se registro la salida: ';
      }
      Asistencia::Create($data);
      $this->_requestResponse->success = true;
      $this->_requestResponse->message = $mensaje . $data['fecha'];
    }

    return response()->json($this->_requestResponse, Response::HTTP_OK);
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
    $pdf = Pdf::loadView('horario.listado-pdf', compact('hoy'));
    
    return $pdf->stream('horario.pdf');
  }
}
