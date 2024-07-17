<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

use App\Enums\EmployeeBloodType;

Route::get('loadFromExcel', function() {
  DB::beginTransaction();

  try {
    echo 'cargos...<br>';
    Excel::import(new App\Imports\CargosImport, 'assets/documentos/cargos.csv');

    echo 'condiciones...<br>';
    Excel::import(new App\Imports\CondicionesImport, 'assets/documentos/condiciones.csv');

    echo 'tipos...<br>';
    Excel::import(new App\Imports\TiposImport, 'assets/documentos/tipos_empleados.csv');

    echo 'ccps...<br>';
    Excel::import(new App\Imports\UbicacionesGImport, 'assets/documentos/ccpg.csv');
    Excel::import(new App\Imports\UbicacionesEImport, 'assets/documentos/ccpe.csv');

    echo 'uniformados:jerarquias...<br>';
    Excel::import(new App\Imports\JerarquiasImport, 'assets/documentos/rangos.csv');

    echo 'administrativos...<br>';
    Excel::import(new App\Imports\AdminImport, 'assets/documentos/administrativos.csv');

    echo 'uniformados...<br>';
    Excel::import(new App\Imports\PoliceImport, 'assets/documentos/uniformados.csv');

    //
    DB::commit();
    echo 'carga de datos finalizada!';
  } 
  catch (\Exception $e) {
    DB::rollback();

    return $e->getMessage();
  }
});

//
Route::view('/', 'auth.login');
Route::post('login', [AuthController::class, 'login'])->name('login');