<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Maatwebsite\Excel\Facades\Excel;

Route::get('loadFromExcel', function() {
  echo 'cargos...<br>';
  Excel::import(new App\Imports\CargosImport, 'assets/documentos/cargos.csv');

  echo 'condiciones...<br>';
  Excel::import(new App\Imports\CondicionesImport, 'assets/documentos/condiciones.csv');

  echo 'tipos...<br>';
  Excel::import(new App\Imports\TiposImport, 'assets/documentos/tipos_empleados.csv');

  echo 'ubicaciones...<br>';
  Excel::import(new App\Imports\UbicacionesImport, 'assets/documentos/ubicaciones.csv');

  echo 'policias:jerarquias...<br>';
  Excel::import(new App\Imports\JerarquiasImport, 'assets/documentos/rangos.csv');

  echo 'administrativos...<br>';
  Excel::import(new App\Imports\AdminImport, 'assets/documentos/administrativos.csv');

  echo 'policias...<br>';
  Excel::import(new App\Imports\PoliceImport, 'assets/documentos/funcionarios.csv');
  
  echo 'municipios y parroquias...<br>';
  Excel::import(new App\Imports\LocationsImport, 'assets/documentos/locations.csv');

  echo 'carga de datos finalizada!';
});

//
Route::view('/', 'auth.login');
Route::post('login', [AuthController::class, 'login'])->name('login');