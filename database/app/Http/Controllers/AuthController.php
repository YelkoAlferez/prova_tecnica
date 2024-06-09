<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Función para comprobar el login
     */
    public function login(Request $request)
    {
       
        // Comprobamos los campos del formulario login
        $request->validate([
            'email' => 'required',
            'password' => 'required',
            'remember' => 'nullable',
        ]);


        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        // Si existe ese usuario y la contraseña es correcta, lo redirigimos a la página de inicio
        if (Auth::attempt($credentials, $remember)) {
            return redirect()->intended('/')->withSuccess('Successful session');
        }

        // Si no existe o si la contraseña no es correcta, redirigimos al login de nuevo con un mensaje de error
        return redirect('/')
        ->withErrors([
            'password' => 'El email o la contraseña son incorrectos.',
        ])
        ->withInput();

    }

    /**
     * Función para cerrar la sesión, devuelve al formulario de inicio de sesión
     */
    public function logout()
    {
        Auth::logout();
        return view('auth.login');
    }
}
