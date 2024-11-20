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
    $empleado = EmpleadoAbstract::GetInPlanta($cedula);
    if(!$empleado) {
      $this->_requestResponse->message = 'Error: El número de cédula no existe!';

      return response()->json($this->_requestResponse, Response::HTTP_NOT_FOUND);
    }
    else {
      $this->_requestResponse->success = true;
      $this->_requestResponse->message = 'ok';
      $this->_requestResponse->data = $empleado;

      return response()->json($this->_requestResponse, Response::HTTP_OK);
    }
  }

  //
  public function registrar(Request $request)
  {
    $empleado = EmpleadoAbstract::GetByCedula($request->cedula);
    if(!$empleado) {
      $this->_requestResponse->message = 'Error: El número de cédula no existe!';
    }
    else {
      $this->_requestResponse->success = true;
      $hoy = date('Y-m-d H:i');
      $registro = Asistencia::orderBy('id', 'desc')
                              ->where('employee_id', $empleado->id)
                              ->whereDate('entrada', $hoy)
                              ->first();

      // entrada
      if(is_null($registro) || ! is_null($registro->salida)) {
        $data['employee_id'] = $empleado->id;
        $data['entrada'] = $hoy;
        Asistencia::Create($data);
        $this->_requestResponse->message = 'Se registro la entrada: ' . $data['entrada'];
      }
      else {
      // salida
        $registro->update(['salida' => $hoy]);
        $this->_requestResponse->message = 'Se registro la salida: ' . $hoy;
      }
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
