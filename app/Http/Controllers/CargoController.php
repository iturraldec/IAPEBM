<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\Rule;

//
class CargoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      if(request()->ajax()) {
        return datatables()->of(Cargo::orderBy('name')->get())->toJson();
      }
      else {
        return view('cargos.index');
      }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $validator = $request->validate([
        'name' => 'required|string|max:200|unique:employee_cargos'
      ]);

      Cargo::Create($request->all());
      $mensaje['success'] = true;
      $mensaje['msg'] = 'Cargo creado!';

      return response($mensaje, Response::HTTP_CREATED);
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
            Rule::unique('employee_cargos')->ignore($cargo->id),
        ]
      ]);

      $cargo->name = $request->name;
      $cargo->save();
      $data['success'] = true;
      $data['message'] = 'Cargo actualizado......';

      return response($data, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cargo $cargo)
    {
      $cargo->delete();
      $data['success'] = true;
      $data['message'] = 'Cargo elminado.';
      
      return response($data, Response::HTTP_NO_CONTENT);
    }
}
