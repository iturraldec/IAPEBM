<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response ;

class UserController extends Controller
{
    /*  //
    public function register(Request $request) {
			$validator = Validator::make($request->all(),[
				'name' => 'required|string|max:255',
				'email' => 'required|string|email|max:255|unique:users',
				'password' => 'required|string|min:8',
			]);

			if ($validator->fails()) {
				return response($validator->errors());
			}

			$user = User::create([
				'name' => $request->name,
				'email' => $request->email,
				'password' => Hash::make($request->password)
			]);

			$token = $user->createToken('auth_token')->plainTextToken;

			return response(['data' => $user, 'access_token' => $token, 'token_type' => 'Bearer']);
		}*/

	
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        echo "crear usuarios...";
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        echo "editar usuarios...";
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
    public function destroy(User $user)
    {
        $user->delete();
		$data['success'] = true;
		$data['message'] = 'Usuario elminado.';

		return response($data, Response::HTTP_NO_CONTENT);
    }
}