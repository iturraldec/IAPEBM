<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

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
        $data = $request->all();
		$mensaje = array();
        $state = 200;
        if(Permission::firstWhere('name', $data['name'])) {
			$mensaje['success'] = false;
			$mensaje['msg'] = 'El Permiso ya existe!';
            $state = 400;
		}
		else {
			Permission::Create($data);
			$mensaje['success'] = true;
			$mensaje['msg'] = 'Permiso creado!';
		}

        return response($mensaje, $state);
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
