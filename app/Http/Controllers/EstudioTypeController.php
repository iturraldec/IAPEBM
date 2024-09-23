<?php

namespace App\Http\Controllers;

use App\Models\EstudioType;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\Rule;
use App\Clases\RequestResponse;

//
class EstudioTypeController extends Controller
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
    return request()->ajax() ? datatables()->of(EstudioType::orderBy('tipo')->get())->toJson() : view('estudios.index');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $request->validate([
      'tipo' => 'required|string|max:100|unique:estudio_types'
    ]);

    $cargo = EstudioType::Create(['tipo' => $request->input('tipo')]);
    $this->_requestResponse->success = true;
    $this->_requestResponse->message = 'Tipo de Estudio creado!';
    $this->_requestResponse->data    = $cargo;

    return response()->json($this->_requestResponse, Response::HTTP_CREATED);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, EstudioType $estudio)
  {
    $request->validate([
      'tipo' => [
          'required',
          'string',
          'max:100',
          Rule::unique('estudio_types')->ignore($estudio->id),
      ]
    ]);
    $estudio->update(['tipo' => $request->tipo]);
    $this->_requestResponse->success = true;
    $this->_requestResponse->message = 'Tipo de estudio actualizado!';

    return response()->json($this->_requestResponse, Response::HTTP_OK);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(EstudioType $estudio)
  {
    $estudio->delete();
    $this->_requestResponse->success = true;
    $this->_requestResponse->message = 'Tipo de estudio eliminado!';

    return response()->json($this->_requestResponse, Response::HTTP_OK);
  }
}