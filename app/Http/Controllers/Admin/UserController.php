<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response ;
use Illuminate\Support\Facades\Hash;

//
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        return view('auth.users.index', compact('roles'));
    }

    //
    public function loadData()
    {
        return datatables()->of(User::orderBy('name')->get())->toJson();
    }

    //
    public function loadRoles(User $user)
    {
        $data['state'] = true;
        $data['data'] = $user->roles;
        return response($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = $request->validate([
            'document_number'  => 'required|string|max:15|unique:users',
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users'
        ]);

        $user = User::create([
            'document_number'   => $request->document_number,
            'name'              => $request->name,
            'email'             => $request->email,
            'password'          => Hash::make('password')
        ]);
        $user->syncRoles($request->roles);

        $data['status'] = true;
        $data['message'] = 'Usuario creado.';
        $data['data'] = $user;
        return response($data, Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validator = $request->validate([
            'document_number'   => 'required|string|max:15',
            'name'              => 'required|string|max:255',
            'email'             => 'required|string|email|max:255'
        ]);

        $user->document_number  = $request->document_number;
        $user->name             = $request->name;
        $user->email            = $request->email;
        $user->save();
        $user->syncRoles($request->roles);
        $data['success'] = true;
        $data['message'] = 'Usuario actualizado.';
        $data['data'] = $user;

        return response($data, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
		$data['success'] = true;
		$data['message'] = 'Usuario elminado.';

		return response($data, Response::HTTP_NO_CONTENT);
    }
}