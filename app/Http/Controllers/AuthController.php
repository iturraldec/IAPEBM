<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
			$validator = $request->validate([
				'document'	=> 'required|string|max:10',
				'password' 	=> 'required|string|min:8',
			]);

			if (!$validator) {
				return redirect('/');
			}

			$credenciales = [
				'document_number' => $request->document,
				'password' 				=> $request->password
			];

			$remember = $request->filled('remember');

			if(Auth::attempt($credenciales, $remember)) {
				$request->session()->regenerate();

				return redirect()->intended('home')->withSuccess('Logueado Correctamente');
			}
			else {
				return redirect('/')->with('errorCredentials', 'Credenciales incorrectas!');
			}
    }

		//
		public function logout(Request $request) {
			Auth::logout();
			$request->session()->invalidate();
			$request->session()->regenerateToken();

			return redirect('/');
		}
}