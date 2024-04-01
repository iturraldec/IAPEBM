<?php

namespace App\Http\Controllers;

use App\Models\Rango;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response ;
use Illuminate\Validation\Rule;

//
class RangoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      if(request()->ajax()) {
        return datatables()->of(Rango::orderBy('name')->get())->toJson();
      }
      else {
        return view('rangos.index');
      }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $validator = $request->validate([
        'name' => 'required|string|max:200|unique:rangos'
      ]);

      Rango::Create($request->all());
      $mensaje['success'] = true;
      $mensaje['msg'] = 'Rango creado!';

      return response($mensaje, Response::HTTP_CREATED);
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
            Rule::unique('rangos')->ignore($rango->id),
        ]
      ]);

      $rango->name = $request->name;
      $rango->save();
      $data['success'] = true;
      $data['message'] = 'Rango actualizado......';

      return response($data, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rango $rango)
    {
      $rango->delete();
      $data['success'] = true;
      $data['message'] = 'Rango elminado.';
      return response($data, Response::HTTP_NO_CONTENT);
    }
}
