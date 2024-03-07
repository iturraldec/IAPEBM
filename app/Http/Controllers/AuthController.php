<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
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

		//
		public function login() {
      return view('auth.login');
		}

    //
    public function validateUser(Request $request)
    {
			//validar datos
			$credenciales = $request->only(['email', 'password']);
			if(Auth::attempt($credenciales, true)) {
				echo 'bingo...';
			}
			else {
				return redirect(route('login'));
			}
    }

		//
		public function logout(Request $request) {
			Auth::logout();
			$request->session()->invalidate();
			$request->session()->regenerateToken();

			return redirect(route('login'));
		}
}