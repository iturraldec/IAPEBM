<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Clases\RequestResponse;
use Illuminate\Validation\Rule;
use App\Models\Unidad;

//
class UnidadController extends Controller
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
        return request()->ajax() ? datatables()->of(Unidad::unidades())->toJson() : view('unidades.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code'  => 'required|string|max:20|unique:unidades',
            'name'  => 'required|string|max:255'
        ]);

        $unidad = Unidad::Create($request->only(['eje_id', 'code', 'name']));
        $this->_requestResponse->success = true;
        $this->_requestResponse->message = 'Unidad Operativa creada!';
        $this->_requestResponse->data    = $unidad;

        return response(json_encode($this->_requestResponse), Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unidad $unidade)
    {
        $request->validate([
            'code'  => [
                'required',
                'string',
                'max:20',
                Rule::unique('unidades')->ignore($unidade->id),
            ],
            'name'  => 'required|string|max:255'
        ]);

        if ($unidade->update($request->only(['eje_id', 'code', 'name']))) {
            $this->_requestResponse->success = true;
            $this->_requestResponse->message = 'Unidad Operativa actualizada!';
        }
        else {
            $this->_requestResponse->success = false;
            $this->_requestResponse->message = 'Error al actualizar la Unidad Operativa!';
        }

        return response(json_encode($this->_requestResponse), Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unidad $unidade)
    {
        $unidade->delete();
        $this->_requestResponse->success = true;
        $this->_requestResponse->message = 'Unidad Operativa eliminada!';

        return response()->json($this->_requestResponse, Response::HTTP_OK);
    }
}