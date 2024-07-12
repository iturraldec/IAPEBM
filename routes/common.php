<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

Route::get('loadFromExcel', function() {
  DB::beginTransaction();

  try {
    echo 'cargos...<br>';
    //Excel::import(new App\Imports\CargosImport, 'assets/documentos/cargos.csv');

    echo 'condiciones...<br>';
    //Excel::import(new App\Imports\CondicionesImport, 'assets/documentos/condiciones.csv');

    echo 'tipos...<br>';
    //Excel::import(new App\Imports\TiposImport, 'assets/documentos/tipos_empleados.csv');

    echo 'policias:jerarquias...<br>';
    //Excel::import(new App\Imports\JerarquiasImport, 'assets/documentos/rangos.csv');

    echo 'ubicaciones...<br>';
    Excel::import(new App\Imports\UbicacionesGImport, 'assets/documentos/ccpg.csv');
    Excel::import(new App\Imports\UbicacionesEImport, 'assets/documentos/ccpe.csv');

    //
    DB::commit();
  } 
  catch (\Exception $e) {
    DB::rollback();

    return $e->getMessage();
  }
/*

  echo 'administrativos...<br>';
  Excel::import(new App\Imports\AdminImport, 'assets/documentos/administrativos.csv');

  echo 'policias...<br>';
  Excel::import(new App\Imports\PoliceImport, 'assets/documentos/uniformados.csv');

*/
  echo 'carga de datos finalizada!';
});

//
Route::view('/', 'auth.login');
Route::post('login', [AuthController::class, 'login'])->name('login');