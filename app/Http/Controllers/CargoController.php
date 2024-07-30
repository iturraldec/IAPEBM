<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\Rule;
use App\Clases\RequestResponse;

//
class CargoController extends Controller
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
    return request()->ajax() ? datatables()->of(Cargo::orderBy('name')->get())->toJson() : view('cargos.index');
  }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $validator = $request->validate([
        'name' => 'required|string|max:200|unique:cargos'
      ]);

      $cargo = Cargo::Create([
        'name'    => $request->input('name'),
        'activo'  => $request->has('activo')
      ]);
      $this->_requestResponse->success = true;
      $this->_requestResponse->message = 'Cargo creado!';
      $this->_requestResponse->data    = $cargo;

      return response()->json($this->_requestResponse, Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cargo $cargo)
    {
      $request->validate([
        'name' => [
            'required',
            'string',
            'max:200',
            Rule::unique('cargos')->ignore($cargo->id),
        ]
      ]);
      $cargo->update(['name' => $request->name, 'activo' => $request->has('activo')]);
      $this->_requestResponse->success = true;
      $this->_requestResponse->message = 'Cargo actualizado!';

      return response()->json($this->_requestResponse, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cargo $cargo)
    {
      $cargo->delete();
      $this->_requestResponse->success = true;
      $this->_requestResponse->message = 'Cargo eliminado!';

      return response()->json($this->_requestResponse, Response::HTTP_OK);
    }
}