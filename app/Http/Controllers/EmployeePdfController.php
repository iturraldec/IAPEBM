<?php

namespace App\Http\Controllers;

use App\Helpers\DateHelper;
use App\Models\Unidad;
use App\Models\Person;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

//
class EmployeePdfController extends Controller
{
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
  function constanciaLaboral(string $cedula, string $motivo)
  {
    $person = Person::where('cedula', $cedula)->first();
    $hoy = DateHelper::fechaCadena(now());
    $pdf = Pdf::loadView('pdf.employee.pdfs.constancia-laboral', compact('person', 'motivo', 'hoy'));

    return $pdf->stream('constancia-laboral.pdf');
  }
}