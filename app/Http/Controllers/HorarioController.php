<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Clases\RequestResponse;
use Symfony\Component\HttpFoundation\Response;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Clases\EmpleadoAbstract;
use App\Clases\Horario;
use App\Models\Asistencia;

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
  public function index()
  {
    return view('horario.apertura');
  }

  //
  public function aperturar(Request $request)
  {
    if(! $this->_horario->is_generated(date('Y-m-d'))) {
      $this->_horario->generate();
    }

    $this->_requestResponse->success = true;
    $this->_requestResponse->message = 'Horario aperturado!';

    return response()->json($this->_requestResponse);
  }

  //
  public function registrar()
  {
    return view('horario.registro');
  }

  //
  public function registra(string $cedula)
  {
    $hoy = date('Y-m-d');
    if(! $this->_horario->is_generated($hoy)) {
      $this->_requestResponse->message = "Error: No se ha aperurado el dia: $hoy";

      return response()->json($this->_requestResponse, Response::HTTP_BAD_REQUEST);
    }
    else {
      $empleado = EmpleadoAbstract::GetByCedula($cedula);
      if(! $empleado) {
        $this->_requestResponse->message = 'Error: El número de cédula no existe!';

        return response()->json($this->_requestResponse, Response::HTTP_NOT_FOUND);
      }
      else {
        $registro = Asistencia::orderBy('id', 'desc')
                                ->where('employee_id', $empleado->id)
                                ->whereDate('created_at', $hoy)
                                ->first();
        if(! $registro) {
          $this->_requestResponse->message = 'Error: El número de cédula no existexxx!';

          return response()->json($this->_requestResponse, Response::HTTP_NOT_FOUND);
        }
        else {
          $this->_requestResponse->success = true;
          $this->_requestResponse->message = $this->_horario->generateIO($registro, date('Y-m-d H:i:s'));
          $empleado->unidad;
          $this->_requestResponse->data = $empleado;
    
          return response()->json($this->_requestResponse);
        }
      }
    }
  }

  //
  public function listado()
  {
    return view('horario.listado');
  }

  //
  public function listadoToPdf(string $fecha)
  { 
    $listado = DB::table('asistencias')
                  ->join('employees', 'asistencias.employee_id', '=', 'employees.id')
                  ->join('unidades', 'employees.unidad_id', '=', 'unidades.id')
                  ->join('people', 'employees.person_id', '=', 'people.id')
                  ->orderBy('unidades.name')
                  ->whereDate('asistencias.created_at', $fecha)
                  ->select('asistencias.*', 
                            'people.cedula', 
                            'people.first_name', 
                            'people.second_name',
                            'people.first_last_name',
                            'people.second_last_name',
                            'unidades.name as unidad')
                  ->get();
    $pdf = Pdf::setPaper('a4', 'landscape')->loadView('horario.listado-pdf', compact('fecha', 'listado'));

    return $pdf->stream('horario.pdf');
  }
}