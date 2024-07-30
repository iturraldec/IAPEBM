<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Unidad;
use App\Clases\RequestResponse;
use Illuminate\Validation\Rule;

class UnidadEspecificaController extends Controller
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
        $unidades = Unidad::unidades();

        return view('unidades-e.index', compact('unidades'));
    }

    public function getAll(int $padre_id)
    {
        return datatables()->of(Unidad::especificas($padre_id))->toJson();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code'      => 'required|string|max:20|unique:unidades',
            'name'      => 'required|string|max:255',
            'latitude'  => 'required|decimal:6',
            'length'    => 'required|decimal:6'
        ]);

        $unidad = Unidad::Create($request->all());
        $this->_requestResponse->success = true;
        $this->_requestResponse->message = 'Unidad Operativa Específica creada!';
        $this->_requestResponse->data    = $unidad;

        return response()->json($this->_requestResponse, Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unidad $unidades_e)
    {
        $request->validate([
            'code'  => [
                'required',
                'string',
                'max:20',
                Rule::unique('unidades')->ignore($unidades_e->id),
            ],
            'name'  => 'required|string|max:255',
            'latitude'  => 'required|decimal:6',
            'length'    => 'required|decimal:6'
        ]);

        if ($unidades_e->update($request->all())) {
            $this->_requestResponse->success = true;
            $this->_requestResponse->message = 'Unidad Operativa Específica actualizada!';
        }
        else {
            $this->_requestResponse->success = false;
            $this->_requestResponse->message = 'Error al actualizar la Unidad Operativa Específica!';
        }

        return response()->json($this->_requestResponse, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unidad $unidades_e)
    {
        $unidades_e->delete();
        $this->_requestResponse->success = true;
        $this->_requestResponse->message = 'Unidad Operativa Específica eliminada!';

        return response()->json($this->_requestResponse, Response::HTTP_OK);
    }
}