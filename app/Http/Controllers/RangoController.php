<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response ;
use Illuminate\Validation\Rule;
use App\Clases\RequestResponse;
use App\Models\Rango;

//
class RangoController extends Controller
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
    return request()->ajax() ? datatables()->of(Rango::orderBy('name')->get())->toJson() : view('rangos.index');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required|string|max:200|unique:jerarquias'
    ]);

    $rango = Rango::Create($request->all());
    $this->_requestResponse->success = true;
    $this->_requestResponse->message = 'Rango creado!';
    $this->_requestResponse->data    = $rango;

    return response(json_encode($this->_requestResponse), Response::HTTP_CREATED);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Rango $rango)
  {
    $request->validate([
      'name' => [
          'required',
          'string',
          'max:200',
          Rule::unique('jerarquias')->ignore($rango->id),
      ]
    ]);

    $rango->update($request->all());
    $this->_requestResponse->success = true;
    $this->_requestResponse->message = 'Rango actualizado!';

    return response()->json($this->_requestResponse, Response::HTTP_OK);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Rango $rango)
  {
    $rango->delete();
    $this->_requestResponse->success = true;
    $this->_requestResponse->message = 'Rango eliminado!';

    return response()->json($this->_requestResponse, Response::HTTP_OK);
  }
}