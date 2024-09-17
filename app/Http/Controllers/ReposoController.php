<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\DataTables;
use App\Models\Reposo;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\Rule;
use App\Clases\RequestResponse;

//
class ReposoController extends Controller
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
    return request()->ajax() ? DataTables::make(Reposo::query())->toJson() : view('reposos.index');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $request->validate([
      'codigo' => 'required|string|max:20|unique:reposos',
      'diagnostico' => 'required|string|max:255',
    ]);

    $reposo = Reposo::Create($request->all());
    $this->_requestResponse->success = true;
    $this->_requestResponse->message = 'Reposo creado!';
    $this->_requestResponse->data    = $reposo;

    return response()->json($this->_requestResponse, Response::HTTP_CREATED);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Reposo $reposo)
  {
    $request->validate([
      'codigo' => [
          'required',
          'string',
          'max:20',
          Rule::unique('reposos')->ignore($reposo->id),
      ],
      'diagnostico' => 'required|string|max:255',
    ]);
    $reposo->update($request->all());
    $this->_requestResponse->success = true;
    $this->_requestResponse->message = 'Reposo actualizado!';

    return response()->json($this->_requestResponse, Response::HTTP_OK);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Reposo $reposo)
  {
    $reposo->delete();
    $this->_requestResponse->success = true;
    $this->_requestResponse->message = 'Reposo eliminado!';

    return response()->json($this->_requestResponse, Response::HTTP_OK);
  }

  //
  public function getByCode(string $search = '')
  {
    $reposo = Reposo::where('codigo', $search)->first();
    if($reposo) {
      $this->_requestResponse->success  = true;
      $this->_requestResponse->data     = $reposo;
    }
    else {
      $this->_requestResponse->success = false;
    }

    return response()->json($this->_requestResponse, Response::HTTP_OK);
  }
}