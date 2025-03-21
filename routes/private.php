<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CondicionController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\RangoController;
use App\Http\Controllers\UnidadController;
use App\Http\Controllers\UnidadEspecificaController;
use App\Http\Controllers\EmployeeAdmController;
use App\Http\Controllers\EmployeeObreroController;
use App\Http\Controllers\EmployeePoliceController;
use App\Http\Controllers\EmployeeQryController;
use App\Http\Controllers\UbicacionController;
use App\Http\Controllers\ReposoController;
use App\Http\Controllers\EstudioTypeController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\ConstanciaTrabajoMotivoController;
use App\Http\Controllers\ConstanciaTrabajoController;
use App\Http\Controllers\ReciboPagoController;

//
Route::get('home', [HomeController::class, 'index'])->name('home');

Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::match(['get', 'post'],'users/password/change', [UserController::class, 'passwordChange'])->name('users.password.change');

// rutas de las unidades operativas
Route::resource('unidades', UnidadController::class)
  ->only(['index', 'store', 'update', 'destroy'])
  ->names('unidades');

// rutas de las unidades operativas especificas
Route::resource('unidades-e', UnidadEspecificaController::class)
  ->only(['index', 'store', 'update', 'destroy'])
  ->names('unidades-e');
Route::get('unidades-e/getAll/{padre_id}', [UnidadEspecificaController::class, 'getAll'])->name('unidades-e.getAll');

// rutas de las condiciones de los trabajadores
Route::resource('condiciones', CondicionController::class)
  ->only(['index', 'store', 'update', 'destroy'])
  ->names('condiciones');

// rutas de los cargos de los trabajadores
Route::resource('cargos', CargoController::class)
  ->only(['index', 'store', 'update', 'destroy'])
  ->names('cargos');

// rutas de los rangos (jerarquias) de los uniformados
Route::resource('rangos', RangoController::class)
  ->only(['index', 'store', 'update', 'destroy'])
  ->names('rangos');

// rutas de los reposos
Route::resource('reposos', ReposoController::class)
  ->only(['index', 'store', 'update', 'destroy'])
  ->names('reposos');
Route::get('reposos/get-by-code/{search?}', [ReposoController::class, 'getByCode'])->name('reposos.get-by-code');

// rutas de las ubicaciones (estados/municipios/parroquias)
Route::get('ubicacion/municipios/{estado_id}', [UbicacionController::class, 'getMunicipios'])->name('ubicacion.municipios');
Route::get('ubicacion/parroquias/{municipio_id}', [UbicacionController::class, 'getParroquias'])->name('ubicacion.parroquias');

// rutas de los tipo de estudios
Route::resource('estudios', EstudioTypeController::class)
  ->only(['index', 'store', 'update', 'destroy'])
  ->names('estudio-types');

// rutas de las motivos de las constancias de trabajo
Route::resource('ct-motivos', ConstanciaTrabajoMotivoController::class)
  ->only(['index', 'store', 'update', 'destroy'])
  ->names('ct.motivos');

// empleados administrativos
Route::resource('employees-adm', EmployeeAdmController::class)->names('employees-adm');

// empleados obreros
Route::resource('employees-obrero', EmployeeObreroController::class)->names('employees-obrero');

// empleados policiales
Route::resource('employees-police', EmployeePoliceController::class)->names('employees-police');

//////////////////////////////////////////////////////////////////////
//                CONSULTAS WEB
//////////////////////////////////////////////////////////////////////

Route::prefix('consultas-web')->group(function() {
  // constancia de trabajo (vista)
  Route::get('ct', [ConstanciaTrabajoController::class, 'index'])->name('cw.ct');

  // generacion de constancia de trabajo (pdf)
  Route::get('ct/{motivo}', [ConstanciaTrabajoController::class, 'execute'])->name('cw.ct.pdf');
});

//////////////////////////////////////////////////////////////////////
//                FIN DE CONSULTAS WEB
//////////////////////////////////////////////////////////////////////

// reportes de empleados
Route::get('pdf/employee', [EmployeeQryController::class, 'index'])->name('pdf.employee');
Route::get('pdf/employee/listado', [EmployeeQryController::class, 'listado'])->name('pdf.employee.listado');
Route::get('pdf/employee/listado/por-unidad/{tipo}/{unidad}', [EmployeeQryController::class, 'lstPorUnidad'])->name('pdf.employee.lst-por-unidad');
Route::get('pdf/employee/constancia-laboral-check/{cedula}', [EmployeeQryController::class, 'constanciaLaboralCheck'])->name('pdf.employee.constancia-laboral-check');
Route::get('pdf/employee/constancia-laboral/{cedula}/{motivo}', [EmployeeQryController::class, 'constanciaLaboral'])->name('pdf.employee.constancia-laboral');

//////////////////////////////////////////////////////////////////////
//                HORARIO DE E/S
//////////////////////////////////////////////////////////////////////

Route::prefix('horario')->group(function() {
  Route::get('apertura', [HorarioController::class, 'index'])->name('horario.apertura');
  Route::get('aperturar', [HorarioController::class, 'aperturar'])->name('horario.aperturar');
  Route::get('registrar', [HorarioController::class, 'registrar'])->name('horario.registrar');
  Route::get('{cedula}/registrar', [HorarioController::class, 'registra'])->name('horario.registra');
  Route::get('listado', [HorarioController::class, 'listado'])->name('horario.listado');
  Route::get('{fecha}/listar', [HorarioController::class, 'listadoToPdf'])->name('horario.listado-pdf');
});

//////////////////////////////////////////////////////////////////////
//                FIN DE HORARIO DE E/S
//////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////
//                RECIBOS DE PAGO
//////////////////////////////////////////////////////////////////////

Route::prefix('recibo-pago')->group(function() {
  Route::get('cargar',[ReciboPagoController::class, 'index'])->name('rp.cargar');
  Route::post('subir',[ReciboPagoController::class, 'cargar'])->name('rp.subir');
  Route::get('descargar',[ReciboPagoController::class, 'descargar'])->name('rp.descargar');
  Route::get('pdf/{reciboPago}',[ReciboPagoController::class, 'pdf'])->name('rp.descargar-pdf');
});

//////////////////////////////////////////////////////////////////////
//                FIN DE RECIBOS DE PAGO
//////////////////////////////////////////////////////////////////////