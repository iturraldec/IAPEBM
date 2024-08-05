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
    Excel::import(new App\Imports\CargosImport, '/home/iturraldec/Documentos/iapebm/cargos.csv');

    echo 'condiciones...<br>';
    Excel::import(new App\Imports\CondicionesImport, '/home/iturraldec/Documentos/iapebm/condiciones.csv');

    echo 'uniformados:rangos...<br>';
    Excel::import(new App\Imports\JerarquiasImport, '/home/iturraldec/Documentos/iapebm/rangos.csv');

    echo 'tipos...<br>';
    Excel::import(new App\Imports\TiposImport, '/home/iturraldec/Documentos/iapebm/tipos_empleados.csv');

    echo 'unidades...<br>';
    Excel::import(new App\Imports\UnidadesGImport, '/home/iturraldec/Documentos/iapebm/uo_g.csv');
    Excel::import(new App\Imports\UnidadesEImport, '/home/iturraldec/Documentos/iapebm/uo_e.csv');

    echo 'administrativos...<br>';
    Excel::import(new App\Imports\AdminImport, '/home/iturraldec/Documentos/iapebm/administrativos-copia.csv');

    echo 'obreros...<br>';
    Excel::import(new App\Imports\ObreroImport, '/home/iturraldec/Documentos/iapebm/administrativos-copia.csv');

    /*echo 'uniformados...<br>';
    Excel::import(new App\Imports\PoliceImport, 'assets/documentos/uniformados.csv');
 */
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