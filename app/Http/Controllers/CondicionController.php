<?php

namespace App\Http\Controllers;

use App\Models\Condicion;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\Rule;
use App\Clases\RequestResponse;

class CondicionController extends Controller
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
    return request()->ajax() ? datatables()->of(Condicion::orderBy('name')->get())->toJson() : view('condiciones.index');
  }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $validator = $request->validate([
        'name' => 'required|string|max:255|unique:condiciones'
      ]);

      $condicion = Condicion::Create($request->all());
      $this->_requestResponse->success = true;
      $this->_requestResponse->message = 'Condición creada!';
      $this->_requestResponse->data    = $condicion;

      return response()->json($this->_requestResponse, Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Condicion $condicione)
    {
      $request->validate([
        'name' => [
            'required',
            'string',
            'max:200',
            Rule::unique('condiciones')->ignore($condicione->id),
        ]
      ]);

      if ($condicione->update($request->all())) {
        $this->_requestResponse->success = true;
        $this->_requestResponse->message = 'Condición actualizada!';
      }
      else {
        $this->_requestResponse->success = false;
        $this->_requestResponse->message = 'Error al actualizar condición!';
      }
      
      return response()->json($this->_requestResponse, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Condicion $condicione)
    {
      $condicione->delete();
      $this->_requestResponse->success = true;
      $this->_requestResponse->message = 'Condición eliminada!';

      return response()->json($this->_requestResponse, Response::HTTP_OK);
    }
}