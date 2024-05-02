<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response ;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

//
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(request()->ajax()) {
            return datatables()->of(User::orderBy('name')->with('roles')->get())->toJson();
        }
        else {
            $roles = Role::all();

            return view('admin.users.index', compact('roles'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = $request->validate([
            'code'  => 'required|string|max:15|unique:users',
            'name'  => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users'
        ]);

        $user = User::create([
            'code'      => $request->code,
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make('password')
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
        $request->validate([
            'code' => [
                'required',
                'string',
                'max:15',
                Rule::unique('users')->ignore($user->id),
            ],
            'name'  => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ]
        ]);

        $user->code     = $request->code;
        $user->name     = $request->name;
        $user->email    = $request->email;
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

    //
    public function passwordChange(Request $request)
    {
        if($request->isMethod('get')) {
            return view('auth.passwords.change');
        }
        else {
            $user = User::find(auth()->user()->id);
            $user->password = Hash::make($request->password);
            $user->save();
            $data['status'] = true;
            $data['message'] = 'Clave actualizada.';

            return response($data, 200);
        }
    }

    //
    public function passwordReset(Request $request)
    {
        if($request->isMethod('get')) {
            return view('auth.passwords.reset');
        }
        else {
            $user = User::find($request->input('id'));
            $user->password = Hash::make('password');
            $user->save();
            $data['status'] = true;
            $data['message'] = 'Clave reseteada.';
            $data['data'] = $user;

            return response($data, 200);
        }
    }

    //
    public function getByDocument(string $document)
    {
        $user = User::where('code', $document)->first();
        $data['status'] = true;
        $data['message'] = 'Usuario.';
        $data['data'] = $user;

        return response($data, 200);
    }
}