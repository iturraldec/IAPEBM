<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CondicionController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\RangoController;
use App\Http\Controllers\UnidadController;
use App\Http\Controllers\EmployeeAdmController;
use App\Http\Controllers\EmployeeObreroController;
use App\Http\Controllers\EmployeePoliceController;
use App\Http\Controllers\UbicacionController;

//
Route::get('home', [HomeController::class, 'index'])->name('home');

Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::match(['get', 'post'],'users/password/change', [UserController::class, 'passwordChange'])->name('users.password.change');

// rutas de las unidades operativas
Route::resource('unidades', UnidadController::class)
  ->only(['index', 'store', 'update', 'destroy'])
  ->names('unidades');

// rutas de las condiciones de los trabajadores
Route::resource('condiciones', CondicionController::class)
  ->only(['index', 'store', 'update', 'destroy'])
  ->names('condiciones');

// rutas de los cargos de los trabajadores
Route::resource('cargos', CargoController::class)
  ->only(['index', 'store', 'update', 'destroy'])
  ->names('cargos');

// rutas de los reangos (jerarquias) de los uniformados
Route::resource('rangos', RangoController::class)
  ->only(['index', 'store', 'update', 'destroy'])
  ->names('rangos');

// rutas de las ubicaciones (estados/municipios/parroquias)
Route::get('ubicacion/municipios/{estado_id}', [UbicacionController::class, 'getMunicipios'])->name('ubicacion.municipios');
Route::get('ubicacion/parroquias/{municipio_id}', [UbicacionController::class, 'getParroquias'])->name('ubicacion.parroquias');

// empleados administrativos
Route::resource('employees-adm', EmployeeAdmController::class)->names('employees-adm');

// empleados obreros
Route::resource('employees-obrero', EmployeeObreroController::class)->names('employees-obrero');

// empleados policiales
Route::resource('employees-police', EmployeePoliceController::class)->names('employees-police');