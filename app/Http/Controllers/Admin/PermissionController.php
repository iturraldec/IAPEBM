<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Symfony\Component\HttpFoundation\Response ;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      return view('auth.permissions.index');
    }
    public function loadData()
    {
        return datatables()->of(Permission::orderBy('name')->get())->toJson();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = $request->validate([
            'name' => 'required|string|max:255|unique:permissions'
        ]);

        Permission::Create($request->all());
        $mensaje['success'] = true;
        $mensaje['msg'] = 'Permiso creado!';

        return response($mensaje, Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        $validator = $request->validate([
            'name' => 'required|string|max:255|unique:permissions'
        ]);

        $permission->name = $request->name;
		$permission->save();
		$data['success'] = true;
		$data['message'] = 'Permiso actualizado.';

		return response($data, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
		$data['success'] = true;
		$data['message'] = 'Permiso elminado.';
		return response($data, Response::HTTP_NO_CONTENT);
    }
}
