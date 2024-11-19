<?php

namespace App\Http\Controllers;

use App\Models\ConstanciaTrabajoMotivo;
use Illuminate\Http\Request;
use App\Clases\RequestResponse;
use Symfony\Component\HttpFoundation\Response;

//
class ConstanciaTrabajoMotivoController extends Controller
{
  //
  private $_requestResponse;

  //
  public function __construct(RequestResponse $requestResponse)
  {
    $this->_requestResponse = $requestResponse;
  }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      return request()->ajax() ? datatables()->of(ConstanciaTrabajoMotivo::orderBy('motivo'))->toJson()
                             : view('ct-motivos.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $motivo = ConstanciaTrabajoMotivo::create(['motivo' => $request->motivo]);
      
      //
      $this->_requestResponse->success = true;
      $this->_requestResponse->message = 'Motivo de la constancia de trabajo agregado!';
      $this->_requestResponse->data    = $motivo;

      return response()->json($this->_requestResponse, Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ConstanciaTrabajoMotivo $ct_motivo)
    {
      $ct_motivo->update(['motivo' => $request->motivo]);
      
      //
      $this->_requestResponse->success = true;
      $this->_requestResponse->message = 'Motivo de la constancia de trabajo modificado!';

      return response()->json($this->_requestResponse, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ConstanciaTrabajoMotivo $ct_motivo)
    {
      $ct_motivo->delete();

      //
      $this->_requestResponse->success = true;
      $this->_requestResponse->message = 'Motivo de Constancia de Trabajo eliminado!';

      return response()->json($this->_requestResponse, Response::HTTP_OK);
    }
}