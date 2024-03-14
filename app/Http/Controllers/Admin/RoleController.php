<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Symfony\Component\HttpFoundation\Response ;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $permissions = Permission::all();
      return view('auth.roles.index', compact('permissions'));
    }

    //
    public function loadData()
    {
        return datatables()->of(Role::orderBy('name')->get())->toJson();
    }

    //
    public function loadPermissions(Role $role)
    {
        $data['state'] = true;
        $data['data'] = $role->permissions;
        return response($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $validator = $request->validate([
          'name' => 'required|string|max:255|unique:roles'
      ]);

      $role = Role::Create($request->only('name'));
      $role->syncPermissions($request->permissions);
      $mensaje['success'] = true;
      $mensaje['message'] = 'Rol creado!';

      return response($mensaje, Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $validator = $request->validate([
            'name' => 'required|string|max:255|unique:permissions'
        ]);

        $role->name = $request->name;
        $role->save();
        $role->syncPermissions($request->permissions);
        $data['success'] = true;
        $data['message'] = 'Rol actualizado.';

        return response($data, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();
        $data['success'] = true;
        $data['message'] = 'Role elminado.';
        return response($data, Response::HTTP_NO_CONTENT);
    }
}
