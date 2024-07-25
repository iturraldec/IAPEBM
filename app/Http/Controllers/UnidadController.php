<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Unidad;
use App\Clases\ResquestResponse;

class UnidadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(request()->ajax()) {
            return datatables()->of(Unidad::unidades())->toJson();
        }
        else {
            return view('unidades.index');
        }
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
        $response = new ResquestResponse();
        $response->success = true;
        $response->message = 'Unidad Operativa creada!';
        $response->data    = $unidad;

        return response(json_encode($response), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}