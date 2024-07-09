<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\RangoController;
use App\Http\Controllers\EmployeeStatusController;
use App\Http\Controllers\EmployeeAdmController;
use App\Http\Controllers\EmployeePoliceController;
use App\Http\Controllers\UbicacionController;

//
Route::get('home', [HomeController::class, 'index'])->name('home');

Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::match(['get', 'post'],'users/password/change', [UserController::class, 'passwordChange'])->name('users.password.change');

Route::resource('cargos', CargoController::class)
  ->only(['index', 'store', 'update', 'destroy'])
  ->names('cargos');

Route::resource('rangos', RangoController::class)
  ->only(['index', 'store', 'update', 'destroy'])
  ->names('rangos');

Route::resource('employee-status', EmployeeStatusController::class)
  ->only(['index', 'store', 'update', 'destroy'])
  ->names('employee-status');

// empleados administrativos
Route::resource('employees-adm', EmployeeAdmController::class)->names('employees-adm');
Route::post('employees-adm/{id}/{cedula}', [EmployeeAdmController::class, 'addImages'])->name('employees-adm.add-images');

// empleados policiales
Route::resource('employees-police', EmployeePoliceController::class)->names('employees-police');
Route::post('employees-police/{id}/{cedula}', [EmployeePoliceController::class, 'addImages'])->name('employees-police.add-images');

// ubicaciones (estados/municipios/parroquias)
Route::get('ubicacion/estados', [UbicacionController::class, 'getEstados'])->name('ubicacion.estados');
Route::get('ubicacion/municipios/{estado_id}', [UbicacionController::class, 'getMunicipios'])->name('ubicacion.municipios');
Route::get('ubicacion/parroquias/{municipio_id}', [UbicacionController::class, 'getParroquias'])->name('ubicacion.parroquias');
