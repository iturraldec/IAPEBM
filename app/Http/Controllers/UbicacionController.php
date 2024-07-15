<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class UbicacionController extends Controller
{
  //
  public function getEstados()
  {
    return DB::table('estados')->orderBy('estado')->get();
  }

  //
  public function getMunicipios($estado_id)
  {
    $municipios = DB::table('municipios')->where('id_estado', $estado_id)->orderBy('municipio')->get();

    return response(['municipios' => $municipios], 200);
  }

  //
  public function getParroquias($municipio_id)
  {
    $parroquias = DB::table('parroquias')->where('id_municipio', $municipio_id)->orderBy('parroquia')->get();

    return response(['parroquias' => $parroquias], 200);
  }
}