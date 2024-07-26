<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Unidad;
use App\Clases\ResquestResponse;

class UnidadController extends Controller
{
    //
    private $_requestResponse;

    //
    public function __construct(ResquestResponse $resquestResponse)
    {
        $this->_requestResponse = $resquestResponse;
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

        $unidad = Unidad::Create($request->all());
        $this->_requestResponse->success = true;
        $this->_requestResponse->message = 'Unidad Operativa creada!';
        $this->_requestResponse->data    = $unidad;

        return response(json_encode($this->_requestResponse), Response::HTTP_CREATED);
    }

    //
    public function edit(int $unidade)
    {
        return response(Unidad::especificas($unidade));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'code'  => 'required|string|max:20|unique:unidades',
            'name'  => 'required|string|max:255'
        ]);

        $unidad = Unidad::Create($request->all());
        $this->_requestResponse->success = true;
        $this->_requestResponse->message = 'Unidad Operativa creada!';
        $this->_requestResponse->data    = $unidad;

        return response(json_encode($this->_requestResponse), Response::HTTP_CREATED);
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