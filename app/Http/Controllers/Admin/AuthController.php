<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
		public function login(Request $request) {
			/*if (!Auth::attempt($request->only('email', 'password'))) {
				return response(['message' => 'Unauthorized'], 401);
			}

			$user = User::where('email', $request['email'])->firstOrFail();

			$token = $user->createToken('auth_token')->plainTextToken;

			return response(['message' => 'Hi,'.$user->name,
											'access_token' => $token,
											'token_type' => 'Bearer',
											'user' => $user
							]);*/
      return view('auth.login');
		}

    //
    public function validateUser(Request $request)
    {
      echo "validando";
    }
/*
		//
		public function logout() {
			auth()->user()->tokens()->delete();

			return response(['message' => 'you have logged']);
		} */
}