<?php

namespace App\Http\Controllers;

use App\Helpers\DateHelper;
use App\Models\Unidad;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Clases\EmpleadoAbstract;
use App\Clases\RequestResponse;
use Symfony\Component\HttpFoundation\Response;

//
class EmployeeQryController extends Controller
{

  //
  private $_requestResponse;

  //
  public function __construct(RequestResponse $requestResponse)
  {
    $this->_requestResponse = $requestResponse;
  }

  //
  public function index()
  {
    return view('pdf.employee.views.index');
  }

  //
  public function listado()
  {
    $unidades = Unidad::unidades();

    return view('pdf.employee.views.listado', compact('unidades'));
  }

  //
  public function lstPorUnidad(int $tipo, int $unidad)
  {
    if($tipo == 1) {  // por unidad operativa
      $sql = "SELECT d.name as unidad,
                    c.name as unidad_especifica,
                    a.cedula,
                    CONCAT(a.first_last_name, ' ', a.second_last_name) apellidos,
                    CONCAT(a.first_name, ' ', a.second_name) nombres,
                    a.imagef
              FROM people a 
                          INNER JOIN employees b ON a.id = b.person_id
                          INNER JOIN unidades c ON b.unidad_id = c.id
                          INNER JOIN unidades d ON c.padre_id = d.id
              WHERE c.padre_id = $unidad
              ORDER BY a.first_last_name,
                       a.second_last_name,
                       a.first_name,
                       a.second_name;";
    }
    else {            // por unidad operativa especifica
      $sql = "SELECT d.name as unidad,
                    c.name as unidad_especifica,
                    a.cedula,
                    CONCAT(a.first_last_name, ' ', a.second_last_name) apellidos,
                    CONCAT(a.first_name, ' ', a.second_name) nombres,
                    a.imagef
              FROM people a 
                          INNER JOIN employees b ON a.id = b.person_id
                          INNER JOIN unidades c ON b.unidad_id = c.id
                          INNER JOIN unidades d ON c.padre_id = d.id
              WHERE b.unidad_id = $unidad
              ORDER BY a.first_last_name,
                       a.second_last_name,
                       a.first_name,
                       a.second_name;";
    }

    $empleados = DB::select($sql);
    
    $pdf = Pdf::loadView('pdf.employee.pdfs.lst-por-unidad', compact('empleados'));
    return $pdf->stream('empleados-por-unidad.pdf');
  }

  //
  function constanciaLaboralCheck(string $cedula)
  {
    $empleado = EmpleadoAbstract::GetByCedula($cedula);
    if(!$empleado) {
      $this->_requestResponse->success = false;
      $this->_requestResponse->message = 'Número de cédula no registrado!';
    }
    else if(in_array($empleado->condicion_id, [1,16,18,30])) {
      $this->_requestResponse->success = true;
    }
    else {
      $this->_requestResponse->success = false;
      $this->_requestResponse->message = 'Empleado no cumple las condiciones!';
    }

    return response()->json($this->_requestResponse, Response::HTTP_OK);
  }

  //
  function constanciaLaboral(string $cedula, string $motivo)
  {
    $empleado = EmpleadoAbstract::GetByCedula($cedula);
    $hoy = DateHelper::fechaCadena(now());
    $pdf = Pdf::loadView('pdf.employee.pdfs.constancia-laboral', compact('empleado', 'motivo', 'hoy'));
    
    return $pdf->stream('constancia-laboral.pdf');
  }
}