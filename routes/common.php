<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Maatwebsite\Excel\Facades\Excel;

Route::get('fromExcel', function(){
  Excel::import(new App\Imports\DemoImport, 'assets/documentos/administrativos.csv');
  //Excel::import(new App\Imports\DemoImport, public_path('assets/documentos/administrativos_prueba.csv'));
});

Route::get('/psp', function (){
  $partidas[] = array(
    'codigo' => '4.00.00.00.00',
    'nombre' => 'EGRESOS',
    'totaliza' => true,
    'monto' => 0);
  
  $partidas[] = array(
    'codigo' => '4.01.00.00.00',
    'nombre' => 'GASTOS DE PERSONAL',
    'totaliza' => true,
    'monto' => 0);

  $partidas[] = array(
    'codigo' => '4.01.01.00.00',
    'nombre' => 'SUELDOS, SALARIOS Y OTRAS RETRIBUCIONES',
    'totaliza' => true,
    'monto' => 0);

  $partidas[] = array(
    'codigo' => '4.01.01.01.00',
    'nombre' => 'SUELDOS BASICOS PERSONAL FIJO A TIEMPO COMPLETO',
    'totaliza' => false,
    'monto' => 2);

  $partidas[] = array(
    'codigo' => '4.01.01.02.00',
    'nombre' => 'SUELDOS BASICOS PERSONAL FIJO A TIEMPO PARCIAL',
    'totaliza' => false,
    'monto' => 3);

    $partidas[] = array(
      'codigo' => '4.01.01.03.00',
      'nombre' => 'SUPLENCIAS A EMPLEADOS',
      'totaliza' => false,
      'monto' => 10);

    $partidas[] = array(
      'codigo' => '4.01.01.08.00',
      'nombre' => 'SUELDO AL PERSONAL EN TRAMITE DE NOMBRAMIENTO',
      'totaliza' => false,
      'monto' => 4);

    $partidas[] = array(
      'codigo' => '4.01.01.09.00',
      'nombre' => 'REMUNERACIONES AL PERSONAL EN PERIODO DE DISPONIBI',
      'totaliza' => false,
      'monto' => 1);
    
    $partidas[] = array(
      'codigo' => '4.01.01.10.00',
      'nombre' => 'SALARIOS A OBREROS PUESTOS PERMANT.A TIEMPO COMPLE',
      'totaliza' => false,
      'monto' => 30);

    $partidas[] = array(
      'codigo' => '4.01.02.00.00',
      'nombre' => 'COMPENS.PREVIST. EN LAS ESCALAS DE SUELDOS Y SAL.',
      'totaliza' => true,
      'monto' => 0);

    $partidas[] = array(
      'codigo' => '4.01.02.01.00',
      'nombre' => 'COMPENS.PREV.ESCALAS DE SUELDOS,PERS.FIJO,TIEMPO C',
      'totaliza' => false,
      'monto' => 2);

    $partidas[] = array(
      'codigo' => '4.01.02.02.00',
      'nombre' => 'COMPENS.PREV.ESCALAS DE SUELDOS,PERS.FIJO,T.PARCIA',
      'totaliza' => false,
      'monto' => 2);
          
    $partidas[] = array(
      'codigo' => '4.01.02.03.25',
      'nombre' => 'COMP.PREVISTAS ESCALAS SALAR.PERS.OBR.FIJO T.COMPL',
      'totaliza' => false,
      'monto' => 2);
    
    echo 'partidas<br>';
    var_dump($partidas);
    
    // partidas de totalizacion
    $partidas_orden_superior = array_filter($partidas, function($elemento) {
      return $elemento['totaliza'];
    });
    echo 'partidas de orden superior<br>';
    var_dump($partidas_orden_superior);

    // partidas de movimiento
    $partidas_de_movimiento = array_filter($partidas, function($elemento) {
      return !$elemento['totaliza'];
    });

    echo 'partidas de movimiento<br>';
    foreach($partidas_de_movimiento as $partida) {
      echo 'original: ' . $partida['codigo'].'<br>';
      foreach(generarCadenas($partida['codigo']) as $_partida) {
       $clave = array_search($_partida, array_column($partidas, 'codigo'));
        if($clave !== false && $partidas[$clave]['totaliza']) {
          echo 'sumo: '.$clave.'<br>';
          $partidas_orden_superior[$clave]['monto'] += $partida['codigo']['monto'];
        }
        else {
          echo 'no sumo<br>';
        }
      }
    }

    //
    echo 'partidas de orden superior con sumatoria<br>';
    var_dump($partidas_orden_superior);
});

//
Route::view('/', 'auth.login');
Route::post('login', [AuthController::class, 'login'])->name('login');


//
function generarCadenas($cadena) {
  $cadenas = array();
    
    // Separamos la cadena por puntos
    $elementos = explode('.', $cadena);
    
    // Generamos las cadenas reemplazando los últimos dos dígitos por '00' en cada iteración
    for ($i = count($elementos) - 1; $i > 0; $i--) {
        $elementos[$i] = '00';
        $cadenas[] = implode('.', $elementos);
    }
    
    return $cadenas;
}