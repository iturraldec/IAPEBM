<?php

namespace App\Http\Controllers;

use App\Models\EmployeeStatus;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\Rule;

class CondicionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      if(request()->ajax()) {
        return datatables()->of(EmployeeStatus::orderBy('name')->get())->toJson();
      }
      else {
        return view('employee-status.index');
      }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $validator = $request->validate([
        'name' => 'required|string|max:255|unique:employee_condiciones'
      ]);

      EmployeeStatus::Create($request->all());
      $mensaje['success'] = true;
      $mensaje['msg'] = 'Condición creada!';

      return response($mensaje, Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmployeeStatus $employeeStatus)
    {
      $request->validate([
        'name' => [
            'required',
            'string',
            'max:255',
            Rule::unique('employee_condiciones')->ignore($employeeStatus->id),
        ]
      ]);

      $employeeStatus->name = $request->name;
      $employeeStatus->save();
      $data['success'] = true;
      $data['message'] = 'Condición actualizada......';

      return response($data, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmployeeStatus $employeeStatus)
    {
      $employeeStatus->delete();
      $data['success'] = true;
      $data['message'] = 'Condición elminada.';
      return response($data, Response::HTTP_NO_CONTENT);
    }
}